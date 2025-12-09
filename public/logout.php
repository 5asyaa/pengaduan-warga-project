<?php
require_once "../config/database.php";
require_once "../controllers/AuthController.php";

$controller = new AuthController($pdo);
$controller->logout();
