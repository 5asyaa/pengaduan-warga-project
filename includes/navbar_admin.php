<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$admin = $_SESSION['user'];
?>
<nav style="padding:10px; background:#343a40; color:#fff;">
    <a href="../admin/dashboard.php" style="color:white; margin-right:20px;">
        Dashboard
    </a>

    <span style="float:right;">
        Admin |
        <a href="../logout.php" style="color:white;">Logout</a>
    </span>
</nav>
<br>
