<?php
require "../../controllers/AdminController.php";

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan!");
}

$controller = new AdminController($pdo);
$controller->detail($_GET['id']);
