<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/User.php";

class AuthController
{
    private $pdo;
    private $userModel;

    public function __construct($pdo)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
    }

    /* ---------- LOGIN ---------- */

    // Tampilkan form login
    public function loginForm(string $error = '')
    {
        // variabel ini dikirim ke view
        $success = '';
        include __DIR__ . "/../views/auth/login.php";
    }

    // Proses login
    public function login()
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByEmail($email);

        if ($user && $this->userModel->verifyPlainPassword($password, $user['password'])) {

            $_SESSION['user'] = $user;

            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit;
        }

        // Jika gagal
        $error   = "Email atau password salah!";
        $success = '';
        include __DIR__ . "/../views/auth/login.php";
    }

    /* ---------- REGISTER ---------- */

    // Tampilkan form register
    public function registerForm(string $error = '', string $success = '')
    {
        include __DIR__ . "/../views/auth/register.php";
    }

    // Proses register
    public function register()
    {
        $nama     = trim($_POST['nama'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role     = "user"; // default

        // cek email sudah dipakai?
        $existing = $this->userModel->findByEmail($email);

        if ($existing) {
            $error   = "Email sudah terdaftar!";
            $success = '';
            include __DIR__ . "/../views/auth/register.php";
            return;
        }

        // simpan user (password tetap plaintext)
        $created = $this->userModel->createUser($nama, $email, $password, $role);

        if ($created) {
            $error   = '';
            $success = "Registrasi berhasil! Silakan login.";
        } else {
            $error   = "Terjadi kesalahan saat menyimpan data.";
            $success = '';
        }

        include __DIR__ . "/../views/auth/register.php";
    }

    /* ---------- LOGOUT ---------- */

    public function logout()
    {
        // hancurkan session dan kembali ke halaman login
        $_SESSION = [];
        session_destroy();

        header("Location: index.php");
        exit;
    }
}
