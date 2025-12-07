<?php
require_once __DIR__ . '/../app/lib/helpers.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Code & Play Hub</title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">

</head>
<body>
<div class="app-shell">
    <header class="navbar">
        <div class="navbar-inner">
            <div class="navbar-left">
                <div class="nav-logo">C</div>
                <div>
                    <div class="nav-title">Code &amp; Play Hub</div>
                    <div class="nav-subtitle">Mini-games &amp; Debugging Playground</div>
                </div>
            </div>
            <nav class="navbar-links">
                <?php if (is_logged_in()): ?>
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                    <a class="nav-link" href="games/index.php">Games</a>
                    <a class="nav-link" href="debug/index.php">Debugging</a>
                    <a class="nav-link" href="profile.php">Profile</a>
                    <a class="nav-link nav-link-primary" href="logout.php">Logout</a>
                <?php else: ?>
                    <a class="nav-link" href="login.php">Login</a>
                    <a class="nav-link nav-link-primary" href="register.php">Get Started</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="app-main">
        <section class="hero">
            <div>
                <h1 class="hero-main-title">
                    Practice <span>coding logic</span> through play.
                </h1>
                <p class="hero-text">
                    Play fast-paced mini-games to sharpen your reaction, memory, and pattern recognition,
                    then switch to the debugging playground to hunt down real bugs line by line.
                </p>

                <div class="hero-actions">
                    <?php if (is_logged_in()): ?>
                        <a class="btn btn-primary" href="dashboard.php">Open dashboard</a>
                        <a class="btn btn-ghost" href="games/index.php">Play a mini-game</a>
                    <?php else: ?>
                        <a class="btn btn-primary" href="register.php">Create your account</a>
                        <a class="btn btn-ghost" href="login.php">I already have an account</a>
                    <?php endif; ?>
                </div>

                <p class="hero-meta">
                    Track your scores, compare attempts, and see how your debugging skills improve over time.
                </p>
            </div>

            <div class="hero-card">
                <div class="hero-card-stat">5</div>
                <div class="hero-card-label">Mini-games available</div>
                <div class="hero-card-stat">∞</div>
                <div class="hero-card-label">Debugging attempts</div>
                <div class="hero-card-label">Everything stored in MySQL for CS50 review.</div>
            </div>
        </section>
    </main>

    <footer class="app-footer">
        Code &amp; Play Hub · CS50 Final Project
    </footer>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>
