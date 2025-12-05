<?php
require_once "../controllers/AuthController.php";

$controller = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $controller->register();
} else {
    $controller->registerForm();
}
