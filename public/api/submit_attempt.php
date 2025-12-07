<?php
session_start();

header('Content-Type: application/json');

require_once __DIR__ . '/../../app/lib/auth.php';
require_once __DIR__ . '/../../app/lib/debug.php';
require_once __DIR__ . '/../../app/config/db.php';

if (!is_logged_in()) {
    echo json_encode([
        'ok' => false,
        'error' => 'Not authenticated'
    ]);
    exit;
}

global $pdo;

// -----------------------------
// 1. Lexo input nga AJAX
// -----------------------------
$challengeId   = (int)($_POST['challenge_id'] ?? 0);
$selectedRaw   = trim($_POST['selected_lines'] ?? '');
$responseTime  = (int)($_POST['response_time_seconds'] ?? 0);

// -----------------------------
// 2. Gjej challenge-in
// -----------------------------
$challenge = debug_get_challenge($challengeId);

if (!$challenge || !$challenge['is_active']) {
    echo json_encode([
        'ok' => false,
        'error' => 'Challenge not found'
    ]);
    exit;
}

// -----------------------------
// 3. Kontrollo line numbers
// -----------------------------
$selectedLines = array_filter(array_map('intval', explode(',', $selectedRaw)));
sort($selectedLines);
$selectedLinesStr = implode(',', $selectedLines);

$correctLines = array_filter(array_map('intval', explode(',', $challenge['correct_lines'])));
sort($correctLines);

$linesOk = ($selectedLines === $correctLines);

// -----------------------------
// 4. Përfundimi (S'krahasojmë më kodin e rregulluar)
// -----------------------------
$isCorrect = $linesOk;

// -----------------------------
// 5. Ruaje rezultatin
// -----------------------------
debug_save_attempt([
    'challenge_id' => $challengeId,
    'user_id' => current_user_id(),
    'selected_lines' => $selectedLinesStr,
    'submitted_code' => null,  // s'e kërkojmë më
    'is_correct' => $isCorrect,
    'response_time_seconds' => $responseTime,
]);

// -----------------------------
// 6. Kthe JSON për frontend
// -----------------------------
echo json_encode([
    'ok'         => true,
    'correct'    => $isCorrect,
    'fixed_code' => $isCorrect ? $challenge['fixed_code'] : null
]);
