<?php
require_once __DIR__ . '/../app/lib/helpers.php';
require_once __DIR__ . '/../app/lib/auth.php';

$errors = [];

if (is_post()) {
    $name     = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $errors = register_user($name, $username, $email, $password);

    if (!$errors) {
        flash('success', 'Account created! You can now log in.');
        redirect('login.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Code & Play Hub</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="app-shell">

    <main class="app-main auth-container">
        <div class="auth-card">
            <h1 class="auth-title">Create Account</h1>

            <?php if ($msg = flash('success')): ?>
                <div class="alert alert-success"><?= e($msg) ?></div>
            <?php endif; ?>

            <?php if ($errors): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $err): ?>
                        <div><?= e($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control" name="name" required>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input class="form-control" name="username" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>

                <button class="btn btn-primary" type="submit">Register</button>

                <p class="auth-footer">
                    Already have an account?
                    <a href="login.php">Login</a>
                </p>
            </form>
        </div>
    </main>

</div>

</body>
</html>
