<?php
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_admin.php";
?>

<h2>Mulai Proses Pengaduan</h2>

<p><b>ID:</b> <?= $data['id']; ?></p>
<p><b>Pelapor:</b> <?= $data['nama']; ?> (<?= $data['email']; ?>)</p>
<p><b>Deskripsi:</b><br><?= nl2br($data['deskripsi']); ?></p>
<p><b>Lokasi:</b> <?= $data['lokasi']; ?></p>
<p><b>Status saat ini:</b> <?= ucfirst($data['status']); ?></p>

<?php if ($data['status'] !== 'menunggu'): ?>
    <p style="color:red;">Pengaduan ini sudah berstatus <b><?= $data['status']; ?></b>, tidak bisa di-set ulang ke proses.</p>
<?php else: ?>
    <form method="POST">
        <p>Yakin ingin memulai proses pengaduan ini dan mengubah status menjadi <b>proses</b>?</p>
        <button type="submit">Ya, mulai proses</button>
        <a href="detail.php?id=<?= $data['id']; ?>">Batal</a>
    </form>
<?php endif; ?>

<?php
include __DIR__ . "/../layouts/footer.php";
?>
