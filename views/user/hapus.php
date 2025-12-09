<?php
include __DIR__ . "/../layouts/header.php";

// ID urut user dari dashboard
$no_urut = $_GET['no'] ?? null;
?>
<div class="admin-layout">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <span class="brand-title">Pengaduan Warga</span>
        </div>

        <nav class="admin-menu">
            <div class="admin-menu-item active">Dashboard</div>
            <div class="admin-menu-item">
                <a href="table_pengaduan.php">Table Pengaduan</a>
            </div>
        </nav>
    </aside>

    <div class="admin-main">

        <!-- HEADER -->
        <div class="admin-header">
            <div class="admin-header-left">
                <h1>Hapus Pengaduan</h1>
                <p class="subtitle">Konfirmasi sebelum menghapus laporan Anda</p>
            </div>

            <div class="admin-header-right">
                <span class="admin-role"><?= $_SESSION['user']['nama']; ?></span>
                <a href="/pengaduan-warga-project/public/logout.php" class="admin-logout-btn">Logout</a>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="admin-content">
            <div class="admin-content-inner">

                <div class="admin-card" style="max-width:700px; margin:auto;">

                    <h2 style="text-align:center; margin-bottom:25px;">
                        Konfirmasi Penghapusan
                    </h2>

                    <!-- ID URUT USER -->
                    <p><b>ID Pengaduan Anda:</b> <?= htmlspecialchars($no_urut); ?></p>

                    <p><b>Deskripsi:</b> <?= htmlspecialchars($data['deskripsi']); ?></p>
                    <p><b>Lokasi:</b> <?= htmlspecialchars($data['lokasi']); ?></p>

                    <?php if (!empty($foto_awal)) : ?>
                        <p><b>Foto Bukti:</b></p>
                        <img src="/pengaduan-warga-project/public/assets/uploads/<?= $foto_awal[0]['file_path']; ?>" 
                             width="250" style="border-radius:6px;">
                    <?php endif; ?>

                    <br><br>

                    <p style="color:#c62828; font-weight:600;">
                        ⚠ Apakah Anda yakin ingin menghapus pengaduan ini?
                        Tindakan ini <u>tidak dapat dibatalkan</u>.
                    </p>

                    <div style="display:flex; gap:10px; margin-top:20px;">

                        <!-- TOMBOL HAPUS SUDAH DIPERBAIKI -->
                        <a href="hapus.php?submit=1&id=<?= $data['id']; ?>" 
                           class="btn-small danger">
                            Hapus
                        </a>

                        <a href="dashboard.php" class="btn-small secondary">Batal</a>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
