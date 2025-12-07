<?php
require_once __DIR__ . '/../app/lib/helpers.php';
require_once __DIR__ . '/../app/lib/auth.php';
require_once __DIR__ . '/../app/config/db.php';

require_login();

$userId = current_user_id();
$userRole = current_user_role();

global $pdo;

// 10 seancat e fundit të user-it
$stmt = $pdo->prepare("
    SELECT gs.score,
           gs.duration_seconds,
           gs.started_at,
           gs.finished_at,
           g.name AS game_name
    FROM game_sessions gs
    JOIN games g ON gs.game_id = g.id
    WHERE gs.user_id = :uid
    ORDER BY gs.started_at DESC
    LIMIT 10
");
$stmt->execute([':uid' => $userId]);
$recentSessions = $stmt->fetchAll();

// rezultatet më të mira për çdo lojë
$stmt2 = $pdo->prepare("
    SELECT g.name AS game_name,
           MAX(gs.score) AS best_score,
           COUNT(*) AS plays
    FROM game_sessions gs
    JOIN games g ON gs.game_id = g.id
    WHERE gs.user_id = :uid
    GROUP BY gs.game_id, g.name
    ORDER BY g.name
");
$stmt2->execute([':uid' => $userId]);
$bestPerGame = $stmt2->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Code & Play Hub</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="app-shell">

<header class="navbar">
    <div class="navbar-inner">
        <div class="navbar-left">
            <div class="nav-logo">D</div>
            <div>
                <div class="nav-title">Dashboard</div>
                <div class="nav-subtitle">Welcome back!</div>
            </div>
        </div>

        <nav class="navbar-links">
            <a class="nav-link" href="games/index.php">Games</a>
            <a class="nav-link" href="debug/index.php">Debugging</a>
            <?php if ($userRole === 'admin'): ?>
                <a class="nav-link" href="admin/index.php">Admin</a>
            <?php endif; ?>
            <a class="nav-link" href="profile.php">Profile</a>
            <a class="nav-link nav-link-primary" href="logout.php">Logout</a>
        </nav>
    </div>
</header>

<main class="app-main">
    <h1 class="page-title">Your Dashboard</h1>

    <!-- Kartat kryesore -->
    <div class="card-grid">
        <article class="card">
            <h2 class="card-title">Mini Games</h2>
            <p class="card-body">See available games and your high scores.</p>
            <p><a class="btn btn-primary" href="games/index.php">Open Games</a></p>
        </article>

        <article class="card">
            <h2 class="card-title">Debugging Challenges</h2>
            <p class="card-body">Improve your skills by fixing buggy code.</p>
            <p><a class="btn btn-primary" href="debug/index.php">Open Debugging</a></p>
        </article>

        <article class="card">
            <h2 class="card-title">Profile</h2>
            <p class="card-body">Update your information and view progress.</p>
            <p><a class="btn btn-primary" href="profile.php">Open Profile</a></p>
        </article>

        <?php if ($userRole === 'admin'): ?>
            <article class="card">
                <h2 class="card-title">Admin Area</h2>
                <p class="card-body">Manage users, games and see all results.</p>
                <p>
                    <a class="btn btn-primary" href="admin/users.php">Manage Users</a>
                    <a class="btn btn-primary" href="admin/games.php">Manage Games</a>
                    <a class="btn btn-primary" href="admin/results.php">View Results</a>
                </p>
            </article>
        <?php endif; ?>
    </div>

    <!-- Rezultatet e user-it -->
    <h2 class="page-title" style="margin-top:24px;">Your best results per game</h2>
    <?php if ($bestPerGame): ?>
        <p class="page-subtitle">Përllogaritje sipas score më të lartë dhe numrit të seancave.</p>
        <div class="game-panel">
            <table>
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Best score</th>
                        <th>Plays</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($bestPerGame as $row): ?>
                    <tr>
                        <td><?= e($row['game_name']) ?></td>
                        <td><?= e($row['best_score']) ?></td>
                        <td><?= e($row['plays']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="page-subtitle">Ende nuk ke rezultate – luaj një lojë për të parë statistika.</p>
    <?php endif; ?>

    <h2 class="page-title" style="margin-top:24px;">Your last 10 sessions</h2>
    <?php if ($recentSessions): ?>
        <div class="game-panel">
            <table>
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Score</th>
                        <th>Duration (sec)</th>
                        <th>Started</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($recentSessions as $row): ?>
                    <tr>
                        <td><?= e($row['game_name']) ?></td>
                        <td><?= e($row['score']) ?></td>
                        <td><?= $row['duration_seconds'] !== null ? e($row['duration_seconds']) : '-' ?></td>
                        <td><?= e($row['started_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="page-subtitle">Nuk ka ende seanca të regjistruara.</p>
    <?php endif; ?>

</main>

<footer class="app-footer">
    Code &amp; Play Hub · Dashboard
</footer>

</div>
</body>
</html>
