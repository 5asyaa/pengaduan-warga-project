<?php
// VIEW INI DI-LOAD DARI AdminController::selesai($id) atau submitSelesai($id)
// Variabel yang tersedia: $data (pengaduan), $fatalError (jika ada)
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_admin.php"; 
?>

<div class="admin-layout">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <span class="brand-title">Pengaduan Warga</span>
        </div>

        <nav class="admin-menu">
            <div class="admin-menu-item">
                <a href="dashboard.php">Dashboard</a>
            </div>
            <div class="admin-menu-item">
                <a href="table_pengaduan.php">Data Pengaduan Warga</a>
            </div>
        </nav>
    </aside>

    <!-- MAIN -->
    <div class="admin-main">

        <!-- HEADER -->
        <div class="admin-header">
            <div class="admin-header-left">
                <h1>Selesaikan Pengaduan</h1>
                <p class="subtitle">Unggah bukti penyelesaian dan tambahkan catatan jika diperlukan.</p>
            </div>

            <div class="admin-header-right">
                <span class="admin-role"><?= htmlspecialchars($_SESSION['user']['nama']); ?></span>
                <a href="/pengaduan-warga-project/public/logout.php" class="admin-logout-btn">Logout</a>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="admin-content">
            <div class="admin-content-inner">

                <div class="admin-card" style="max-width:900px; margin:0 auto; margin-left:-40px;">

                    <!-- ERROR JIKA UPLOAD GAGAL -->
                    <?php if (!empty($fatalError)): ?>
                        <div class="alert alert-danger" style="margin-bottom:15px;">
                            <?= htmlspecialchars($fatalError); ?>
                        </div>
                    <?php endif; ?>

                    <!-- FORM -->
                    <form
                        action="selesai.php?id=<?= htmlspecialchars($data['id']); ?>"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        <!-- FOTO BUKTI PENYELESAIAN -->
                        <div class="input-group" style="margin-bottom:20px;">
                            <label for="foto_penyelesaian"><b>Foto Bukti Penyelesaian</b></label>
                            <input
                                type="file"
                                id="foto_penyelesaian"
                                name="foto[]"
                                multiple
                                required
                                style="width:97%; padding:10px; border-radius:8px; border:1px solid #ccc;"
                            >
                            <small>Anda dapat mengunggah lebih dari satu foto.</small>
                        </div>

                        <!-- CATATAN ADMIN -->
                        <div class="input-group" style="margin-bottom:20px;">
                            <label for="catatan_admin"><b>Catatan Admin (Opsional)</b></label>
                            <textarea
                                id="catatan_admin"
                                name="catatan_admin"
                                rows="5"
                                placeholder="Tambahkan catatan penyelesaian laporan..."
                                style="width:97%; padding:10px; border-radius:8px; border:1px solid #ccc;"
                            ><?= isset($_POST['catatan_admin']) ? htmlspecialchars($_POST['catatan_admin']) : ''; ?></textarea>
                        </div>

                        <!-- BUTTONS -->
                        <div style="display:flex; justify-content:space-between; margin-top:10px;">
                            <a href="detail.php?id=<?= htmlspecialchars($data['id']); ?>" class="btn-back">
                                ← Kembali
                            </a>

                            <button
                                type="submit"
                                class="btn-small primary"
                                style="padding:12px 28px; font-size:15px; border-radius:8px; font-weight:600;"
                            > Selesaikan Pengaduan
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
