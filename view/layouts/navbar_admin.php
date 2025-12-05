<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$admin = $_SESSION['user'] ?? null;
?>
<nav style="padding:10px; background:#343a40; color:#fff;">
    <a href="/public/admin/dashboard.php" style="color:white; margin-right:20px;">
        Dashboard
    </a>

    <span style="float:right;">
        Admin |
        <a href="/public/logout.php" style="color:white;">Logout</a>
    </span>
</nav>
<br>
