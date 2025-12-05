<?php
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_user.php";
?>

<h2>Dashboard User</h2>
<p>Hai, <b><?= $_SESSION['user']['nama']; ?></b></p>

<a href="pengaduan_baru.php" class="btn">+ Buat Pengaduan</a>
<br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Deskripsi</th>
        <th>Lokasi</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($pengaduan as $p) : ?>
        <tr>
            <td><?= $p['id']; ?></td>
            <td><?= substr($p['deskripsi'], 0, 40) . "..." ?></td>
            <td><?= $p['lokasi']; ?></td>
            <td><?= $p['status']; ?></td>
            <td><a href="detail.php?id=<?= $p['id']; ?>">Detail</a>
                <?php if ($p['status'] === 'menunggu'): ?>
                    | <a href="hapus.php?id=<?= $p['id']; ?>" style="color:red;">Hapus</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
