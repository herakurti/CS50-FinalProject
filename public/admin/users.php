<?php
require_once __DIR__ . '/../../app/lib/auth.php';
require_once __DIR__ . '/../../app/lib/helpers.php';
require_admin();
require_once __DIR__ . '/../../app/config/db.php';

$errors = [];
$messages = [];

// ACTIONS
if (is_post()) {
    $action = $_POST['action'] ?? '';
    $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

    if ($userId <= 0) {
        $errors[] = 'Invalid user id.';
    } else {
        global $pdo;

        if ($action === 'make_admin') {
            $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE id = :id");
            $stmt->execute([':id' => $userId]);
            $messages[] = 'User promoted to admin.';
        } elseif ($action === 'make_user') {
            $stmt = $pdo->prepare("UPDATE users SET role = 'user' WHERE id = :id");
            $stmt->execute([':id' => $userId]);
            $messages[] = 'User demoted to regular user.';
        } elseif ($action === 'delete_user') {
            // për projektin, OK; në prod do ishte më mirë soft-delete
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute([':id' => $userId]);
            $messages[] = 'User deleted.';
        }
    }
}

global $pdo;
$stmt = $pdo->query("SELECT id, name, username, email, role, created_at, last_login FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users | Admin | Code & Play Hub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="app-shell">
    <header class="navbar">
        <div class="navbar-inner">
            <div class="navbar-left">
                <div class="nav-logo">A</div>
                <div>
                    <div class="nav-title">Admin · Users</div>
                    <div class="nav-subtitle">Manage accounts & roles</div>
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
            <h1 class="page-title">Users</h1>
            <p class="page-subtitle">Promote, demote or delete users. Only admins see this.</p>
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

        <div class="card">
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                <tr style="text-align:left; border-bottom:1px solid rgba(148,163,184,0.4);">
                    <th>ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Last login</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr style="border-bottom:1px solid rgba(30,41,59,0.8);">
                        <td><?= (int)$u['id'] ?></td>
                        <td><?= e($u['username']) ?></td>
                        <td><?= e($u['name']) ?></td>
                        <td><?= e($u['email']) ?></td>
                        <td><?= e($u['role']) ?></td>
                        <td><?= e($u['created_at']) ?></td>
                        <td><?= e($u['last_login'] ?? '—') ?></td>
                        <td>
                            <?php if ((int)$u['id'] !== current_user_id()): ?>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?= (int)$u['id'] ?>">
                                    <?php if ($u['role'] !== 'admin'): ?>
                                        <button class="btn btn-primary" name="action" value="make_admin">Make admin</button>
                                    <?php else: ?>
                                        <button class="btn btn-ghost" name="action" value="make_user">Make user</button>
                                    <?php endif; ?>
                                </form>
                                <form method="post" style="display:inline;" onsubmit="return confirm('Delete this user?');">
                                    <input type="hidden" name="user_id" value="<?= (int)$u['id'] ?>">
                                    <button class="btn btn-ghost" name="action" value="delete_user">Delete</button>
                                </form>
                            <?php else: ?>
                                <span class="card-meta">This is you</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="app-footer">
        Code &amp; Play Hub · Admin · Users
    </footer>
</div>
</body>
</html>
