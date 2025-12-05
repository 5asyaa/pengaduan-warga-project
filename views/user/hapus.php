<?php
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_user.php";
?>

<h2>Hapus Pengaduan</h2>

<p><b>ID:</b> <?= $data['id']; ?></p>
<p><b>Deskripsi:</b> <?= nl2br($data['deskripsi']); ?></p>
<p><b>Lokasi:</b> <?= $data['lokasi']; ?></p>

<p style="color:red; font-weight:bold;">
    Apakah Anda yakin ingin menghapus pengaduan ini? Tindakan ini tidak dapat dibatalkan.
</p>

<form method="POST">
    <button type="submit" style="background:red; color:white; padding:5px 10px;">Hapus</button>
    <a href="dashboard.php" style="margin-left:10px;">Batal</a>
</form>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
