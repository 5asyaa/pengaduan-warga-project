<?php
require "../../includes/auth_check.php";
cekRole(['admin']);
require "../../config/database.php";
require "../../includes/header.php";
require "../../includes/navbar_admin.php";
require "../../config/database.php";


// Ambil semua pengaduan
$stmt = $pdo->query("SELECT p.*, u.nama AS nama_user 
                     FROM pengaduan p 
                     JOIN users u ON p.user_id = u.id 
                     ORDER BY p.created_at ASC");
$pengaduan = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Dashboard Admin</title>
</head>
<body>

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

    <?php foreach ($pengaduan as $p) : ?>
    <tr>
        <td><?php echo $p['id']; ?></td>
        <td><?php echo $p['nama_user']; ?></td>
        <td><?php echo substr($p['deskripsi'], 0, 40) . "..."; ?></td>
        <td><?php echo $p['lokasi']; ?></td>
        <td><?php echo $p['status']; ?></td>
        <td>
            <a href="detail.php?id=<?php echo $p['id']; ?>">Detail</a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
