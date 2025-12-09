<?php
include __DIR__ . "/../layouts/header.php";
include __DIR__ . "/../layouts/navbar_user.php";
include __DIR__ . "/alert.php"; 
?>

<!-- MAIN -->
<div class="admin-main">

    <!-- HEADER -->
    <div class="admin-header">
        <div class="admin-header-left">
            <h1>Buat Pengaduan Baru</h1>
            <p class="subtitle">Silakan isi formulir berikut dengan benar</p>
        </div>

        <div class="admin-header-right">
            <span class="admin-role"><?= htmlspecialchars($_SESSION['user']['nama']); ?></span>
            <a href="/pengaduan-warga-project/public/logout.php" class="admin-logout-btn">Logout</a>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="admin-content" style="max-width:900px; margin:0 auto; margin-left:-40px;>
        <div class="admin-content-inner">

            <div class="form-container">

                <!-- TOMBOL KEMBALI -->
                <a href="dashboard.php" class="btn-small primary" style="margin-bottom:20px; display:inline-block;">
                    ← Kembali
                </a>

                <h2 class="text-center">Form Pengaduan</h2>
                <p class="subtitle text-center">Lengkapi semua data untuk mengirim laporan</p>

                <!-- FORM -->
                <form action="pengaduan_baru_proses.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">

                    <label for="deskripsi">Deskripsi:</label>
                    <textarea name="deskripsi" id="deskripsi" required></textarea>

                    <label for="lokasi">Lokasi:</label>
                    <input type="text" name="lokasi" id="lokasi" required>

                    <label for="foto">Foto Bukti:</label>
                    <input type="file" name="foto[]" id="foto" multiple required>

                    <button type="submit" class="btn-kirim">Kirim Pengaduan</button>

                </form>

            </div>

        </div>
    </div>

</div> 
</div> 

<?php include __DIR__ . "/../layouts/footer.php"; ?>
