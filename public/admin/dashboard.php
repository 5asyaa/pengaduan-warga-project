<?php
require "../../controllers/AdminController.php";

$controller = new AdminController($pdo);
$controller->dashboard();
