<?php
require "../../controllers/AdminController.php";
$controller = new AdminController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->submitTolak($_GET['id']);
} else {
    $controller->tolak($_GET['id']);
}
