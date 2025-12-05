<?php
// $error dan $success diset dari AuthController
include __DIR__ . "/../layouts/header.php";
?>

<h2>Registrasi</h2>

<?php if (!empty($error)) : ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if (!empty($success)) : ?>
    <p style="color:green;"><?php echo $success; ?></p>
<?php endif; ?>

<form method="POST" action="register.php">
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="register">Daftar</button>
</form>

<br>
<a href="index.php">Sudah punya akun? Login</a>

<?php
include __DIR__ . "/../layouts/footer.php";
?>
