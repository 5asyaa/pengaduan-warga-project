<?php
require_once "../../config/database.php";
require_once "../../controllers/AdminController.php";

$controller = new AdminController($pdo);

// Jika tombol submit ditekan → proses selesai
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->submitSelesai($_GET['id']);
    exit;
}

$controller->selesai($_GET['id']);
