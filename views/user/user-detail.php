<?php
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_user.php";
?>
        <!-- CONTENT -->
        <div class="admin-content">
            <div class="admin-content-inner">

                <div class="admin-card" style="width:100%; max-width:900px; margin:0 auto; padding:25px;">

                    <!-- Tombol kembali -->
                    <a href="dashboard.php" class="btn-back" style="margin-bottom:20px; display:inline-block;">
                        ← Kembali
                    </a>

                    <!-- TITLE -->
                    <h2 style="text-align:center; margin-bottom:10px; font-weight:700;">
                        Detail Pengaduan
                    </h2>
                    <p style="text-align:center; margin-bottom:30px; color:#666;">
                        Informasi lengkap pengaduan yang Anda kirim
                    </p>

                    <?php
                    // Nomor urut dari GET
                    $no_user = isset($_GET['no']) ? $_GET['no'] : "-";
                    ?>

                    <?php if (!$data): ?>
                        <p>Data pengaduan tidak ditemukan.</p>
                    <?php else: ?>

                        <!-- GRID INFORMASI -->
                        <div class="detail-grid">

                            <!-- ID -->
                            <div class="detail-box">
                                <div class="detail-box-title">ID Pengaduan</div>
                                <div class="detail-box-value"><?= htmlspecialchars($no_user); ?></div>
                            </div>

                            <!-- STATUS -->
                            <div class="detail-box">
                                <div class="detail-box-title">Status</div>

                                <?php
                                $status = strtolower($data['status']);
                                $badgeClass = "badge-" . $status;
                                ?>
                                <div class="detail-box-value">
                                    <span class="<?= $badgeClass ?>"><?= ucfirst($status); ?></span>
                                </div>
                            </div>

                            <!-- TANGGAL -->
                            <div class="detail-box">
                                <div class="detail-box-title">Tanggal Pengaduan</div>
                                <div class="detail-box-value">
                                    <?= htmlspecialchars($data['created_at']); ?>
                                </div>
                            </div>

                            <!-- IDENTITAS -->
                            <div class="detail-box">
                                <div class="detail-box-title">Identitas</div>
                                <div class="detail-box-value">
                                    <?= $data['identitas'] === "anonim" ? "Anonim" : htmlspecialchars($_SESSION['user']['nama']); ?>
                                </div>
                            </div>

                            <!-- DESKRIPSI -->
                            <div class="detail-box">
                                <div class="detail-box-title">Deskripsi</div>
                                <div class="detail-box-value">
                                    <?= nl2br(htmlspecialchars($data['deskripsi'])); ?>
                                </div>
                            </div>

                            <!-- LOKASI -->
                            <div class="detail-box">
                                <div class="detail-box-title">Lokasi</div>
                                <div class="detail-box-value">
                                    <?= htmlspecialchars($data['lokasi']); ?>
                                </div>
                            </div>

                        </div>

                        <!-- FOTO AWAL -->
                        <div class="foto-section">
                            <div class="foto-section-title">Foto Bukti Awal</div>
                            <div class="foto-wrapper">
                                <?php if (!empty($foto_awal)): ?>
                                    <?php foreach ($foto_awal as $f): ?>
                                        <div class="foto-item">
                                            <img src="/pengaduan-warga-project/public/assets/uploads/<?= htmlspecialchars($f['file_path']); ?>">
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Tidak ada foto bukti awal.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- FOTO PENYELESAIAN -->
                        <div class="foto-section">
                            <div class="foto-section-title">Foto Penyelesaian</div>
                            <div class="foto-wrapper">
                                <?php if (!empty($foto_selesai)): ?>
                                    <?php foreach ($foto_selesai as $f): ?>
                                        <div class="foto-item">
                                            <img src="/pengaduan-warga-project/public/assets/uploads/<?= htmlspecialchars($f['file_path']); ?>">
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Belum ada foto penyelesaian.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>

            </div>
        </div>

    </div> <!-- admin-main -->

</div> <!-- admin-layout -->

<?php include __DIR__ . "/../layouts/footer.php"; ?>
