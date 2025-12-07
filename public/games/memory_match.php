<?php
require_once __DIR__ . '/../../app/lib/helpers.php';
require_once __DIR__ . '/../../app/lib/auth.php';
require_once __DIR__ . '/../../app/config/db.php';

require_login();
$gameCode = 'memory_match';
$gameName = 'Memory Match';
$gameDesc = 'Gjej çiftet me simbole të njëjta me sa më pak lëvizje.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($gameName) ?> | Code & Play Hub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .mm-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 8px;
            margin-top: 10px;
        }
        .mm-card {
            background: #020617;
            border-radius: 10px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            cursor: pointer;
            user-select: none;
            border: 1px solid #1f2937;
            font-size: 20px;
        }
        .mm-card.revealed {
            background: #22c55e;
            color: #022c22;
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
                <div class="nav-subtitle">Match the pairs</div>
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

    <div class="game-panel" id="mm-root" data-game-code="<?= e($gameCode) ?>">
        <p style="font-size:13px; margin-bottom:10px;">
            Kthe kartat një nga një dhe gjej çiftet. Lëvizjet më të pakta = score më i lartë.
        </p>
        <button id="mm-restart" class="btn btn-primary">Restart</button>
        <div id="mm-grid" class="mm-grid"></div>
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

const gameCode = document.getElementById('mm-root').dataset.gameCode;
const grid = document.getElementById('mm-grid');
const restartBtn = document.getElementById('mm-restart');
const statusEl = document.getElementById('game-status');
const scoreEl  = document.getElementById('game-score');

let cards = [];
let first = null;
let second = null;
let lock = false;
let moves = 0;
let matches = 0;

function setup() {
    const symbols = ['▲','◆','●','✦','★','❤','☂','♞'];
    cards = symbols.concat(symbols).map((val, idx) => ({
        key: idx,
        value: val,
        revealed: false,
        matched: false
    }));
    for (let i = cards.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [cards[i], cards[j]] = [cards[j], cards[i]];
    }
    first = null;
    second = null;
    lock = false;
    moves = 0;
    matches = 0;
    render();
    statusEl.textContent = 'Lojë e re. Fillon kërkimi i çifteve.';
    scoreEl.textContent = '';
}

function render() {
    grid.innerHTML = '';
    cards.forEach((card, index) => {
        const div = document.createElement('div');
        div.className = 'mm-card';
        if (card.revealed || card.matched) {
            div.classList.add('revealed');
            div.textContent = card.value;
        } else {
            div.textContent = '?';
        }
        div.onclick = () => onCardClick(index);
        grid.appendChild(div);
    });
}

function onCardClick(index) {
    if (lock) return;
    const card = cards[index];
    if (card.matched || card.revealed) return;

    card.revealed = true;
    render();

    if (!first) {
        first = { index, value: card.value };
    } else if (!second) {
        second = { index, value: card.value };
        moves++;

        if (first.value === second.value) {
            cards[first.index].matched = true;
            cards[second.index].matched = true;
            matches++;
            first = null;
            second = null;
            render();

            if (matches === 8) {
                statusEl.textContent = `Bravo! Perfundeve me ${moves} lëvizje.`;
                const score = Math.max(0, 220 - moves * 10);
                scoreEl.textContent = `Score: ${score}`;
                submitScore(gameCode, score, `moves=${moves}`);
            }
        } else {
            lock = true;
            setTimeout(() => {
                cards[first.index].revealed = false;
                cards[second.index].revealed = false;
                first = null;
                second = null;
                lock = false;
                render();
            }, 900);
        }
    }
}

restartBtn.onclick = setup;
setup();
</script>
</body>
</html>
