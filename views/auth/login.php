<?php
// $error dan $success diset dari AuthController
include __DIR__ . "/../layouts/header.php";
?>

<h2>Login Pengaduan Warga</h2>

<?php if (!empty($error)) : ?>
    <div style="color:red;"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" action="index.php">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

<br>
<a href="register.php">Belum punya akun? Daftar</a>

<?php
include __DIR__ . "/../layouts/footer.php";
?>
