<?php
require "../../includes/auth_check.php";
cekRole(['admin']);
require "../../config/database.php";

$id = $_POST['id'];
$aksi = $_POST['aksi'];

if ($aksi == 'proses') {
    // Terima pengaduan → status PROSES
    $stmt = $pdo->prepare("UPDATE pengaduan SET status = 'proses' WHERE id = ?");
    $stmt->execute([$id]);

} elseif ($aksi == 'tolak') {
    // Tolak pengaduan
    $alasan = $_POST['alasan_penolakan'];

    $stmt = $pdo->prepare("UPDATE pengaduan 
                           SET status = 'ditolak', alasan_penolakan = ? 
                           WHERE id = ?");
    $stmt->execute([$alasan, $id]);
}

header("Location: detail.php?id=$id");
exit;
