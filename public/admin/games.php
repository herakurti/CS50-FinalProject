<?php
require_once __DIR__ . '/../../app/lib/auth.php';
require_once __DIR__ . '/../../app/lib/helpers.php';
require_admin();
require_once __DIR__ . '/../../app/config/db.php';

$errors = [];
$messages = [];

if (is_post()) {
    global $pdo;
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $code = trim($_POST['code'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $desc = trim($_POST['description'] ?? '');

        if ($code === '' || $name === '') {
            $errors[] = 'Code and name are required.';
        } else {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO games (code, name, description, is_active, created_at)
                    VALUES (:code, :name, :description, 1, NOW())
                ");
                $stmt->execute([
                    ':code' => $code,
                    ':name' => $name,
                    ':description' => $desc !== '' ? $desc : null,
                ]);
                $messages[] = 'Game created.';
            } catch (PDOException $e) {
                $errors[] = 'Could not create game (code might be duplicate).';
            }
        }
    } elseif ($action === 'toggle_active') {
        $id = isset($_POST['game_id']) ? (int)$_POST['game_id'] : 0;
        if ($id <= 0) {
            $errors[] = 'Invalid game id.';
        } else {
            $stmt = $pdo->prepare("UPDATE games SET is_active = 1 - is_active WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $messages[] = 'Game visibility toggled.';
        }
    } elseif ($action === 'delete') {
        $id = isset($_POST['game_id']) ? (int)$_POST['game_id'] : 0;
        if ($id <= 0) {
            $errors[] = 'Invalid game id.';
        } else {
            $stmt = $pdo->prepare("DELETE FROM games WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $messages[] = 'Game deleted.';
        }
    }
}

global $pdo;
$stmt = $pdo->query("SELECT * FROM games ORDER BY created_at DESC");
$games = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Games | Admin | Code & Play Hub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="app-shell">
    <header class="navbar">
        <div class="navbar-inner">
            <div class="navbar-left">
                <div class="nav-logo">A</div>
                <div>
                    <div class="nav-title">Admin · Games</div>
                    <div class="nav-subtitle">Manage mini games list</div>
                </div>
            </div>
            <nav class="navbar-links">
                <a class="nav-link" href="index.php">Admin Home</a>
                <a class="nav-link" href="../dashboard.php">Dashboard</a>
                <a class="nav-link nav-link-primary" href="../logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="app-main">
        <div class="page-header">
            <h1 class="page-title">Games</h1>
            <p class="page-subtitle">Create, hide/show or delete games.</p>
        </div>

        <?php if ($errors): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $err): ?>
                    <div><?= e($err) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($messages): ?>
            <div class="alert alert-success">
                <?php foreach ($messages as $msg): ?>
                    <div><?= e($msg) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <h2 class="form-title">Create new game</h2>
            <p class="form-subtitle">Define metadata. Implementation is done in PHP/JS separately.</p>

            <form method="post">
                <input type="hidden" name="action" value="create">
                <div class="form-group">
                    <label for="gcode">Code (e.g. reaction_time)</label>
                    <input id="gcode" name="code" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="gname">Name</label>
                    <input id="gname" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="gdesc">Description</label>
                    <textarea id="gdesc" name="description" class="form-control" rows="3"></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Create game</button>
            </form>
        </div>

        <div style="margin-top:24px;">
            <h2 style="margin-bottom:8px;">Existing games</h2>
            <div class="card">
                <table style="width:100%; border-collapse:collapse; font-size:13px;">
                    <thead>
                    <tr style="text-align:left; border-bottom:1px solid rgba(148,163,184,0.4);">
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Active</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($games as $g): ?>
                        <tr style="border-bottom:1px solid rgba(30,41,59,0.8);">
                            <td><?= (int)$g['id'] ?></td>
                            <td><?= e($g['code']) ?></td>
                            <td><?= e($g['name']) ?></td>
                            <td><?= $g['is_active'] ? 'yes' : 'no' ?></td>
                            <td><?= e($g['created_at']) ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="game_id" value="<?= (int)$g['id'] ?>">
                                    <button class="btn btn-ghost" name="action" value="toggle_active">
                                        <?= $g['is_active'] ? 'Deactivate' : 'Activate' ?>
                                    </button>
                                </form>
                                <form method="post" style="display:inline;" onsubmit="return confirm('Delete this game?');">
                                    <input type="hidden" name="game_id" value="<?= (int)$g['id'] ?>">
                                    <button class="btn btn-ghost" name="action" value="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <footer class="app-footer">
        Code &amp; Play Hub · Admin · Games
    </footer>
</div>
</body>
</html>
