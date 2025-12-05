<?php
require_once "../controllers/AuthController.php";

$controller = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $controller->login();
} else {
    $controller->loginForm();
}
