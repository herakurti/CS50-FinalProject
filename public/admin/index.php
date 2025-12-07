<?php
require_once __DIR__ . '/../../app/lib/auth.php';
require_admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel | Code & Play Hub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="app-shell">
    <header class="navbar">
        <div class="navbar-inner">
            <div class="navbar-left">
                <div class="nav-logo">A</div>
                <div>
                    <div class="nav-title">Admin Panel</div>
                    <div class="nav-subtitle">Manage challenges and tags</div>
                </div>
            </div>
            <nav class="navbar-links">
                <a class="nav-link" href="../dashboard.php">Dashboard</a>
                <a class="nav-link" href="../games/index.php">Games</a>
                <a class="nav-link" href="../debug/index.php">Debugging</a>
                <a class="nav-link nav-link-primary" href="../logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="app-main">
        <div class="page-header">
            <h1 class="page-title">Admin Panel</h1>
            <p class="page-subtitle">Create and manage debugging challenges and tags.</p>
        </div>

        <div class="card-grid">
            <article class="card">
                <h2 class="card-title">Debugging Challenges</h2>
                <p class="card-body">Create, update, or deactivate debugging tasks.</p>
                <div class="card-actions">
                    <a class="btn btn-primary" href="challenge_form.php">Create challenge</a>
                    <a class="btn btn-ghost" href="challenge.php">View all</a>
                </div>
            </article>
            <article class="card">
                <h2 class="card-title">Tags</h2>
                <p class="card-body">Manage tags like loops, arrays, off-by-one, etc.</p>
                <div class="card-actions">
                    <a class="btn btn-primary" href="tags.php">Manage tags</a>
                </div>
            </article>
        </div>
    </main>

    <footer class="app-footer">
        Code &amp; Play Hub · Admin
    </footer>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
