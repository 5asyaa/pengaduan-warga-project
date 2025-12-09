<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Pengaduan.php";
require_once __DIR__ . "/../helpers/auth_check.php";

class AdminController
{
    private $model;

    public function __construct($pdo)
    {
        cekRole(['admin']); // pastikan hanya admin
        $this->model = new Pengaduan($pdo);
    }

    /* ========== DASHBOARD ========== */
    public function dashboard()
    {
        $pengaduan = $this->model->getAll();
        include __DIR__ . "/../views/admin/dashboard.php";
    }

    /* ========== DETAIL ========== */
    public function detail() {
        require_once __DIR__ . '/../models/Pengaduan.php';
        global $pdo;

        $id = $_GET["id"];

        // Buat model
        $model = new Pengaduan($pdo);

        // Ambil data pengaduan
        $pengaduan = $model->findById($id);

        // ⬇ TAMBAHKAN 2 BARIS INI AGAR FOTO MUNCUL ⬇
        $foto_awal = $model->getFotoByType($id, 'awal');
        $foto_selesai = $model->getFotoByType($id, 'penyelesaian');
        // ⬆ TAMBAHKAN 2 BARIS INI ⬆

        // Kirim semua data ke view
        $data["pengaduan"] = $pengaduan;
        $data["foto_awal"] = $foto_awal;
        $data["foto_selesai"] = $foto_selesai;

        include __DIR__ . '/../views/admin/admin-detail.php';
    }

    /* ========== PROSES ========== */

    // Tampilkan konfirmasi "mulai proses"
    public function proses($id)
    {
        $data = $this->model->findById($id);
        if (!$data) {
            die("Pengaduan tidak ditemukan.");
        }

        include __DIR__ . "/../views/admin/proses.php";
    }

    // Form proses disubmit: ubah status -> 'proses'
    public function submitProses($id)
    {
        // optional: cek CSRF token kalau mau
        $this->model->updateStatus($id, 'proses');

        header("Location: detail.php?id=" . $id);
        exit;
    }

    /* ========== SELESAI ========== */

    // Tampilkan form upload bukti penyelesaian
    public function selesai($id)
    {
        $data = $this->model->findById($id);
        if (!$data) {
            die("Pengaduan tidak ditemukan.");
        }

        $error   = '';
        $success = '';

        include __DIR__ . "/../views/admin/selesai.php";
    }

    // Terima upload bukti + ubah status -> 'selesai'
    public function submitSelesai($id)
    {
        $data = $this->model->findById($id);
        if (!$data) {
            die("Pengaduan tidak ditemukan.");
        }

        $error      = '';
        $success    = '';
        $fatalError = '';

        // jika ada file yang diupload
        if (!empty($_FILES['foto']['name'][0])) {

            $jumlah = count($_FILES['foto']['name']);
            $admin_id = $_SESSION['user']['id'];

            for ($i = 0; $i < $jumlah; $i++) {
                $nama = $_FILES['foto']['name'][$i];
                $size = $_FILES['foto']['size'][$i];
                $tmp  = $_FILES['foto']['tmp_name'][$i];

                $valid = $this->model->validasiFoto($nama, $size);
                if ($valid !== true) {
                    $error = $valid;
                    break;
                }

                $ext       = pathinfo($nama, PATHINFO_EXTENSION);
                $nama_baru = time() . "_" . rand(100, 999) . "." . $ext;

                $upload_path = $_SERVER['DOCUMENT_ROOT'] .
                    "/pengaduan-warga-project/public/assets/uploads/" . $nama_baru;

                if (move_uploaded_file($tmp, $upload_path)) {
                    $this->model->addFotoSelesai($id, $nama_baru, $admin_id);
                } else {
                    $error = "Gagal upload foto.";
                    break;
                }
            }
        }

        if (!empty($error)) {
            // gagal upload foto → jangan ubah status
            $fatalError = "Gagal menyimpan bukti penyelesaian: " . $error;
            include __DIR__ . "/../views/admin/selesai.php";
            return;
        }
        if (!empty($_POST['catatan_admin'])) {
            $this->model->saveCatatanAdmin($id, $_POST['catatan_admin']);
        }

        // kalau semua aman → ubah status jadi 'selesai'
        $this->model->updateStatus($id, 'selesai');

        header("Location: detail.php?id=" . $id);
        exit;
    }

    public function terima($id)
    {
        $this->model->updateStatus($id, 'proses');
        header("Location: detail.php?id=" . $id);
        exit;
    }

    public function tolak($id)
    {
        $data = $this->model->findById($id);
        if (!$data) die("Pengaduan tidak ditemukan.");

        include __DIR__ . "/../views/admin/tolak.php";
    }

    public function submitTolak($id)
    {
        $alasan = trim($_POST['alasan_penolakan']);

        if (empty($alasan)) {
            $error = "Alasan penolakan wajib diisi!";
            $data = $this->model->findById($id);
            include __DIR__ . "/../views/admin/tolak.php";
            return;
        }

        $this->model->saveAlasanTolak($id, $alasan);

        header("Location: detail.php?id=" . $id);
        exit;
    }
}
