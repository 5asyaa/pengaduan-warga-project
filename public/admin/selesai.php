<?php
require "../../includes/auth_check.php";
cekRole(['admin']);

require "../../includes/security.php";
require "../../includes/validation.php";
require "../../config/database.php";

if (isset($_POST['submit'])) {

    if ($_POST['token'] !== $_SESSION['csrf_token']) {
        die("CSRF Token Salah!");
    }

    $id = $_POST['id'];

    // Validasi foto
    $valid = validasiFoto($_FILES['foto']);
    if ($valid !== true) {
        die("<div style='color:red;'>$valid</div>");
    }

    // Upload foto
    $nama_file = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $ext = pathinfo($nama_file, PATHINFO_EXTENSION);

    $nama_baru = "selesai_" . time() . "_" . rand(100, 999) . "." . $ext;
    $upload_dir = "../assets/uploads/" . $nama_baru;

    if (move_uploaded_file($tmp, $upload_dir)) {

        // Simpan foto penyelesaian
        $stmt = $pdo->prepare("INSERT INTO pengaduan_foto 
            (pengaduan_id, file_path, tipe, uploaded_by)
            VALUES (?, ?, 'penyelesaian', ?)");
        $stmt->execute([$id, $nama_baru, $_SESSION['user']['id']]);

        // Update status selesai
        $pdo->prepare("UPDATE pengaduan SET status='selesai' WHERE id=?")->execute([$id]);

        header("Location: detail.php?id=$id");
        exit;
    }

    echo "Upload gagal!";
}
?>
