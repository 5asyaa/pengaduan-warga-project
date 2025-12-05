<?php
// variabel $pengaduan akan dikirim dari Controller

include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_admin.php";
?>

<h2>Dashboard Admin</h2>
<p>Hai Admin, berikut daftar semua pengaduan:</p>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Pelapor</th>
        <th>Deskripsi</th>
        <th>Lokasi</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($pengaduan as $p): ?>
    <tr>
        <td><?= $p['id']; ?></td>
        <td><?= $p['nama_user']; ?></td>
        <td><?= substr($p['deskripsi'], 0, 40) . "..."; ?></td>
        <td><?= $p['lokasi']; ?></td>
        <td><?= $p['status']; ?></td>
        <td>
            <a href="/pengaduan-warga-project/public/admin/detail.php?id=<?= $p['id']; ?>">Detail</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
include __DIR__ . "/../layouts/footer.php";
?>
