<?php
require_once __DIR__ . '/../../app/lib/helpers.php';
require_once __DIR__ . '/../../app/lib/auth.php';
require_once __DIR__ . '/../../app/config/db.php';

require_login();

global $pdo;

// challenge id nga query string
$challengeId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($challengeId <= 0) {
    exit('Invalid challenge id.');
}

// marrim challenge nga DB
$stmt = $pdo->prepare("
    SELECT id, title, description, language, difficulty, code, correct_lines, explanation
    FROM debug_challenges
    WHERE id = :id AND is_active = 1
    LIMIT 1
");
$stmt->execute([':id' => $challengeId]);
$challenge = $stmt->fetch();

if (!$challenge) {
    exit('Challenge not found or inactive.');
}

// feedback fillestar
$feedback = [
    'is_correct'    => null,
    'selectedLines' => [],
    'correctLines'  => [],
];

// POST – useri ka bërë submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawSelected = trim($_POST['selected_lines'] ?? '');

    // parse selected lines
    $selectedLines = [];
    if ($rawSelected !== '') {
        foreach (explode(',', $rawSelected) as $part) {
            $n = (int)trim($part);
            if ($n > 0) {
                $selectedLines[] = $n;
            }
        }
    }

    // correct lines nga DB
    $correctLines = [];
    $rawCorrect = trim($challenge['correct_lines'] ?? '');
    if ($rawCorrect !== '') {
        foreach (explode(',', $rawCorrect) as $part) {
            $n = (int)trim($part);
            if ($n > 0) {
                $correctLines[] = $n;
            }
        }
    }

    // normalizim për krahasim
    $selectedLines = array_values(array_unique($selectedLines));
    $correctLines  = array_values(array_unique($correctLines));
    sort($selectedLines);
    sort($correctLines);

    $isCorrect = ($selectedLines === $correctLines);

    // ruajmë tentativën
    $stmtIns = $pdo->prepare("
        INSERT INTO debug_attempts (challenge_id, user_id, selected_lines, is_correct, response_time_seconds, submitted_at)
        VALUES (:cid, :uid, :sel, :correct, NULL, NOW())
    ");
    $stmtIns->execute([
        ':cid'     => $challenge['id'],
        ':uid'     => current_user_id(),
        ':sel'     => implode(',', $selectedLines),
        ':correct' => $isCorrect ? 1 : 0,
    ]);

    $feedback = [
        'is_correct'    => $isCorrect,
        'selectedLines' => $selectedLines,
        'correctLines'  => $correctLines,
    ];
}

// ndajmë kodin në rreshta
$codeLines = explode("\n", $challenge['code']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($challenge['title']) ?> | Debug challenge</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="app-shell">

<header class="navbar">
    <div class="navbar-inner">
        <div class="navbar-left">
            <div class="nav-logo">C</div>
            <div>
                <div class="nav-title">Debugging challenge</div>
                <div class="nav-subtitle"><?= e($challenge['language']) ?> · <?= e($challenge['difficulty']) ?></div>
            </div>
        </div>

        <nav class="navbar-links">
            <a class="nav-link" href="index.php">All challenges</a>
            <a class="nav-link" href="../dashboard.php">Dashboard</a>
            <a class="nav-link nav-link-primary" href="../logout.php">Logout</a>
        </nav>
    </div>
</header>

<main class="app-main">
    <h1 class="page-title"><?= e($challenge['title']) ?></h1>
    <p class="page-subtitle"><?= nl2br(e($challenge['description'])) ?></p>

    <?php if ($feedback['is_correct'] === true): ?>
        <div class="alert alert-success">
            ✅ Correct! You selected all buggy lines.
        </div>
    <?php elseif ($feedback['is_correct'] === false): ?>
        <div class="alert alert-error">
            ❌ Not quite. Check the highlighted lines and try again.
        </div>
    <?php endif; ?>

    <div class="game-panel">
        <form method="post" id="debug-form">
            <p style="font-size:13px; margin-bottom:8px;">
                Click on every line that you believe contains a bug. Then press <strong>Check answer</strong>.
            </p>

            <div class="code-block" id="code-block">
                <?php foreach ($codeLines as $i => $line): ?>
                    <?php
                    $lineNo = $i + 1;
                    $classes = ['code-line'];

                    $sel = in_array($lineNo, $feedback['selectedLines'], true);
                    $cor = in_array($lineNo, $feedback['correctLines'], true);

                    if ($feedback['is_correct'] === null) {
                        if ($sel) {
                            $classes[] = 'selected';
                        }
                    } else {
                        if ($cor) {
                            $classes[] = 'correct';
                        } elseif ($sel) {
                            $classes[] = 'wrong';
                        }
                    }
                    ?>
                    <div
                        class="<?= implode(' ', $classes) ?>"
                        data-line="<?= $lineNo ?>"
                        id="line-<?= $lineNo ?>"
                    >
                        <span class="code-line-number"><?= $lineNo ?></span>
                        <span class="code-line-code"><?= htmlspecialchars($line, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <input type="hidden" name="selected_lines" id="selected_lines"
                   value="<?= e(implode(',', $feedback['selectedLines'])) ?>">

            <div style="margin-top:10px; display:flex; gap:8px; align-items:center;">
                <button type="submit" class="btn btn-primary">Check answer</button>
                <button type="button" class="btn" id="clear-selection">Clear selection</button>
            </div>
        </form>
    </div>

    <h2 class="page-title" style="margin-top:24px;">Explanation</h2>
    <p class="page-subtitle">
        <?= nl2br(e($challenge['explanation'])) ?>
    </p>
</main>

<footer class="app-footer">
    Code &amp; Play Hub · Debugging · Challenge #<?= (int)$challenge['id'] ?>
</footer>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const lines = document.querySelectorAll('.code-line');
    const hidden = document.getElementById('selected_lines');
    const clearBtn = document.getElementById('clear-selection');

    const selectedSet = new Set();
    if (hidden.value.trim() !== '') {
        hidden.value.split(',').forEach(function (part) {
            const n = parseInt(part.trim(), 10);
            if (!isNaN(n) && n > 0) {
                selectedSet.add(n);
            }
        });
    }

    function updateHidden() {
        const arr = Array.from(selectedSet);
        arr.sort(function (a, b) { return a - b; });
        hidden.value = arr.join(',');
    }

    const hasFeedback = <?= $feedback['is_correct'] === null ? 'false' : 'true' ?>;

    lines.forEach(function (line) {
        const lineNo = parseInt(line.dataset.line, 10);

        if (!hasFeedback) {
            if (selectedSet.has(lineNo)) {
                line.classList.add('selected');
            }

            line.addEventListener('click', function () {
                if (selectedSet.has(lineNo)) {
                    selectedSet.delete(lineNo);
                    line.classList.remove('selected');
                } else {
                    selectedSet.add(lineNo);
                    line.classList.add('selected');
                }
                updateHidden();
            });
        }
    });

    clearBtn.addEventListener('click', function () {
        selectedSet.clear();
        lines.forEach(function (line) {
            line.classList.remove('selected', 'correct', 'wrong');
        });
        hidden.value = '';
    });
});
</script>
</body>
</html>
