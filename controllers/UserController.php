<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Pengaduan.php";
require_once __DIR__ . "/../helpers/auth_check.php";

class UserController
{
    private $pdo;
    private $model;

    public function __construct($pdo)
    {
        cekRole(['user']);
        $this->pdo   = $pdo;
        $this->model = new Pengaduan($pdo);
    }

    // ==========================
    // DASHBOARD USER
    // ==========================
    public function dashboard()
    {
        $user_id    = $_SESSION['user']['id'];
        $pengaduan  = $this->model->getByUserId($user_id);

        include __DIR__ . "/../views/user/dashboard.php";
    }

    // ==========================
    // DETAIL PENGADUAN USER
    // ==========================
    public function detail($id)
    {
        $user_id   = $_SESSION['user']['id'];
        $data      = $this->model->getByIdForUser($id, $user_id);
        $foto_awal = $this->model->getFotoByType($id, 'awal');
        $foto_selesai = $this->model->getFotoByType($id, 'penyelesaian');

        include __DIR__ . "/../views/user/user-detail.php";
    }

    // ==========================
    // FORM BUAT PENGADUAN
    // ==========================
    public function formPengaduanBaru($error = '', $success = '')
    {
        include __DIR__ . "/../views/user/pengaduan_baru.php";
    }

    // ==========================
    // PROSES SUBMIT PENGADUAN BARU
    // ==========================
    public function submitPengaduanBaru()
    {
        if ($_POST['token'] !== $_SESSION['csrf_token']) {
            die("CSRF Token tidak valid!");
        }

        $user_id   = $_SESSION['user']['id'];
        $deskripsi = $_POST['deskripsi'];
        $lokasi    = $_POST['lokasi'];
        $identitas = $_POST['identitas'];

        $pengaduan_id = $this->model->createPengaduan($user_id, $deskripsi, $lokasi, $identitas);

        // Upload foto
        if (!empty($_FILES['foto']['name'][0])) {

            $jumlah = count($_FILES['foto']['name']);

            for ($i = 0; $i < $jumlah; $i++) {

                $nama   = $_FILES['foto']['name'][$i];
                $size   = $_FILES['foto']['size'][$i];
                $tmp    = $_FILES['foto']['tmp_name'][$i];

                // Validasi foto
                $valid = $this->model->validasiFoto($nama, $size);
                if ($valid !== true) {
                    $error = $valid;
                    break;
                }

                // Proses upload
                $ext = pathinfo($nama, PATHINFO_EXTENSION);
                $nama_baru = time() . "_" . rand(100, 999) . "." . $ext;

                $upload_path = $_SERVER['DOCUMENT_ROOT'] . "/pengaduan-warga-project/public/assets/uploads/" . $nama_baru;

                if (move_uploaded_file($tmp, $upload_path)) {
                    $this->model->addFotoAwal($pengaduan_id, $nama_baru, $user_id);
                } else {
                    $error = "Gagal upload foto.";
                    break;
                }
            }
        }

        if (!empty($error)) {
            $this->model->deletePengaduan($pengaduan_id);
            $fatal_error = "Gagal membuat pengaduan: " . $error;
            include __DIR__ . "/../views/user/pengaduan_baru.php";
            return;
        }

        $success = "Pengaduan berhasil dikirim!";
        include __DIR__ . "/../views/user/pengaduan_baru.php";
    }

    // ==========================
    // HALAMAN KONFIRMASI HAPUS
    // ==========================
    public function hapus($id)
    {
        $user_id = $_SESSION['user']['id'];
        $data = $this->model->getByIdForUser($id, $user_id);

        if (!$data) {
            die("Pengaduan tidak ditemukan atau bukan milik Anda.");
        }

        // Tidak boleh hapus jika sudah diproses admin
        if ($data['status'] !== 'menunggu') {
            die("Pengaduan tidak dapat dihapus karena sudah diproses admin.");
        }
        $foto_awal = $this->model->getFotoByType($id, 'awal');
        $foto_selesai = $this->model->getFotoByType($id, 'penyelesaian');
        include __DIR__ . "/../views/user/hapus.php";
    }

    // ==========================
    // EKSEKUSI HAPUS
    // ==========================
    public function submitHapus($id)
    {
        $user_id = $_SESSION['user']['id'];
        $data = $this->model->getByIdForUser($id, $user_id);

        if (!$data) {
            die("Pengaduan tidak ditemukan atau bukan milik Anda.");
        }

        if ($data['status'] !== 'menunggu') {
            die("Pengaduan tidak dapat dihapus karena sudah diproses admin.");
        }

        // Hapus foto bukti awal & penyelesaian (jika ada)
        $foto_awal = $this->model->getFotoByType($id, 'awal');
        $foto_selesai = $this->model->getFotoByType($id, 'penyelesaian');

        $path = $_SERVER['DOCUMENT_ROOT'] . "/pengaduan-warga-project/public/assets/uploads/";

        foreach (array_merge($foto_awal, $foto_selesai) as $f) {
            $file = $path . $f['file_path'];
            if (file_exists($file)) unlink($file);
        }

        // Hapus database
        $this->model->deletePengaduan($id);

        header("Location: dashboard.php");
        exit;
    }

}
