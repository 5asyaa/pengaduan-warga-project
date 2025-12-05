<?php
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_admin.php";
?>

<h2>Tolak Pengaduan</h2>

<p><b>ID:</b> <?= $data['id']; ?></p>
<p><b>Pelapor:</b> <?= $data['nama']; ?></p>
<p><b>Deskripsi:</b><br><?= nl2br($data['deskripsi']); ?></p>

<?php if (!empty($error)): ?>
    <p style="color:red;"><?= $error; ?></p>
<?php endif; ?>

<form method="POST">
    <label>Alasan Penolakan:</label><br>
    <textarea name="alasan_penolakan" rows="4" style="width:300px;"></textarea>
    <br><br>
    <button type="submit">Simpan</button>
    <a href="detail.php?id=<?= $data['id']; ?>">Batal</a>
</form>

<?php
include __DIR__ . "/../layouts/footer.php";
?>
