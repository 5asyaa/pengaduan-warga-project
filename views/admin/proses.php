<?php
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_admin.php";

$pengaduan = $data; // controller mengirim findById($id) sebagai $data
?>

<div class="container" style="margin-top: 30px;">

    <h2>Konfirmasi Terima Pengaduan</h2>
    <hr>

    <p><strong>ID Pengaduan:</strong> <?= htmlspecialchars($pengaduan['id']); ?></p>
    <p><strong>Nama Pengadu:</strong> <?= htmlspecialchars($pengaduan['nama']); ?></p>
    <p><strong>Deskripsi:</strong> <?= htmlspecialchars($pengaduan['deskripsi']); ?></p>

    <br>

    <p>Apakah Anda yakin ingin <strong>menerima</strong> pengaduan ini dan melanjutkannya ke status <b>proses</b>?</p>

    <div style="margin-top: 20px; display:flex; gap:10px;">

        <!-- Tombol TERIMA -->
        <a href="proses.php?id=<?= $pengaduan['id']; ?>&act=set"
           class="btn btn-success">
            Terima Pengaduan
        </a>

        <!-- Tombol Kembali -->
        <a href="detail.php?id=<?= $pengaduan['id']; ?>" 
           class="btn btn-secondary">
            Kembali
        </a>
    </div>

</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
