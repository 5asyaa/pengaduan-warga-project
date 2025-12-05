<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? null;
?>
<nav style="padding:10px; background:#007bff; color:#fff;">
    <a href="/public/user/dashboard.php" style="color:white; margin-right:20px;">
        Dashboard
    </a>

    <span style="float:right;">
        <?= $user['nama'] ?? '' ?> |
        <a href="/public/logout.php" style="color:white;">Logout</a>
    </span>
</nav>
<br>
