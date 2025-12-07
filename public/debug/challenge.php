<?php
require_once __DIR__ . '/../../app/lib/auth.php';
require_login();
require_once __DIR__ . '/../../app/lib/debug.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$challenge = debug_get_challenge($id);

if (!$challenge || !$challenge['is_active']) {
    flash('error', 'Challenge not found.');
    redirect('index.php');
}

$attempt = debug_get_user_last_attempt($challenge['id'], current_user_id());

// gjithmonë fillo me kodin buggy
$initialCode  = $challenge['code'];
$initialLines = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($challenge['title']) ?> | Debugging</title>
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        .code-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1.6fr);
            gap: 16px;
            margin-top: 14px;
        }
        .mono {
            font-family: Consolas, Menlo, Monaco, monospace;
            white-space: pre;
        }
        .code-label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 4px;
        }
    </style>
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
        <div class="page-header">
            <h1 class="page-title"><?= e($challenge['title']) ?></h1>
            <p class="page-subtitle"><?= nl2br(e($challenge['description'])) ?></p>
        </div>

        <div class="code-grid">
            <!-- 1. Mark buggy lines -->
            <div class="card">
                <h2 class="card-title">1. Mark buggy lines</h2>

                <label class="code-label" for="buggy-lines-input">Buggy line numbers *</label>
                <input
                    id="buggy-lines-input"
                    class="form-control"
                    type="text"
                    placeholder="Example: 3 or 2,4"
                    value="<?= e($initialLines) ?>"
                >
            </div>

            <!-- 2. Code area -->
            <div class="card">
                <h2 class="card-title">2. Submit your fixed code</h2>
                <p class="card-meta">When your answer is correct, the fixed code will appear here automatically.</p>

                <textarea
                    id="fixed-code-input"
                    class="form-control mono"
                    rows="18"
                ><?= e($initialCode) ?></textarea>

                <div style="margin-top:10px; display:flex; gap:10px; align-items:center;">
                    <button id="btn-submit" class="btn btn-primary">Submit attempt</button>
                    <span id="debug-result" class="card-meta"></span>
                </div>
            </div>
        </div>

        <?php if ($attempt): ?>
            <div style="margin-top:18px;">
                <h2 style="font-size:14px; margin-bottom:4px;">Last attempt</h2>
                <p class="card-meta">
                    Correct: <?= $attempt['is_correct'] ? 'yes' : 'no' ?> ·
                    Selected lines: <?= e($attempt['selected_lines']) ?> ·
                    Submitted at: <?= e($attempt['submitted_at']) ?>
                </p>
            </div>
        <?php endif; ?>
    </main>
</div>

<script src="../assets/js/main.js"></script>

<script>
(() => {
    const startTime   = Date.now();
    const btn         = document.getElementById('btn-submit');
    const fixedInput  = document.getElementById('fixed-code-input');
    const linesInput  = document.getElementById('buggy-lines-input');
    const resultEl    = document.getElementById('debug-result');

    btn.addEventListener('click', async () => {

        const lines = (linesInput.value || '').trim();
        if (!lines) {
            resultEl.textContent = 'Please enter the buggy line number.';
            resultEl.style.color = '#fecaca';
            return;
        }

        const responseTime = Math.round((Date.now() - startTime) / 1000);

        try {
            const res = await fetch('../api/submit_attempt.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    challenge_id: '<?= (int)$challenge['id'] ?>',
                    selected_lines: lines,
                    response_time_seconds: String(responseTime),
                })
            });

            const data = await res.json();

            if (!data.ok) {
                resultEl.textContent = data.error || 'Something went wrong.';
                resultEl.style.color = '#fecaca';
                return;
            }

            if (data.correct) {
                resultEl.textContent = 'Correct! Showing fixed code.';
                resultEl.style.color = '#bbf7d0';

                // Shfaq FIXED CODE nga backend
                if (data.fixed_code) {
                    fixedInput.value = data.fixed_code;
                    fixedInput.readOnly = true; // për ta bllokuar editimin
                }

            } else {
                resultEl.textContent = 'Not quite. Try again.';
                resultEl.style.color = '#fecaca';
            }

        } catch (e) {
            resultEl.textContent = 'Network error.';
            resultEl.style.color = '#fecaca';
        }
    });
})();
</script>

</body>
</html>
