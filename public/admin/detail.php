<?php
require "../../includes/auth_check.php";
cekRole(['admin']);
require "../../config/database.php";

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan!");
}

$id = $_GET['id'];

// DATA PENGADUAN
$stmt = $pdo->prepare("SELECT p.*, u.nama, u.email 
                       FROM pengaduan p 
                       JOIN users u ON p.user_id = u.id
                       WHERE p.id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Pengaduan tidak ditemukan!");
}

// FOTO BUKTI AWAL
$stmt2 = $pdo->prepare("SELECT * FROM pengaduan_foto WHERE pengaduan_id=? AND tipe='awal'");
$stmt2->execute([$id]);
$foto_awal = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Pengaduan</title>

    <!-- FIX: CSS ADMIN PAKAI 1 FOLDER SAJA -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<!-- NAVBAR ADMIN -->
<div class="admin-navbar">
    <div>
        <a href="dashboard.php">Dashboard</a>
    </div>
    <div>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="admin-detail-container">

    <h2 class="admin-title">Detail Pengaduan</h2>

    <span class="admin-label">ID:</span> <?= $data['id']; ?>

    <span class="admin-label">Nama Pelapor:</span> <?= $data['nama']; ?>

    <span class="admin-label">Email:</span> <?= $data['email']; ?>

    <span class="admin-label">Deskripsi:</span> <?= nl2br($data['deskripsi']); ?>

    <span class="admin-label">Lokasi:</span> <?= $data['lokasi']; ?>

    <span class="admin-label">Status:</span>
    <span class="status-box status-<?= $data['status']; ?>">
        <?= ucfirst($data['status']); ?>
    </span>

    <!-- FOTO BUKTI AWAL -->
    <div class="section-box">
        <div class="section-title">Foto Bukti Awal</div>

        <?php if (count($foto_awal) == 0): ?>
            <i>Tidak ada foto.</i>
        <?php else: ?>
            <?php foreach ($foto_awal as $f): ?>
                <img class="foto-admin" src="../assets/uploads/<?= $f['file_path']; ?>">
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
