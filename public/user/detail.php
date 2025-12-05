<?php
require "../../controllers/UserController.php";
$controller = new UserController($pdo);
$controller->detail($_GET['id']);
