<?php
require_once __DIR__ . '/../../app/lib/helpers.php';
require_once __DIR__ . '/../../app/lib/auth.php';
require_once __DIR__ . '/../../app/config/db.php';

require_login();

global $pdo;
$stmt = $pdo->query("SELECT * FROM games WHERE is_active = 1 ORDER BY id ASC");
$games = $stmt->fetchAll();

// map code -> file
$routes = [
    'reaction_time' => 'reaction_time.php',
    'memory_match'  => 'memory_match.php',
    'typing_speed'  => 'typing_speed.php',
    'number_guess'  => 'number_guess.php',
    'focus_click'   => 'focus_click.php',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Games | Code & Play Hub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="app-shell">

    <header class="navbar">
        <div class="navbar-inner">
            <div class="navbar-left">
                <div class="nav-logo">G</div>
                <div>
                    <div class="nav-title">Mini Games</div>
                    <div class="nav-subtitle">Focus · Speed · Memory</div>
                </div>
            </div>

            <nav class="navbar-links">
                <a class="nav-link" href="../dashboard.php">Dashboard</a>
                <a class="nav-link" href="../debug/index.php">Debugging</a>
                <a class="nav-link" href="../profile.php">Profile</a>
                <a class="nav-link nav-link-primary" href="../logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="app-main">
        <h1 class="page-title">Choose a game</h1>
        <p class="page-subtitle">Secila lojë mat një aftësi tjetër – reagim, memorie, fokus, logjikë, shpejtësi shkrimi.</p>

        <div class="card-grid">
            <?php foreach ($games as $g): ?>
                <?php
                $code = $g['code'];
                if (!isset($routes[$code])) continue;
                $href = $routes[$code];
                ?>
                <article class="card">
                    <h2 class="card-title"><?= e($g['name']) ?></h2>
                    <p class="card-body"><?= e($g['description'] ?? '') ?></p>
                    <p class="card-meta">Code: <?= e($code) ?></p>
                    <p style="margin-top:8px;">
                        <a class="btn btn-primary" href="<?= e($href) ?>">Play</a>
                    </p>
                </article>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="app-footer">
        Code &amp; Play Hub · Games
    </footer>

</div>
</body>
</html>
