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
                <a href="table_pengaduan.php">Table Pengaduan</a>
            </div>
        </nav>
    </aside>

    <!-- MAIN -->
    <div class="admin-main">

        <!-- HEADER -->
        <div class="admin-header">
            <div class="admin-header-left">
                <h1>Detail Pengaduan</h1>
                <p class="subtitle">Informasi lengkap pengaduan yang Anda kirim</p>
            </div>

            <div class="admin-header-right">
                <span class="admin-role"><?= htmlspecialchars($_SESSION['user']['nama']); ?></span>
                <a href="/pengaduan-warga-project/public/logout.php" class="admin-logout-btn">Logout</a>
            </div>
        </div>
