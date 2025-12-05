<?php
require "../../controllers/AdminController.php";
$controller = new AdminController($pdo);
$controller->terima($_GET['id']);
