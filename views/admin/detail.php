<?php
// $data, $foto_awal, $foto_selesai berasal dari Controller

include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_admin.php";
?>

<h2 class="admin-title">Detail Pengaduan</h2>

<p><strong>ID:</strong> <?= $data['id']; ?></p>
<p><strong>Nama Pelapor:</strong> <?= $data['nama']; ?></p>
<p><strong>Email:</strong> <?= $data['email']; ?></p>
<p><strong>Deskripsi:</strong> <?= nl2br($data['deskripsi']); ?></p>
<p><strong>Lokasi:</strong> <?= $data['lokasi']; ?></p>

<p><strong>Status:</strong>
    <span class="status-box status-<?= $data['status']; ?>">
        <?= ucfirst($data['status']); ?>
    </span>
</p>

<!-- ============================= -->
<!-- TOMBOL PROSES & SELESAI -->
<!-- ============================= -->
<div style="margin: 15px 0;">

<?php if ($data['status'] === 'menunggu'): ?>

    <a href="terima.php?id=<?= $data['id']; ?>" class="btn btn-success">Terima</a>
    <a href="tolak.php?id=<?= $data['id']; ?>" class="btn btn-danger">Tolak</a>

<?php elseif ($data['status'] === 'proses'): ?>

    <a href="selesai.php?id=<?= $data['id']; ?>" class="btn btn-primary">Selesai</a>

<?php elseif ($data['status'] === 'ditolak'): ?>

    <p><b>Alasan Penolakan:</b><br><?= nl2br($data['alasan_penolakan']); ?></p>

<?php endif; ?>

</div>


<!-- ============================= -->
<!-- FOTO AWAL -->
<!-- ============================= -->

<h3>Foto Bukti Awal</h3>

<?php if (empty($foto_awal)): ?>
    <i>Tidak ada foto.</i>
<?php else: ?>
    <?php foreach ($foto_awal as $f): ?>
        <img class="foto-admin" 
             src="/pengaduan-warga-project/public/assets/uploads/<?= $f['file_path']; ?>" 
             style="width:180px; margin:5px;">
    <?php endforeach; ?>
<?php endif; ?>

<!-- ============================= -->
<!-- FOTO PENYELESAIAN -->
<!-- ============================= -->

<h3>Foto Bukti Penyelesaian</h3>

<?php if (empty($foto_selesai)): ?>
    <i>Belum ada bukti penyelesaian.</i>
<?php else: ?>
    <?php foreach ($foto_selesai as $f): ?>
        <img class="foto-admin" 
             src="/pengaduan-warga-project/public/assets/uploads/<?= $f['file_path']; ?>" 
             style="width:180px; margin:5px;">
    <?php endforeach; ?>
<?php endif; ?>

<?php
include __DIR__ . "/../layouts/footer.php";
?>
