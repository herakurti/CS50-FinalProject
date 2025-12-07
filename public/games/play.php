<?php
require_once __DIR__ . '/../../app/lib/auth.php';
require_login();
require_once __DIR__ . '/../../app/lib/games.php';

$code = $_GET['game'] ?? '';
$game = games_get_by_code($code);

if (!$game) {
    flash('error', 'Game not found.');
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($game['name']) ?> | Mini Game</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .game-panel {
            margin-top: 20px;
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(0, 1.2fr);
            gap: 20px;
            align-items: flex-start;
        }
        .reaction-box {
            width: 100%;
            height: 220px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #111827;
            color: #9ca3af;
            font-size: 18px;
            cursor: pointer;
            user-select: none;
            transition: background 0.15s ease-out, color 0.15s ease-out;
        }
        .reaction-box.ready {
            background: #0f172a;
        }
        .reaction-box.waiting {
            background: #111827;
        }
        .reaction-box.go {
            background: #16a34a;
            color: #022c22;
        }
        .leaderboard-list {
            list-style: none;
            padding-left: 0;
            font-size: 14px;
        }
        .leaderboard-list li {
            padding: 3px 0;
            color: #e5e7eb;
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
                    <div class="nav-title"><?= e($game['name']) ?></div>
                    <div class="nav-subtitle"><?= e($game['code']) ?></div>
                </div>
            </div>
            <nav class="navbar-links">
                <a class="nav-link" href="index.php">All games</a>
                <a class="nav-link" href="../dashboard.php">Dashboard</a>
                <a class="nav-link nav-link-primary" href="../logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="app-main">
        <div class="page-header">
            <h1 class="page-title"><?= e($game['name']) ?></h1>
            <p class="page-subtitle"><?= e($game['description'] ?? '') ?></p>
        </div>

        <div class="game-panel">
            <div class="card">
                <?php if ($game['code'] === 'reaction_time'): ?>
                    <h2 class="card-title">Reaction Time Test</h2>
                    <p class="card-meta">Click the box as soon as it turns green. Your best times are stored.</p>

                    <div id="reaction-box" class="reaction-box waiting">
                        Click here to start
                    </div>

                    <div style="margin-top:10px;">
                        <p class="card-meta" id="reaction-status">Press once to arm the test.</p>
                        <p class="card-meta">Last result: <span id="reaction-last">–</span> ms</p>
                        <p class="card-meta">Best in this session: <span id="reaction-best">–</span> ms</p>
                    </div>
                <?php else: ?>
                    <p class="card-body">This game is not implemented yet. You can still have it described in README.</p>
                <?php endif; ?>
            </div>

            <div class="card">
                <h2 class="card-title">Leaderboard (top 10)</h2>
                <?php $leaders = games_get_leaderboard($game['code']); ?>
                <?php if (empty($leaders)): ?>
                    <p class="card-meta">No scores yet. Be the first to set a record!</p>
                <?php else: ?>
                    <ul class="leaderboard-list">
                        <?php foreach ($leaders as $pos => $row): ?>
                            <li>
                                #<?= $pos + 1 ?> · <?= e($row['username']) ?> — <strong><?= (int)$row['best_score'] ?></strong>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="app-footer">
        Code &amp; Play Hub · Mini Game
    </footer>
</div>

<script src="../assets/js/main.js"></script>
<?php if ($game['code'] === 'reaction_time'): ?>
<script>
    (() => {
        const box = document.getElementById('reaction-box');
        const statusEl = document.getElementById('reaction-status');
        const lastEl = document.getElementById('reaction-last');
        const bestEl = document.getElementById('reaction-best');

        let state = 'idle';
        let timeoutId = null;
        let startTs = 0;
        let best = null;

        function resetToIdle() {
            state = 'idle';
            box.classList.remove('ready', 'go');
            box.classList.add('waiting');
            box.textContent = 'Click here to start';
            statusEl.textContent = 'Press once to arm the test.';
        }

        async function submitScore(ms) {
            try {
                const res = await fetch('../api/submit_score.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        game_code: 'reaction_time',
                        score: String(ms),
                        duration_seconds: '0',
                        details: 'reaction_time_ms=' + ms
                    })
                });
                await res.json();
            } catch (e) {
                // ignore network failures for now
            }
        }

        box.addEventListener('click', () => {
            if (state === 'idle') {
                state = 'armed';
                box.classList.remove('waiting');
                box.classList.add('ready');
                box.textContent = 'Wait for green...';
                statusEl.textContent = 'Stay ready. Click only when it turns green.';

                const delay = 800 + Math.random() * 2200;
                timeoutId = setTimeout(() => {
                    state = 'go';
                    startTs = performance.now();
                    box.classList.remove('ready');
                    box.classList.add('go');
                    box.textContent = 'CLICK!';
                    statusEl.textContent = 'Go!';
                }, delay);
            } else if (state === 'armed') {
                clearTimeout(timeoutId);
                resetToIdle();
                statusEl.textContent = 'Too soon! Wait for green before clicking.';
            } else if (state === 'go') {
                const end = performance.now();
                const ms = Math.round(end - startTs);
                lastEl.textContent = String(ms);
                if (best === null || ms < best) {
                    best = ms;
                    bestEl.textContent = String(ms);
                }
                statusEl.textContent = 'Nice! Click again to try once more.';
                submitScore(ms);
                resetToIdle();
            }
        });

        resetToIdle();
    })();
</script>
<?php endif; ?>
</body>
</html>
