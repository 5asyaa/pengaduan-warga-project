<?php
require "../../includes/auth_check.php";
cekRole(['user']);
require "../../config/database.php";

// === Tentukan lokasi folder uploads (Wajib sesuai nama folder proyek kamu) ===
$folder_upload = $_SERVER['DOCUMENT_ROOT'] . "/pengaduan_warga/public/assets/uploads/";

// Pastikan folder uploads ada
if (!is_dir($folder_upload)) {
    die("Folder uploads tidak ditemukan! Path: " . $folder_upload);
}

// Jika form disubmit
if (isset($_POST['submit'])) {

    // Cek CSRF Token
    if ($_POST['token'] !== $_SESSION['csrf_token']) {
        die("CSRF Token tidak valid!");
    }

    $user_id = $_SESSION['user']['id'];
    $deskripsi = bersihkan($_POST['deskripsi']);
    $lokasi = bersihkan($_POST['lokasi']);
    $identitas = $_POST['identitas'];

    // SIMPAN PENGADUAN
    $stmt = $pdo->prepare("INSERT INTO pengaduan (user_id, deskripsi, lokasi, identitas)
                           VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $deskripsi, $lokasi, $identitas]);

    $pengaduan_id = $pdo->lastInsertId();

    // UPLOAD FOTO JIKA ADA
    if (!empty($_FILES['foto']['name'][0])) {

        $jumlah_foto = count($_FILES['foto']['name']);

        for ($i = 0; $i < $jumlah_foto; $i++) {

            // --- VALIDASI FOTO ---
            $valid = validasiFoto([
                'name' => $_FILES['foto']['name'][$i],
                'size' => $_FILES['foto']['size'][$i],
                'tmp_name' => $_FILES['foto']['tmp_name'][$i]
            ]);

            if ($valid !== true) {
                $error = $valid;
                break;
            }

            // --- PROSES UPLOAD ---
            $nama_asli = $_FILES['foto']['name'][$i];
            $tmp = $_FILES['foto']['tmp_name'][$i];
            $ext = pathinfo($nama_asli, PATHINFO_EXTENSION);

            // Nama file baru
            $nama_baru = time() . "_" . rand(100, 999) . "." . $ext;

            // Lokasi upload FINAL & FIX
            $upload_path = $folder_upload . $nama_baru;

            // === PROSES PINDAHKAN FILE ===
            if (move_uploaded_file($tmp, $upload_path)) {

                // Simpan nama file ke database
                $stmt2 = $pdo->prepare("INSERT INTO pengaduan_foto 
                    (pengaduan_id, file_path, tipe, uploaded_by)
                    VALUES (?, ?, 'awal', ?)");
                $stmt2->execute([$pengaduan_id, $nama_baru, $user_id]);

            } else {
                $error = "Gagal upload foto! Path gagal: " . $upload_path;
                break;
            }
        }
    }

    // Jika upload foto gagal → hapus pengaduan
    if (!empty($error)) {
        $pdo->prepare("DELETE FROM pengaduan WHERE id=?")->execute([$pengaduan_id]);
        $fatal_error = "Pengaduan gagal dikirim: " . $error;
    } else {
        $success = "Pengaduan berhasil dikirim!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pengaduan Baru</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">

<h2>Buat Pengaduan Baru</h2>

<?php if (!empty($fatal_error)): ?>
    <div style="color:red;"><?php echo $fatal_error; ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div style="color:green;"><?php echo $success; ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <label>Deskripsi:</label><br>
    <textarea name="deskripsi" required></textarea><br><br>

    <label>Lokasi Kejadian:</label><br>
    <input type="text" name="lokasi" required><br><br>

    <label>Tampilkan Identitas:</label><br>
    <select name="identitas">
        <option value="nama">Gunakan Nama</option>
        <option value="anonim">Anonim</option>
    </select><br><br>

    <label>Foto Bukti (boleh lebih dari satu):</label><br>
    <input type="file" name="foto[]" multiple><br><br>

    <button type="submit" name="submit">Kirim Pengaduan</button>

</form>

</div>

</body>
</html>
