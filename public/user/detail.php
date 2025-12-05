<?php
require "../../includes/auth_check.php";
cekRole(['user']);
require "../../config/database.php";

if (!isset($_GET['id'])) {
    die("ID Pengaduan tidak ditemukan.");
}

$id = $_GET['id'];

// Ambil data pengaduan
$stmt = $pdo->prepare("SELECT * FROM pengaduan WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Pengaduan tidak ditemukan.");
}

// Foto awal
$stmt2 = $pdo->prepare("SELECT * FROM pengaduan_foto WHERE pengaduan_id=? AND tipe='awal'");
$stmt2->execute([$id]);
$foto_awal = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Foto selesai
$stmt3 = $pdo->prepare("SELECT * FROM pengaduan_foto WHERE pengaduan_id=? AND tipe='penyelesaian'");
$stmt3->execute([$id]);
$foto_selesai = $stmt3->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Pengaduan</title>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>

<div class="user-detail-container">

    <h2 class="user-title">Detail Pengaduan</h2>

    <span class="user-label">ID Pengaduan:</span> <?= $data['id']; ?>

    <span class="user-label">Deskripsi:</span>
    <?= nl2br($data['deskripsi']); ?>

    <span class="user-label">Lokasi:</span>
    <?= $data['lokasi']; ?>

    <span class="user-label">Identitas:</span>
    <?= $data['identitas']; ?>

    <span class="user-label">Status:</span>
    <span class="user-status user-status-<?= $data['status']; ?>">
        <?= ucfirst($data['status']); ?>
    </span>

    <!-- FOTO BUKTI AWAL -->
    <div class="user-section-box">
        <div class="user-section-title">Foto Bukti Awal</div>

        <?php if (count($foto_awal) == 0): ?>
            <i>Tidak ada foto.</i>
        <?php else: ?>
            <?php foreach ($foto_awal as $f): ?>
                <img class="user-foto" src="../assets/uploads/<?= $f['file_path']; ?>">
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- FOTO BUKTI SELESAI -->
    <div class="user-section-box">
        <div class="user-section-title">Foto Bukti Penyelesaian</div>

        <?php if (count($foto_selesai) == 0): ?>
            <i>Belum ada bukti penyelesaian.</i>
        <?php else: ?>
            <?php foreach ($foto_selesai as $f): ?>
                <img class="user-foto" src="../assets/uploads/<?= $f['file_path']; ?>">
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
