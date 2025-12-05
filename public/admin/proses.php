<?php
require_once "../../controllers/AdminController.php";

if (!isset($_GET['id'])) {
    die("ID pengaduan tidak ditemukan.");
}

$controller = new AdminController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->submitProses((int) $_GET['id']);
} else {
    $controller->proses((int) $_GET['id']);
}
