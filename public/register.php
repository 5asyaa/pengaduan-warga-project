<?php
require "../config/database.php";

if (isset($_POST['register'])) {

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password']; // PLAIN TEXT
    $role = "user"; // user default

    // Cek email sudah dipakai?
    $cek = $pdo->prepare("SELECT email FROM users WHERE email = ?");
    $cek->execute([$email]);

    if ($cek->rowCount() > 0) {
        $error = "Email sudah terdaftar!";
    } else {

        // INSERT TANPA HASH
        $stmt = $pdo->prepare("INSERT INTO users (nama, email, password, role)
                               VALUES (?, ?, ?, ?)");
        $stmt->execute([$nama, $email, $password, $role]);

        $success = "Registrasi berhasil! Silakan login.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h2>Registrasi</h2>

<?php if (!empty($error)) : ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if (!empty($success)) : ?>
    <p style="color:green;"><?php echo $success; ?></p>
<?php endif; ?>

<form method="POST">
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="register">Daftar</button>
</form>

</body>
</html>
