<?php
include __DIR__ . "/../layouts/header.php";
?>

<div class="admin-layout">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <span class="brand-title">Pengaduan Warga</span>
        </div>

        <nav class="admin-menu">
            <div class="admin-menu-item active">
                <span class="menu-icon"></span>
                Dashboard
            </div>

            <div class="admin-menu-item">
                <span class="menu-icon"></span>
                Data Pengaduan Warga
            </div>
        </nav>
    </aside>

    <!-- MAIN AREA -->
    <div class="admin-main">

        <!-- NAVBAR -->
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

        <!-- CONTENT -->
        <main class="admin-content">
            <div class="admin-content-inner">

                <!-- HITUNG STATUS -->
                <?php
                $total = count($pengaduan);

                $pending = count(array_filter($pengaduan, fn($p) =>
                    in_array(strtolower($p['status']), ["pending", "menunggu"])
                ));

                $proses = count(array_filter($pengaduan, fn($p) =>
                    strtolower($p['status']) == "proses"
                ));

                $selesai = count(array_filter($pengaduan, fn($p) =>
                    strtolower($p['status']) == "selesai"
                ));

                $ditolak = count(array_filter($pengaduan, fn($p) =>
                    strtolower($p['status']) == "ditolak"
                ));
                ?>

                <!-- STAT CARD -->
                <section class="stat-grid">

                    <div class="stat-card total">
                        <h3>Total Pengaduan</h3>
                        <p class="stat-number"><?= $total ?></p>
                    </div>

                    <div class="stat-card pending">
                        <h3>Pending / Menunggu</h3>
                        <p class="stat-number"><?= $pending ?></p>
                    </div>

                    <div class="stat-card proses">
                        <h3>Diproses</h3>
                        <p class="stat-number"><?= $proses ?></p>
                    </div>

                    <div class="stat-card selesai">
                        <h3>Selesai</h3>
                        <p class="stat-number"><?= $selesai ?></p>
                    </div>

                    <div class="stat-card ditolak">
                        <h3>Ditolak</h3>
                        <p class="stat-number"><?= $ditolak ?></p>
                    </div>

                </section>

                <!-- TABLE -->
                <section class="admin-card">

                    <div class="admin-card-header">
                        <h2>Data Pengaduan</h2>
                        <p class="subtitle">Daftar seluruh laporan warga</p>
                    </div>

                    <div class="admin-table-wrapper">
                        <table class="admin-table">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pelapor</th>
                                    <th>Deskripsi</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if (!empty($pengaduan)) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($pengaduan as $p): ?>

                                        <?php
                                            $status = strtolower($p["status"]);
                                            $badgeClass = match ($status) {
                                                "pending", "menunggu" => "badge-pending",
                                                "proses" => "badge-proses",
                                                "selesai" => "badge-selesai",
                                                "ditolak" => "badge-ditolak",
                                                default => "badge-default"
                                            };
                                        ?>

                                        <tr>
                                            <td><?= $i++; ?></td> 
                                            <td><?= htmlspecialchars($p['nama_user']); ?></td>
                                            <td><?= htmlspecialchars(substr($p['deskripsi'], 0, 40)); ?>...</td>
                                            <td><?= htmlspecialchars($p['lokasi']); ?></td>

                                            <td>
                                                <span class="status-badge <?= $badgeClass ?>">
                                                    <?= ucfirst($status) ?>
                                                </span>
                                            </td>

                                            <td>
                                                <a href="/pengaduan-warga-project/public/admin/detail.php?id=<?= $p['id']; ?>"
                                                   class="btn-small primary">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>

                                <?php else : ?>

                                    <tr>
                                        <td colspan="6" style="text-align:center; padding:20px;">Tidak ada data.</td>
                                    </tr>

                                <?php endif ?>

                            </tbody>
                        </table>
                    </div>

                </section>

            </div>
        </main>

    </div>

</div>


<?php include __DIR__ . "/../layouts/footer.php"; ?>
