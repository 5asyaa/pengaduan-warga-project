<?php
// Proteksi halaman
require __DIR__ . "/../../includes/auth_check.php";
cekRole(['user']);

// Load header & navbar
require __DIR__ . "/../../includes/header.php";
require __DIR__ . "/../../includes/navbar_user.php";

// Panggil koneksi database (FIX PATH)
require __DIR__ . "/../../config/database.php";

// Cek apakah koneksi berhasil
if (!isset($pdo)) {
    die("<h3 style='color:red;'>ERROR: Koneksi database gagal! Variabel \$pdo tidak ditemukan.</h3>");
}

$user_id = $_SESSION['user']['id'];

// Ambil semua pengaduan user
$stmt = $pdo->prepare("SELECT * FROM pengaduan WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$pengaduan = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">

<h2>Dashboard User</h2>
<p>Selamat datang, <b><?php echo $_SESSION['user']['nama']; ?></b></p>

<a href="pengaduan_baru.php" class="btn">+ Buat Pengaduan</a>
<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Deskripsi</th>
        <th>Lokasi</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($pengaduan as $p) : ?>
        <tr>
            <td><?php echo $p['id']; ?></td>
            <td><?php echo substr($p['deskripsi'], 0, 40) . "..."; ?></td>
            <td><?php echo $p['lokasi']; ?></td>
            <td>
                <?php
                    if ($p['status'] == 'menunggu') echo "<span style='color:orange;'>Menunggu Verifikasi</span>";
                    elseif ($p['status'] == 'proses') echo "<span style='color:blue;'>Diproses</span>";
                    elseif ($p['status'] == 'ditolak') echo "<span style='color:red;'>Ditolak</span>";
                    else echo "<span style='color:green;'>Selesai</span>";
                ?>
            </td>
            <td>
                <a href="detail.php?id=<?php echo $p['id']; ?>" class="btn">Detail</a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

</div>

<?php require __DIR__ . "/../../includes/footer.php"; ?>
