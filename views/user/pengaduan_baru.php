<?php
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_user.php";
?>

<h2>Buat Pengaduan Baru</h2>

<?php if (!empty($fatal_error)): ?>
    <p style="color:red;"><?= $fatal_error; ?></p>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <p style="color:green;"><?= $success; ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="token" value="<?= $_SESSION['csrf_token']; ?>">

    <label>Deskripsi:</label><br>
    <textarea name="deskripsi" required></textarea><br><br>

    <label>Lokasi:</label><br>
    <input type="text" name="lokasi" required><br><br>

    <label>Identitas:</label><br>
    <select name="identitas">
        <option value="nama">Gunakan Nama</option>
        <option value="anonim">Anonim</option>
    </select><br><br>

    <label>Foto Bukti:</label><br>
    <input type="file" name="foto[]" multiple><br><br>

    <button type="submit" name="submit">Kirim</button>
</form>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
