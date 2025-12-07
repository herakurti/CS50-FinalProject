<?php
require_once __DIR__ . '/../../app/lib/auth.php';
require_admin();
require_once __DIR__ . '/../../app/lib/debug.php';

$errors = [];
if (is_post()) {
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        $errors[] = 'Tag name is required.';
    } else {
        global $pdo;
        try {
            $stmt = $pdo->prepare("INSERT INTO debug_tags (name) VALUES (:name)");
            $stmt->execute([':name' => $name]);
            flash('success', 'Tag created.');
            redirect('tags.php');
        } catch (PDOException $e) {
            $errors[] = 'Could not create tag (maybe it already exists).';
        }
    }
}

$tags = debug_get_tags();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tags | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="app-shell">
    <header class="navbar">
        <div class="navbar-inner">
            <div class="navbar-left">
                <div class="nav-logo">A</div>
                <div>
                    <div class="nav-title">Tags</div>
                    <div class="nav-subtitle">Debugging Playground</div>
                </div>
            </div>
            <nav class="navbar-links">
                <a class="nav-link" href="index.php">Admin home</a>
                <a class="nav-link" href="../dashboard.php">Dashboard</a>
                <a class="nav-link nav-link-primary" href="../logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="app-main">
        <div class="page-header">
            <h1 class="page-title">Tags</h1>
            <p class="page-subtitle">Create and list tags used to classify debugging challenges.</p>
        </div>

        <div class="form-card">
            <h2 class="form-title">Create new tag</h2>
            <p class="form-subtitle">Example: loops, arrays, off-by-one, conditions, etc.</p>

            <?php if ($msg = flash('success')): ?>
                <div class="alert alert-success"><?= e($msg) ?></div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $err): ?>
                        <div><?= e($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label for="name">Tag name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Save tag</button>
            </form>
        </div>

        <div style="margin-top: 24px;">
            <h2 style="margin-bottom: 8px;">Existing tags</h2>
            <ul style="list-style: none; padding-left: 0; font-size: 14px;">
                <?php foreach ($tags as $tag): ?>
                    <li style="padding: 4px 0; color: #e5e7eb;">
                        <?= e($tag['name']) ?> <span style="color:#64748b;">(ID: <?= (int)$tag['id'] ?>)</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>

    <footer class="app-footer">
        Code &amp; Play Hub · Admin · Tags
    </footer>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
