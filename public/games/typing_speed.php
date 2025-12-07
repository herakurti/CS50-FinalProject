<?php
require_once __DIR__ . '/../../app/lib/helpers.php';
require_once __DIR__ . '/../../app/lib/auth.php';
require_once __DIR__ . '/../../app/config/db.php';

require_login();
$gameCode = 'typing_speed';
$gameName = 'Typing Speed';
$gameDesc = 'Sa shpejt dhe sakt mund ta shtypësh tekstin që shfaqet?';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($gameName) ?> | Code & Play Hub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .ts-text {
            margin-top: 8px;
            padding: 10px;
            border-radius: 10px;
            background: #020617;
            border: 1px solid #1f2937;
            font-size: 13px;
        }
        .ts-input {
            width: 100%;
            margin-top: 8px;
            border-radius: 10px;
            border: 1px solid #1f2937;
            padding: 8px;
            background: #020617;
            color: #e5e7eb;
            font-size: 13px;
        }
    </style>
</head>
<body>
<div class="app-shell">

<header class="navbar">
    <div class="navbar-inner">
        <div class="navbar-left">
            <div class="nav-logo">G</div>
            <div>
                <div class="nav-title"><?= e($gameName) ?></div>
                <div class="nav-subtitle">Speed & accuracy</div>
            </div>
        </div>

        <nav class="navbar-links">
            <a class="nav-link" href="index.php">All Games</a>
            <a class="nav-link" href="../dashboard.php">Dashboard</a>
            <a class="nav-link nav-link-primary" href="../logout.php">Logout</a>
        </nav>
    </div>
</header>

<main class="app-main">
    <h1 class="page-title"><?= e($gameName) ?></h1>
    <p class="page-subtitle"><?= e($gameDesc) ?></p>

    <div class="game-panel" id="ts-root" data-game-code="<?= e($gameCode) ?>">
        <p style="font-size:13px; margin-bottom:8px;">
            Lexo tekstin, shtyp saktë dhe shpejt. Kur të mbarosh, kliko <strong>Done</strong>.
        </p>
        <div id="ts-text" class="ts-text"></div>
        <textarea id="ts-input" class="ts-input" rows="4" placeholder="Fillo këtu..."></textarea>
        <button id="ts-done" class="btn btn-primary" style="margin-top:8px;">Done</button>
        <div class="game-status" id="game-status"></div>
        <div class="game-score" id="game-score"></div>
    </div>
</main>

<footer class="app-footer">
    Code &amp; Play Hub · Games · <?= e($gameName) ?>
</footer>

</div>

<script>
async function submitScore(gameCode, score, durationSeconds, details) {
    try {
        await fetch('../api/submit_score.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                game_code: gameCode,
                score: String(score),
                duration_seconds: durationSeconds != null ? String(durationSeconds) : '',
                details: details || ''
            })
        });
    } catch (e) {
        console.error(e);
    }
}

const gameCode = document.getElementById('ts-root').dataset.gameCode;
const textEl = document.getElementById('ts-text');
const inputEl = document.getElementById('ts-input');
const doneBtn = document.getElementById('ts-done');
const statusEl = document.getElementById('game-status');
const scoreEl  = document.getElementById('game-score');

const sentences = [
    'Debugging is like solving a mystery one line at a time.',
    'Good code is written for humans to read and machines to execute.',
    'Typing speed improves when you practice a bit every day.',
    'Sometimes the hardest bug is a missing semicolon.'
];

const target = sentences[Math.floor(Math.random() * sentences.length)];
textEl.textContent = target;

let startTime = null;
let finished = false;

inputEl.addEventListener('input', () => {
    if (startTime === null && inputEl.value.length > 0) {
        startTime = performance.now();
        statusEl.textContent = 'Koha po matet...';
    }
});

function finish() {
    if (finished || startTime === null) return;
    finished = true;

    const end = performance.now();
    const seconds = (end - startTime) / 1000;

    const typed = inputEl.value;
    let correctChars = 0;
    const len = Math.min(typed.length, target.length);
    for (let i = 0; i < len; i++) {
        if (typed[i] === target[i]) correctChars++;
    }

    const cpm = Math.round((correctChars / seconds) * 60);
    const score = Math.max(0, cpm);

    statusEl.textContent = `Koha: ${seconds.toFixed(1)} sek · karaktere të sakta: ${correctChars}`;
    scoreEl.textContent = `Typing score (CPM): ${score}`;

    submitScore(gameCode, score, Math.round(seconds), `correct_chars=${correctChars}`);
}

doneBtn.onclick = finish;
inputEl.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
        e.preventDefault();
        finish();
    }
});
</script>
</body>
</html>
