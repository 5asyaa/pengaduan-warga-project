<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'];
?>
<nav style="padding:10px; background:#007bff; color:#fff;">
    <a href="../user/dashboard.php" style="color:white; margin-right:20px;">
        Dashboard
    </a>

    <span style="float:right;">
        <?php echo $user['nama']; ?> |
        <a href="../logout.php" style="color:white;">Logout</a>
    </span>
</nav>
<br>
