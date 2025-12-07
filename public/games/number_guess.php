<?php
require_once __DIR__ . '/../../app/lib/helpers.php';
require_once __DIR__ . '/../../app/lib/auth.php';
require_once __DIR__ . '/../../app/config/db.php';

require_login();
$gameCode = 'number_guess';
$gameName = 'Number Guess';
$gameDesc = 'Gjej numrin që kompjuteri ka zgjedhur nga 1 në 100 me sa më pak tentativa.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($gameName) ?> | Code & Play Hub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .ng-input {
            max-width: 200px;
        }
        .ng-log {
            margin-top: 8px;
            font-size: 13px;
        }
        .ng-log div {
            margin-bottom: 3px;
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
                <div class="nav-subtitle">Low / High guessing game</div>
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

    <div class="game-panel" id="ng-root" data-game-code="<?= e($gameCode) ?>">
        <p style="font-size:13px; margin-bottom:10px;">
            Shkruaj një numër nga 1 deri në 100 dhe kliko <strong>Guess</strong>. Do të marrësh udhëzime “shumë i vogël / shumë i madh”.
        </p>
        <input id="ng-input" type="number" min="1" max="100" class="form-control ng-input" placeholder="1 - 100">
        <button id="ng-guess" class="btn btn-primary" style="margin-left:6px;">Guess</button>
        <div class="ng-log" id="ng-log"></div>
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

const gameCode = document.getElementById('ng-root').dataset.gameCode;
const inputEl = document.getElementById('ng-input');
const guessBtn = document.getElementById('ng-guess');
const logEl = document.getElementById('ng-log');
const statusEl = document.getElementById('game-status');
const scoreEl  = document.getElementById('game-score');

const target = 1 + Math.floor(Math.random() * 100);
let attempts = 0;
let done = false;

function addLog(text) {
    const div = document.createElement('div');
    div.textContent = text;
    logEl.appendChild(div);
}

guessBtn.onclick = () => {
    if (done) return;
    const val = parseInt(inputEl.value, 10);
    if (Number.isNaN(val)) {
        statusEl.textContent = 'Shkruaj një numër të vlefshëm.';
        return;
    }
    if (val < 1 || val > 100) {
        statusEl.textContent = 'Numri duhet të jetë mes 1 dhe 100.';
        return;
    }

    attempts++;

    if (val === target) {
        done = true;
        const score = Math.max(0, 100 - attempts * 10);
        statusEl.textContent = `Saktë! Numri ishte ${target}. Tentativa: ${attempts}.`;
        scoreEl.textContent = `Score: ${score}`;
        submitScore(gameCode, score, `attempts=${attempts}`);
    } else if (val < target) {
        addLog(`${val} është shumë i vogël.`);
        statusEl.textContent = 'Provo një numër më të madh.';
    } else {
        addLog(`${val} është shumë i madh.`);
        statusEl.textContent = 'Provo një numër më të vogël.';
    }

    inputEl.value = '';
    inputEl.focus();
};

inputEl.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        guessBtn.click();
    }
});
</script>
</body>
</html>
