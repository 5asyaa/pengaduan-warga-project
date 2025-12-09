<?php
require "../../config/database.php";
require "../../controllers/UserController.php";

$controller = new UserController($pdo);

// Jika user menekan tombol Hapus
if (isset($_GET['submit']) && isset($_GET['id'])) {
    $controller->submitHapus($_GET['id']);
    exit;
}

// Jika hanya membuka halaman konfirmasi hapus
if (isset($_GET['id'])) {
    $controller->hapus($_GET['id']);
} else {
    echo "ID tidak ditemukan.";
}
