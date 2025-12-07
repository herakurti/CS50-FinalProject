<?php
require_once __DIR__ . '/../../app/lib/helpers.php';
require_once __DIR__ . '/../../app/lib/auth.php';
require_once __DIR__ . '/../../app/config/db.php';

require_login();
require_admin();

global $pdo;

// lista e lojërave për dropdown
$gamesStmt = $pdo->query("SELECT id, name FROM games ORDER BY name");
$games = $gamesStmt->fetchAll();

// lista e userave për dropdown
$usersStmt = $pdo->query("SELECT id, username FROM users ORDER BY username");
$users = $usersStmt->fetchAll();

// lexo filtrat nga GET
$filterGameId = isset($_GET['game_id']) && $_GET['game_id'] !== '' ? (int)$_GET['game_id'] : null;
$filterUserId = isset($_GET['user_id']) && $_GET['user_id'] !== '' ? (int)$_GET['user_id'] : null;

$where = [];
$params = [];

if ($filterGameId) {
    $where[] = 'gs.game_id = :game_id';
    $params[':game_id'] = $filterGameId;
}
if ($filterUserId) {
    $where[] = 'gs.user_id = :user_id';
    $params[':user_id'] = $filterUserId;
}

$sql = "
    SELECT
        gs.id,
        gs.score,
        gs.duration_seconds,
        gs.started_at,
        gs.finished_at,
        u.username,
        g.name AS game_name
    FROM game_sessions gs
    JOIN users u ON gs.user_id = u.id
    JOIN games g ON gs.game_id = g.id
";

if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

$sql .= ' ORDER BY gs.started_at DESC LIMIT 200';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$sessions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Results | Admin | Code & Play Hub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="app-shell">

<header class="navbar">
    <div class="navbar-inner">
        <div class="navbar-left">
            <div class="nav-logo">A</div>
            <div>
                <div class="nav-title">Results (Admin)</div>
                <div class="nav-subtitle">View and filter all game sessions</div>
            </div>
        </div>

        <nav class="navbar-links">
            <a class="nav-link" href="index.php">Admin home</a>
            <a class="nav-link" href="../dashboard.php">User dashboard</a>
            <a class="nav-link nav-link-primary" href="../logout.php">Logout</a>
        </nav>
    </div>
</header>

<main class="app-main">
    <h1 class="page-title">Game results</h1>
    <p class="page-subtitle">
        Filtrim sipas lojës dhe/ose përdoruesit. Shfaq deri në 200 seanca më të fundit.
    </p>

    <!-- Form filtrimi -->
    <div class="game-panel" style="margin-bottom:16px;">
        <form method="get" style="display:flex; flex-wrap:wrap; gap:10px; align-items:flex-end;">
            <div class="form-group" style="min-width:200px;">
                <label for="game_id">Game</label>
                <select name="game_id" id="game_id" class="form-control">
                    <option value="">All games</option>
                    <?php foreach ($games as $g): ?>
                        <option value="<?= (int)$g['id'] ?>"
                            <?= $filterGameId === (int)$g['id'] ? 'selected' : '' ?>>
                            <?= e($g['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group" style="min-width:200px;">
                <label for="user_id">User</label>
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">All users</option>
                    <?php foreach ($users as $u): ?>
                        <option value="<?= (int)$u['id'] ?>"
                            <?= $filterUserId === (int)$u['id'] ? 'selected' : '' ?>>
                            <?= e($u['username']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>

            <div class="form-group">
                <a href="results.php" class="btn">Clear</a>
            </div>
        </form>
    </div>

    <!-- Tabela me rezultate -->
    <div class="game-panel">
        <?php if ($sessions): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Game</th>
                        <th>Score</th>
                        <th>Duration (sec)</th>
                        <th>Started</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($sessions as $s): ?>
                    <tr>
                        <td><?= (int)$s['id'] ?></td>
                        <td><?= e($s['username']) ?></td>
                        <td><?= e($s['game_name']) ?></td>
                        <td><?= e($s['score']) ?></td>
                        <td><?= $s['duration_seconds'] !== null ? e($s['duration_seconds']) : '-' ?></td>
                        <td><?= e($s['started_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="page-subtitle">Nuk ka rezultate për këtë kombinim filtrash.</p>
        <?php endif; ?>
    </div>
</main>

<footer class="app-footer">
    Code &amp; Play Hub · Admin · Results
</footer>

</div>
</body>
</html>
