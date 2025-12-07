<?php
require_once __DIR__ . '/../../app/lib/helpers.php';
require_once __DIR__ . '/../../app/lib/auth.php';
require_once __DIR__ . '/../../app/config/db.php';

require_login();
$gameCode = 'reaction_time';
$gameName = 'Reaction Time';
$gameDesc = 'Paneli ndryshon ngjyrë në një moment të rastësishëm. Kliko sa më shpejt që bëhet jeshil.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($gameName) ?> | Code & Play Hub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="app-shell">

<header class="navbar">
    <div class="navbar-inner">
        <div class="navbar-left">
            <div class="nav-logo">G</div>
            <div>
                <div class="nav-title"><?= e($gameName) ?></div>
                <div class="nav-subtitle">Measure your reaction in milliseconds</div>
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

    <div class="game-panel" id="rt-root" data-game-code="<?= e($gameCode) ?>">
        <p style="font-size:13px; margin-bottom:10px;">
            Kliko <strong>Start</strong>, prit derisa paneli të bëhet jeshil, pastaj kliko sa më shpejt që mundesh.
        </p>
        <button id="rt-start" class="btn btn-primary">Start</button>
        <div id="rt-panel" style="
            margin-top:14px;
            height:130px;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#111827;
            color:#e5e7eb;
            font-weight:600;
            cursor:pointer;
            font-size:16px;
        ">
            Gati?
        </div>
        <div class="game-status" id="game-status"></div>
        <div class="game-score" id="game-score"></div>
        <p style="margin-top:8px; font-size:11px; color:#9ca3af;">
            Score ruhet automatikisht pas çdo klikimi të vlefshëm.
        </p>
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

const gameCode = document.getElementById('rt-root').dataset.gameCode;
const statusEl = document.getElementById('game-status');
const scoreEl  = document.getElementById('game-score');
const startBtn = document.getElementById('rt-start');
const panel    = document.getElementById('rt-panel');

let waiting = false;
let canClick = false;
let startTime = 0;
let best = null;

startBtn.onclick = () => {
    statusEl.textContent = 'Prit sinjalin jeshil...';
    scoreEl.textContent = '';
    panel.style.background = '#111827';
    panel.textContent = 'Prit...';
    waiting = true;
    canClick = false;

    const delay = 1000 + Math.random() * 4000;
    setTimeout(() => {
        if (!waiting) return;
        panel.style.background = '#22c55e';
        panel.style.color = '#022c22';
        panel.textContent = 'KLIKO!';
        startTime = performance.now();
        canClick = true;
        waiting = false;
    }, delay);
};

panel.onclick = () => {
    if (!canClick) {
        statusEl.textContent = 'Mos u ngut. Kliko vetëm kur paneli është jeshil.';
        return;
    }
    const end = performance.now();
    const diff = Math.round(end - startTime);
    statusEl.textContent = `Koha jote: ${diff} ms`;
    if (best === null || diff < best) {
        best = diff;
        scoreEl.textContent = `Rekordi yt: ${best} ms`;
    }
    canClick = false;
    panel.style.background = '#059669';
    panel.style.color = '#ecfdf5';
    panel.textContent = 'Kliko Start për rundin tjetër.';

    submitScore(gameCode, -diff, Math.round(diff / 1000), `reaction_ms=${diff}`);
};
</script>
</body>
</html>
