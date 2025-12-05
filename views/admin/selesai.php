<?php
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_admin.php";
?>

<h2>Lengkapi Bukti Penyelesaian</h2>

<p><b>ID:</b> <?= $data['id']; ?></p>
<p><b>Pelapor:</b> <?= $data['nama']; ?> (<?= $data['email']; ?>)</p>
<p><b>Deskripsi:</b><br><?= nl2br($data['deskripsi']); ?></p>
<p><b>Lokasi:</b> <?= $data['lokasi']; ?></p>
<p><b>Status saat ini:</b> <?= ucfirst($data['status']); ?></p>

<?php if (!empty($fatalError)): ?>
    <p style="color:red;"><?= $fatalError; ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Upload Foto Bukti Penyelesaian (boleh lebih dari satu):</label><br>
    <input type="file" name="foto[]" multiple><br><br>

    <button type="submit">Simpan & Tandai Selesai</button>
    <a href="detail.php?id=<?= $data['id']; ?>">Batal</a>
</form>

<?php
include __DIR__ . "/../layouts/footer.php";
?>
