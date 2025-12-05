<?php
require "../../controllers/UserController.php";

$controller = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $controller->submitPengaduanBaru();
} else {
    $controller->formPengaduanBaru();
}
