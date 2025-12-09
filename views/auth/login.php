<?php include __DIR__ . "/../layouts/header.php"; ?>

<div class="auth-wrapper login">

    <div class="auth-container">

        <div class="auth-white-panel slide-left">
            <h2 class="auth-title">Sign In</h2>

            <?php if (!empty($error)) : ?>
                <div class="auth-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php" class="auth-form">

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" name="login" class="btn-primary">Sign In</button>
            </form>
        </div>

        <div class="auth-purple-panel right">
            <h2>Hello, Friend!</h2>
            <p>Create an account to explore all features.</p>
            <a href="register.php" class="btn-outline">Sign Up</a>
        </div>

    </div>

</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
