<?php
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_user.php";
?>

        <!-- CONTENT -->
        <div class="admin-content">
            <div class="admin-content-inner">

                <!-- CARD UTAMA -->
                <section class="admin-card">
                    <h2>Pengaduan Anda</h2>
                    <p class="subtitle">Daftar pengaduan yang pernah Anda kirimkan</p>

                    <a href="pengaduan_baru.php" class="btn-small primary">+ Buat Pengaduan</a>
                </section>

                <!-- TABEL RIWAYAT -->
                <section class="admin-card">

                    <h2>Riwayat Pengaduan</h2>
                    <p class="subtitle">
                        Catatan: <b><span style="color:#d19d00;">Hanya pengaduan dengan status "menunggu"</span></b> yang dapat dihapus.
                    </p>

                    <div class="admin-table-wrapper">
                        <table class="admin-table">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Deskripsi</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if (!empty($pengaduan)) : ?>
                                    <?php $no = 1; // ID urut user ?>

                                    <?php foreach ($pengaduan as $p): ?>

                                        <?php 
                                            $status = strtolower($p['status']);
                                            $badgeClass = match ($status) {
                                                "menunggu" => "badge-pending",
                                                "proses" => "badge-proses",
                                                "selesai" => "badge-selesai",
                                                "ditolak" => "badge-ditolak",
                                                default => "badge-default"
                                            };
                                        ?>

                                        <tr>
                                            <!-- ID URUT USER -->
                                            <td><?= $no; ?></td>

                                            <td><?= htmlspecialchars(substr($p['deskripsi'], 0, 40)); ?>...</td>
                                            <td><?= htmlspecialchars($p['lokasi']); ?></td>

                                            <td>
                                                <span class="status-badge <?= $badgeClass ?>">
                                                    <?= ucfirst($status) ?>
                                                </span>
                                            </td>

                                            <td style="display:flex; gap:10px;">
                                                <a href="detail.php?id=<?= $p['id']; ?>&no=<?= $no; ?>" 
                                                    class="btn-small primary">Detail</a>

                                                <?php if ($status === "menunggu"): ?>
                                                    <a href="hapus.php?id=<?= $p['id']; ?>&no=<?= $no; ?>" 
                                                       class="btn-small danger">Hapus</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <?php $no++; ?>
                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <tr>
                                        <td colspan="5" style="text-align:center; padding:20px;">
                                            Tidak ada data.
                                        </td>
                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>
                    </div>

                </section>

            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
