<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika belum login → tendang ke login
if (!isset($_SESSION['user'])) {
    header("Location: /pengaduan-warga-project/public/index.php");
    // atau kalau project-mu di root virtual host: header("Location: /public/index.php");
    exit;
}

// Simpan role user
$role = $_SESSION['user']['role'];

// Batas akses halaman
function cekRole($allowedRoles = []) {
    if (!in_array($_SESSION['user']['role'], $allowedRoles)) {
        echo "Akses ditolak!";
        exit;
    }
}

// CSRF Token sederhana
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
