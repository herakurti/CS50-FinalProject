<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/helpers.php';

function games_get_all_active(): array
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM games WHERE is_active = 1 ORDER BY id ASC");
    return $stmt->fetchAll();
}

function games_get_by_code(string $code): ?array
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM games WHERE code = :code AND is_active = 1 LIMIT 1");
    $stmt->execute([':code' => $code]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function games_get_leaderboard(string $code, int $limit = 10): array
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT u.username, MAX(gs.score) AS best_score
        FROM game_sessions gs
        JOIN users u ON u.id = gs.user_id
        JOIN games g ON g.id = gs.game_id
        WHERE g.code = :code
        GROUP BY gs.user_id, u.username
        ORDER BY best_score DESC
        LIMIT :limit
    ");
    $stmt->bindValue(':code', $code, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}
