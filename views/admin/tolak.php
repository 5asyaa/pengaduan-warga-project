<?php
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_admin.php";

$id = isset($_GET['id']) ? $_GET['id'] : '';
?>

<div class="admin-main">
    <main class="admin-content">

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
        
        <div class="detail-wrapper container" style="margin-center: 10px; max-width: 1000px; margin-left:-200px;">

            <!-- Baris atas tombol kembali -->
            <div class="detail-top-row">
                <a href="/pengaduan-warga-project/public/admin/detail.php?id=<?= htmlspecialchars($id) ?>" class="btn-back">
                    ← Kembali
                </a>
            </div>

            <!-- Judul -->
            <div class="detail-heading">
                <h1 class="detail-title">Tolak Pengaduan</h1>
                <p class="detail-subtitle">
                    Berikan alasan penolakan agar warga tahu kenapa pengaduannya ditolak.
                </p>
            </div>

            <!-- FORM -->
            <form method="POST" class="detail-form">

                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                <div class="detail-box-full">
                    <label for="alasan_penolakan" class="detail-box-label">Alasan Penolakan</label>

                    <!-- TEXTAREA **HARUS BENAR**, INI YANG MEMPERBAIKI ERROR -->
                    <textarea style="width: 96%; max-width: 960px;;
                        id="alasan_penolakan"
                        name="alasan_penolakan"
                        class="input-area"
                        required
                        placeholder="Tuliskan alasan menolak pengaduan ini secara jelas..."
                    ></textarea>
                </div>

                <div class="detail-actions">
                    <button type="submit" class="btn-danger">
                        Tolak Pengaduan
                    </button>
                </div>

            </form>

        </div>

    </main>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
