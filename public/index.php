<?php
session_start();
require_once "../config/database.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Ambil user berdasarkan email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // LOGIN TANPA HASH (plaintext)
    if ($user && $password === $user['password']) {

        $_SESSION['user'] = $user;

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: user/dashboard.php");
        }
        exit;

    } else {
        $error = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Pengaduan Warga</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h2>Login Pengaduan Warga</h2>

<?php if (!empty($error)) : ?>
    <div style="color:red;"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

<br>
<a href="register.php">Belum punya akun? Daftar</a>

</body>
</html>
