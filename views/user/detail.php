<?php
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_user.php";
?>

<h2>Detail Pengaduan</h2>

<p><b>ID:</b> <?= $data['id']; ?></p>
<p><b>Deskripsi:</b> <?= nl2br($data['deskripsi']); ?></p>
<p><b>Lokasi:</b> <?= $data['lokasi']; ?></p>
<p><b>Identitas:</b> <?= $data['identitas']; ?></p>
<p><b>Status:</b> <?= ucfirst($data['status']); ?></p>

<h3>Foto Bukti Awal</h3>
<?php foreach ($foto_awal as $f): ?>
    <img src="/pengaduan-warga-project/public/assets/uploads/<?= $f['file_path']; ?>" width="150">
<?php endforeach; ?>

<h3>Foto Bukti Penyelesaian</h3>
<?php if (empty($foto_selesai)): ?>
    <i>Belum ada bukti penyelesaian.</i>
<?php else: ?>
    <?php foreach ($foto_selesai as $f): ?>
        <img src="/pengaduan-warga-project/public/assets/uploads/<?= $f['file_path']; ?>" width="150">
    <?php endforeach; ?>
<?php endif; ?>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
