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

        // Auto login dari cookie jika session kosong
        $this->autoLoginFromCookie();
    }

    /* ---------- LOGIN FORM ---------- */
    public function loginForm(string $error = '')
    {
        $success = '';
        include __DIR__ . "/../views/auth/login.php";
    }

    /* ---------- LOGIN PROCESS ---------- */
    public function login()
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByEmail($email);

        if ($user && $this->userModel->verifyPlainPassword($password, $user['password'])) {

            // Buat session login
            $_SESSION['user'] = $user;

            /* ======================================================
               AUTO LOGIN COOKIE (remember_user)
            ====================================================== */
            $token = base64_encode(json_encode([
                "email" => $user["email"]
            ]));

            setcookie("remember_user", $token, time() + (86400 * 30), "/", "", false, true);


            /* ======================================================
               LOGIN HISTORY (menyimpan semua user yang pernah login)
            ====================================================== */
            $history = [];

            if (isset($_COOKIE['login_history'])) {
                $decoded = json_decode($_COOKIE['login_history'], true);
                if (is_array($decoded)) {
                    $history = $decoded;
                }
            }

            // Tambahkan email kalau belum ada di history
            if (!in_array($user["email"], $history)) {
                $history[] = $user["email"];
            }

            // Simpan kembali ke cookie (30 hari)
            setcookie("login_history", json_encode($history), time() + (86400 * 30), "/", "", false, true);


            // Redirect sesuai role
            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit;
        }

        // Jika login gagal
        $error   = "Email atau password salah!";
        $success = '';
        include __DIR__ . "/../views/auth/login.php";
    }

    /* ---------- AUTO LOGIN FROM COOKIE ---------- */
    public function autoLoginFromCookie()
    {
        // Jika sudah punya session → tidak perlu auto login
        if (isset($_SESSION['user'])) {
            return;
        }

        if (!isset($_COOKIE['remember_user'])) {
            return;
        }

        $data = json_decode(base64_decode($_COOKIE['remember_user']), true);

        if (!$data || !isset($data['email'])) {
            return;
        }

        // Cari user berdasarkan email
        $user = $this->userModel->findByEmail($data['email']);

        if ($user) {
            $_SESSION['user'] = $user;
        }
    }

    /* ---------- REGISTER FORM ---------- */
    public function registerForm(string $error = '', string $success = '')
    {
        include __DIR__ . "/../views/auth/register.php";
    }

    /* ---------- REGISTER PROCESS ---------- */
    public function register()
    {
        $nama     = trim($_POST['nama'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role     = "user";

        $existing = $this->userModel->findByEmail($email);

        if ($existing) {
            $error   = "Email sudah terdaftar!";
            $success = '';
            include __DIR__ . "/../views/auth/register.php";
            return;
        }

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
        // Hapus session login
        $_SESSION = [];
        session_destroy();

        // Hapus auto-login cookie
        setcookie("remember_user", "", time() - 3600, "/", "", false, true);

        // Cookie login_history TIDAK dihapus
        // karena harus menyimpan riwayat user yang pernah login

        header("Location: index.php");
        exit;
    }
}
