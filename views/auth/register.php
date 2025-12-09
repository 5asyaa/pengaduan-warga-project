<?php include __DIR__ . "/../layouts/header.php"; ?>

<div class="auth-wrapper register">

    <div class="auth-container">

        <!-- LEFT: PURPLE PANEL -->
        <div class="auth-purple-panel left">
            <h2>Welcome Back!</h2>
            <p>Already have an account? Login here.</p>
            <a href="index.php" class="btn-outline">Sign In</a>
        </div>

        <!-- RIGHT: WHITE PANEL (FORM REGISTER) -->
        <div class="auth-white-panel slide-right">

            <h2 class="auth-title">Sign Up</h2>

            <?php if (!empty($error)) : ?>
                <div class="auth-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (!empty($success)) : ?>
                <div class="auth-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="register.php" class="auth-form">

                <div class="input-group">
                    <label>Nama</label>
                    <input type="text" name="nama" required>
                </div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" name="register" class="btn-primary">Sign Up</button>
            </form>
        </div>

    </div>

</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
