<?php
require "../../controllers/UserController.php";

$controller = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->submitHapus($_GET['id']);
} else {
    $controller->hapus($_GET['id']);
}
