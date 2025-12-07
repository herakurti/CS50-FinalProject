<?php
require_once __DIR__ . '/../../app/lib/helpers.php';
require_once __DIR__ . '/../../app/lib/auth.php';
require_once __DIR__ . '/../../app/config/db.php';

require_login();
$gameCode = 'focus_click';
$gameName = 'Focus Click';
$gameDesc = 'Kliko vetëm qelizën e shënuar jeshile. Keni disa runde për të provuar fokusin tënd.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($gameName) ?> | Code & Play Hub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .fc-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
            margin-top: 12px;
        }
        .fc-cell {
            width: 64px;
            height: 64px;
            border-radius: 999px;
            background: #020617;
            border: 1px solid #1f2937;
            cursor: pointer;
            transition: background 0.1s ease, transform 0.06s ease;
        }
        .fc-cell:hover {
            transform: translateY(-1px);
        }
        .fc-target {
            background: #22c55e;
            border-color: #16a34a;
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
                <div class="nav-subtitle">Train your focus</div>
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

    <div class="game-panel" id="fc-root" data-game-code="<?= e($gameCode) ?>">
        <p style="font-size:13px; margin-bottom:10px;">
            Kliko <strong>Start</strong>. Në çdo rund një qelizë do të bëhet jeshile. Kliko vetëm atë.
        </p>
        <button id="fc-start" class="btn btn-primary">Start</button>
        <div id="fc-grid" class="fc-grid"></div>
        <div class="game-status" id="game-status"></div>
        <div class="game-score" id="game-score"></div>
    </div>
</main>

<footer class="app-footer">
    Code &amp; Play Hub · Games · <?= e($gameName) ?>
</footer>

</div>

<script>
async function submitScore(gameCode, score, details) {
    try {
        await fetch('../api/submit_score.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                game_code: gameCode,
                score: String(score),
                details: details || ''
            })
        });
    } catch (e) {
        console.error(e);
    }
}

const gameCode = document.getElementById('fc-root').dataset.gameCode;
const startBtn = document.getElementById('fc-start');
const grid = document.getElementById('fc-grid');
const statusEl = document.getElementById('game-status');
const scoreEl  = document.getElementById('game-score');

const totalRounds = 20;
let currentRound = 0;
let score = 0;
let activeIndex = null;
let playing = false;

const cells = [];
for (let i = 0; i < 15; i++) {
    const div = document.createElement('div');
    div.className = 'fc-cell';
    div.onclick = () => onCellClick(i);
    cells.push(div);
    grid.appendChild(div);
}

function clearTargets() {
    cells.forEach(c => c.classList.remove('fc-target'));
}

function nextRound() {
    currentRound++;
    if (currentRound > totalRounds) {
        playing = false;
        clearTargets();
        statusEl.textContent = `Lojë mbaroi. Score: ${score}/${totalRounds}.`;
        scoreEl.textContent = `Score: ${score}`;
        submitScore(gameCode, score, `rounds=${totalRounds}`);
        return;
    }
    clearTargets();
    activeIndex = Math.floor(Math.random() * cells.length);
    cells[activeIndex].classList.add('fc-target');
    statusEl.textContent = `Rundi ${currentRound} nga ${totalRounds}. Kliko qelizën jeshile.`;
}

function onCellClick(index) {
    if (!playing) return;
    if (index === activeIndex) {
        score++;
        scoreEl.textContent = `Score: ${score}/${currentRound}`;
        nextRound();
    } else {
        statusEl.textContent = `Gabim. Fokusohu vetëm te qeliza jeshile. Score: ${score}/${currentRound}.`;
    }
}

startBtn.onclick = () => {
    currentRound = 0;
    score = 0;
    playing = true;
    scoreEl.textContent = '';
    nextRound();
};
</script>
</body>
</html>
