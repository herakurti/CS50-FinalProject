<?php
require_once __DIR__ . '/../app/lib/helpers.php';
require_once __DIR__ . '/../app/lib/auth.php';
require_once __DIR__ . '/../app/config/db.php';

require_login();
$user = find_user_by_id(current_user_id());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile | Code & Play Hub</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="app-shell">

<header class="navbar">
    <div class="navbar-inner">
        <div class="navbar-left">
            <div class="nav-logo">P</div>
            <div>
                <div class="nav-title">Profile</div>
                <div class="nav-subtitle">Account Info</div>
            </div>
        </div>

        <nav class="navbar-links">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
            <a class="nav-link nav-link-primary" href="logout.php">Logout</a>
        </nav>
    </div>
</header>

<main class="app-main">
    <h1 class="page-title"><?= e($user['username']) ?>'s Profile</h1>

    <div class="card" style="max-width:420px;">
        <h2 class="card-title">Account Details</h2>

        <p class="card-meta">Name: <?= e($user['name']) ?></p>
        <p class="card-meta">Email: <?= e($user['email']) ?></p>
        <p class="card-meta">Role: <?= e($user['role']) ?></p>
        <p class="card-meta">Joined: <?= e($user['created_at']) ?></p>
        <p class="card-meta">Last login: <?= e($user['last_login'] ?? 'Never') ?></p>
    </div>
</main>

<footer class="app-footer">
    Code &amp; Play Hub · Profile
</footer>

</div>

</body>
</html>
