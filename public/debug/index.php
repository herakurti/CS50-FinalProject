<?php
require_once __DIR__ . '/../../app/lib/auth.php';
require_login();

global $pdo;
$stmt = $pdo->query("
    SELECT dc.id, dc.title, dc.language, dc.difficulty, dc.created_at
    FROM debug_challenges dc
    WHERE dc.is_active = 1
    ORDER BY dc.created_at DESC
");
$challenges = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Debugging Playground | Code & Play Hub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="app-shell">
    <header class="navbar">
        <div class="navbar-inner">
            <div class="navbar-left">
                <div class="nav-logo">C</div>
                <div>
                    <div class="nav-title">Debugging Playground</div>
                    <div class="nav-subtitle">Find the bug, then fix it</div>
                </div>
            </div>
            <nav class="navbar-links">
                <a class="nav-link" href="../dashboard.php">Dashboard</a>
                <a class="nav-link" href="../games/index.php">Games</a>
                <a class="nav-link" href="../profile.php">Profile</a>
                <a class="nav-link nav-link-primary" href="../logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="app-main">
        <div class="page-header">
            <h1 class="page-title">Debugging Challenges</h1>
            <p class="page-subtitle">Choose a challenge, review the code, mark the buggy lines, and submit your fix.</p>
        </div>

        <div class="card-grid">
            <?php foreach ($challenges as $ch): ?>
                <article class="card">
                    <h2 class="card-title"><?= e($ch['title']) ?></h2>
                    <p class="card-meta">
                        Language: <?= e($ch['language']) ?> · Difficulty: <?= e($ch['difficulty']) ?>
                    </p>
                    <div class="card-actions">
                        <a class="btn btn-primary"
                           href="challenge.php?id=<?= (int)$ch['id'] ?>">
                            Open challenge
                        </a>
                        <span class="card-meta">Created at: <?= e($ch['created_at']) ?></span>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="app-footer">
        Code &amp; Play Hub · Debugging Playground
    </footer>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
