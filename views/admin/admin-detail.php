<?php include __DIR__ . "/../layouts/header.php"; ?>
<?php include __DIR__ . "/../layouts/navbar_admin.php"; ?>

<?php
$pengaduan    = $data["pengaduan"];
$foto_awal    = $data["foto_awal"];
$foto_selesai = $data["foto_selesai"];
$status       = trim(strtolower($pengaduan['status']));
?>

<div class="admin-main">

    <!-- TOP NAVBAR -->
    <header class="admin-header">
        <div class="admin-header-left">
            <h1>Dashboard Admin</h1>
            <p class="subtitle">Ringkasan aktivitas & data pengaduan warga</p>
        </div>
        <div class="admin-header-right">
            <span class="admin-role"><?= $_SESSION["role"] ?? "Admin" ?></span>
            <a href="/pengaduan-warga-project/public/logout.php" class="admin-logout-btn">Logout</a>
        </div>
    </header>

    <!-- CARD DETAIL -->
    <div class="container" style="margin-top:110px; max-width:1000px; margin-left:-40px;">

        <div class="card shadow-sm p-4" style="border-radius: 14px;">

            <!-- BUTTON KEMBALI -->
            <a href="dashboard.php" class="btn-kembali-admin">
                ← Kembali
            </a>

            <!-- TITLE CENTER -->
            <h2 class="text-center" style="font-weight: 700; margin-top: 10px;">
                Detail Pengaduan
            </h2>
            <p class="text-center text-muted" style="margin-top: -5px;">
                Informasi lengkap pengaduan warga
            </p>

            <hr>

            <!-- INFORMASI UTAMA -->
            <p><strong>ID Pengaduan:</strong> <?= htmlspecialchars($pengaduan['id']); ?></p>
            <p><strong>Nama Pengadu:</strong> <?= htmlspecialchars($pengaduan['nama']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($pengaduan['email']); ?></p>
            <p><strong>Deskripsi:</strong> <?= htmlspecialchars($pengaduan['deskripsi']); ?></p>

            <!-- STATUS -->
            <p><strong>Status:</strong>
                <?php if ($status === 'menunggu'): ?>
                    <span class="badge bg-warning text-dark">Menunggu</span>
                <?php elseif ($status === 'proses'): ?>
                    <span class="badge bg-primary">Proses</span>
                <?php elseif ($status === 'selesai'): ?>
                    <span class="badge bg-success">Selesai</span>
                <?php elseif ($status === 'ditolak'): ?>
                    <span class="badge bg-danger">Ditolak</span>
                <?php endif; ?>
            </p>

            <!-- CATATAN ADMIN -->
            <?php if (!empty($pengaduan['catatan_admin'])): ?>
                <p><strong>Catatan Admin:</strong> 
                    <?= htmlspecialchars($pengaduan['catatan_admin']); ?>
                </p>
            <?php endif; ?>

            <!-- ALASAN PENOLAKAN -->
            <?php if ($status === 'ditolak'): ?>
                <p><strong>Alasan Penolakan:</strong> 
                    <?= htmlspecialchars($pengaduan['alasan_penolakan'] ?? 'Tidak ada alasan'); ?>
                </p>
            <?php endif; ?>

            <br>

            <!-- FOTO BUKTI AWAL -->
            <h4 style="font-weight:600;">Foto Bukti Awal</h4>
            <div class="row">
                <?php if (!empty($foto_awal)): ?>
                    <?php foreach ($foto_awal as $f): ?>
                        <div class="col-md-4 mb-3">
                            <img src="/pengaduan-warga-project/public/assets/uploads/<?= $f['file_path']; ?>"
                                 class="img-thumbnail"
                                 style="width:260px; border-radius:10px;">
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Tidak ada foto bukti awal.</p>
                <?php endif; ?>
            </div>

            <br>

            <!-- FOTO BUKTI PENYELESAIAN -->
            <h4 style="font-weight:600;">Foto Bukti Penyelesaian</h4>
            <div class="row">
                <?php if (!empty($foto_selesai)): ?>
                    <?php foreach ($foto_selesai as $f): ?>
                        <div class="col-md-4 mb-3">
                            <img src="/pengaduan-warga-project/public/assets/uploads/<?= $f['file_path']; ?>"
                                 class="img-thumbnail"
                                 style="width:260px; border-radius:10px;">
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Belum ada foto penyelesaian.</p>
                <?php endif; ?>
            </div>

            <br>

            <!-- BUTTON AKSI -->
            <div class="d-flex gap-2 mt-2">

                <?php if ($status === 'menunggu'): ?>
                    <a href="terima.php?id=<?= $pengaduan['id']; ?>" class="btn btn-success btn-md me-2"style=" margin-right:10px;">
                        Terima
                    </a>

                    <a href="tolak.php?id=<?= $pengaduan['id']; ?>" class="btn btn-success btn-md">
                        Tolak
                    </a>

                <?php elseif ($status === 'proses'): ?>
                    <a href="selesai.php?id=<?= $pengaduan['id']; ?>" class="btn btn-primary btn-md">
                        Selesaikan
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
