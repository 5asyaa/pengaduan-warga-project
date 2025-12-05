<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Pengaduan.php";
require_once __DIR__ . "/../includes/auth_check.php";

class AdminController
{
    private $model;

    public function __construct($pdo)
    {
        cekRole(['admin']); // validasi role
        $this->model = new Pengaduan($pdo);
    }

    public function dashboard()
    {
        $pengaduan = $this->model->getAll();

        // Kirim data ke view
        include __DIR__ . "/../views/admin/dashboard.php";
    }

    public function detail($id)
    {
        $data = $this->model->findById($id);
        $foto_awal = $this->model->getFotoAwal($id);

        include __DIR__ . "/../views/admin/detail.php";
    }
}
