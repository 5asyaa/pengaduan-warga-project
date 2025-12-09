<?php
require "../../controllers/UserController.php";
$controller = new UserController($pdo);
$controller->submitPengaduanBaru();
