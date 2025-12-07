<?php
require_once __DIR__ . '/../app/lib/helpers.php';
require_once __DIR__ . '/../app/lib/auth.php';

$errors = [];

if (is_post()) {
    $identifier = trim($_POST['identifier'] ?? '');
    $password   = trim($_POST['password'] ?? '');

    $errors = login_user($identifier, $password);

    if (!$errors) {
        redirect('dashboard.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Code & Play Hub</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="app-shell">

    <main class="app-main auth-container">
        <div class="auth-card">
            <h1 class="auth-title">Login</h1>

            <?php if ($errors): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $err): ?>
                        <div><?= e($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label>Username or Email</label>
                    <input class="form-control" name="identifier" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>

                <button class="btn btn-primary" type="submit">Login</button>

                <p class="auth-footer">
                    Don’t have an account?
                    <a href="register.php">Register here</a>
                </p>
            </form>
        </div>
    </main>

</div>

</body>
</html>
