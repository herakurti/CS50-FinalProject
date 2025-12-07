<?php
require_once __DIR__ . '/../../app/lib/auth.php';
require_admin();
require_once __DIR__ . '/../../app/lib/debug.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$editing = $id !== null;

$challenge = [
    'title'         => '',
    'description'   => '',
    'language'      => 'C',
    'difficulty'    => 'easy',
    'code'          => '',
    'fixed_code'    => '',
    'correct_lines' => '',
    'explanation'   => '',
    'is_active'     => 1,
];

$selectedTagIds = [];

if ($editing) {
    $data = debug_get_challenge($id);
    if (!$data) {
        flash('error', 'Challenge not found.');
        redirect('index.php');
    }
    $challenge = $data;
    $tagsForChallenge = debug_get_tags_for_challenge($id);
    $selectedTagIds = array_map(fn($t) => (int)$t['id'], $tagsForChallenge);
}

$allTags = debug_get_tags();
$errors = [];

if (is_post()) {
    $challenge['title']         = trim($_POST['title'] ?? '');
    $challenge['description']   = trim($_POST['description'] ?? '');
    $challenge['language']      = $_POST['language'] ?? 'C';
    $challenge['difficulty']    = $_POST['difficulty'] ?? 'easy';
    $challenge['code']          = $_POST['code'] ?? '';
    $challenge['fixed_code']    = $_POST['fixed_code'] ?? '';
    $challenge['correct_lines'] = trim($_POST['correct_lines'] ?? '');
    $challenge['explanation']   = trim($_POST['explanation'] ?? '');
    $challenge['is_active']     = isset($_POST['is_active']) ? 1 : 0;
    $selectedTagIds             = array_map('intval', $_POST['tags'] ?? []);

    if ($challenge['title'] === '' ||
        $challenge['description'] === '' ||
        $challenge['code'] === '' ||
        $challenge['fixed_code'] === '' ||
        $challenge['correct_lines'] === '' ||
        $challenge['explanation'] === '') {
        $errors[] = 'All required fields must be filled.';
    }

    if (empty($errors)) {
        $newId = debug_save_challenge($challenge, $editing ? $id : null);
        debug_save_tags_for_challenge($newId, $selectedTagIds);
        flash('success', $editing ? 'Challenge updated.' : 'Challenge created.');
        redirect('challenge.php?id=' . $newId);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $editing ? 'Edit' : 'Create' ?> Challenge | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="app-shell">
    <header class="navbar">
        <div class="navbar-inner">
            <div class="navbar-left">
                <div class="nav-logo">A</div>
                <div>
                    <div class="nav-title"><?= $editing ? 'Edit challenge' : 'New challenge' ?></div>
                    <div class="nav-subtitle">Debugging Playground</div>
                </div>
            </div>
            <nav class="navbar-links">
                <a class="nav-link" href="index.php">Admin home</a>
                <a class="nav-link" href="../debug/index.php">Debugging</a>
                <a class="nav-link nav-link-primary" href="../logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="app-main">
        <div class="form-card" style="max-width: 800px;">
            <h1 class="form-title"><?= $editing ? 'Edit challenge' : 'Create challenge' ?></h1>
            <p class="form-subtitle">Define the buggy code, the fixed code, and which lines contain bugs.</p>

            <?php if ($msg = flash('success')): ?>
                <div class="alert alert-success"><?= e($msg) ?></div>
            <?php endif; ?>

            <?php if ($msg = flash('error')): ?>
                <div class="alert alert-error"><?= e($msg) ?></div>
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
                    <label for="title">Title *</label>
                    <input id="title" name="title" class="form-control"
                           value="<?= e($challenge['title']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" class="form-control" rows="3" required><?= e($challenge['description']) ?></textarea>
                </div>

                <div class="form-group" style="display:flex; gap:10px;">
                    <div style="flex:1;">
                        <label for="language">Language</label>
                        <select id="language" name="language" class="form-control">
                            <option value="C" <?= $challenge['language'] === 'C' ? 'selected' : '' ?>>C</option>
                            <option value="Python" <?= $challenge['language'] === 'Python' ? 'selected' : '' ?>>Python</option>
                            <option value="Pseudocode" <?= $challenge['language'] === 'Pseudocode' ? 'selected' : '' ?>>Pseudocode</option>
                        </select>
                    </div>
                    <div style="flex:1;">
                        <label for="difficulty">Difficulty</label>
                        <select id="difficulty" name="difficulty" class="form-control">
                            <option value="easy" <?= $challenge['difficulty'] === 'easy' ? 'selected' : '' ?>>easy</option>
                            <option value="medium" <?= $challenge['difficulty'] === 'medium' ? 'selected' : '' ?>>medium</option>
                            <option value="hard" <?= $challenge['difficulty'] === 'hard' ? 'selected' : '' ?>>hard</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="code">Buggy code *</label>
                    <textarea id="code" name="code" class="form-control" rows="8" required><?= e($challenge['code']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="fixed_code">Fixed code (correct version) *</label>
                    <textarea id="fixed_code" name="fixed_code" class="form-control" rows="8" required><?= e($challenge['fixed_code']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="correct_lines">Correct lines (comma-separated, e.g. 2,4,6) *</label>
                    <input id="correct_lines" name="correct_lines" class="form-control"
                           value="<?= e($challenge['correct_lines']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="explanation">Explanation *</label>
                    <textarea id="explanation" name="explanation" class="form-control" rows="4" required><?= e($challenge['explanation']) ?></textarea>
                </div>

                <div class="form-group">
                    <label>Tags</label>
                    <select name="tags[]" class="form-control" multiple size="5">
                        <?php foreach ($allTags as $tag): ?>
                            <option value="<?= (int)$tag['id'] ?>"
                                <?= in_array((int)$tag['id'], $selectedTagIds, true) ? 'selected' : '' ?>>
                                <?= e($tag['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" id="is_active" name="is_active" <?= $challenge['is_active'] ? 'checked' : '' ?>>
                    <label for="is_active">Active challenge</label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <?= $editing ? 'Update challenge' : 'Create challenge' ?>
                </button>
                <?php if ($editing): ?>
                    <a href="challenge.php?id=<?= (int)$id ?>" class="btn btn-ghost">View challenge</a>
                <?php endif; ?>
            </form>
        </div>
    </main>

    <footer class="app-footer">
        Code &amp; Play Hub · Admin · Challenge form
    </footer>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
