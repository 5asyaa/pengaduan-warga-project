<?php
// $data dan $foto_awal berasal dari Controller

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

<h3>Foto Bukti Awal</h3>

<?php if (empty($foto_awal)): ?>
    <i>Tidak ada foto.</i>
<?php else: ?>
    <?php foreach ($foto_awal as $f): ?>
        <img class="foto-admin" src="/assets/uploads/<?= $f['file_path']; ?>" style="width:180px; margin:5px;">
    <?php endforeach; ?>
<?php endif; ?>

<?php
include __DIR__ . "/../layouts/footer.php";
?>
