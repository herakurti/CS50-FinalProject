<?php
require_once __DIR__ . '/../../app/lib/auth.php';
require_once __DIR__ . '/../../app/lib/rate_limit.php';

header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['ok' => false, 'error' => 'Not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'Invalid method']);
    exit;
}

$userId = current_user_id();

// 30 kërkesa për 60 sekonda për user
if (!rate_limit('submit_score:' . $userId, 30, 60)) {
    echo json_encode(['ok' => false, 'error' => 'Too many requests, slow down.']);
    exit;
}

$gameCode = trim($_POST['game_code'] ?? '');
$score    = isset($_POST['score']) ? (int)$_POST['score'] : null;
$duration = isset($_POST['duration_seconds']) ? (int)$_POST['duration_seconds'] : null;
$details  = $_POST['details'] ?? null;

if ($gameCode === '' || $score === null) {
    echo json_encode(['ok' => false, 'error' => 'Missing fields']);
    exit;
}

global $pdo;

$stmt = $pdo->prepare("SELECT id FROM games WHERE code = :code AND is_active = 1 LIMIT 1");
$stmt->execute([':code' => $gameCode]);
$game = $stmt->fetch();

if (!$game) {
    echo json_encode(['ok' => false, 'error' => 'Game not found']);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO game_sessions (user_id, game_id, score, duration_seconds, finished_at, details)
    VALUES (:uid, :gid, :score, :duration, NOW(), :details)
");

$stmt->execute([
    ':uid'     => $userId,
    ':gid'     => $game['id'],
    ':score'   => $score,
    ':duration'=> $duration,
    ':details' => $details,
]);

echo json_encode(['ok' => true]);
