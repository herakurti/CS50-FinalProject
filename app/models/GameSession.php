<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/Game.php';
require_once __DIR__ . '/User.php';

class GameSession
{
    public int $id;
    public int $user_id;
    public int $game_id;
    public int $score;
    public ?int $duration_seconds;
    public string $started_at;
    public ?string $finished_at;
    public ?string $details;

    public static function fromRow(array $row): GameSession
    {
        $s = new self();
        $s->id               = (int)$row['id'];
        $s->user_id          = (int)$row['user_id'];
        $s->game_id          = (int)$row['game_id'];
        $s->score            = (int)$row['score'];
        $s->duration_seconds = $row['duration_seconds'] !== null ? (int)$row['duration_seconds'] : null;
        $s->started_at       = $row['started_at'];
        $s->finished_at      = $row['finished_at'] ?? null;
        $s->details          = $row['details'] ?? null;
        return $s;
    }

    public static function create(int $userId, int $gameId, int $score, ?int $durationSeconds = null, ?string $details = null): GameSession
    {
        global $pdo;

        $stmt = $pdo->prepare("
            INSERT INTO game_sessions (user_id, game_id, score, duration_seconds, finished_at, details)
            VALUES (:uid, :gid, :score, :duration, NOW(), :details)
        ");

        $stmt->execute([
            ':uid'     => $userId,
            ':gid'     => $gameId,
            ':score'   => $score,
            ':duration'=> $durationSeconds,
            ':details' => $details,
        ]);

        $id = (int)$pdo->lastInsertId();
        return self::findById($id);
    }

    public static function findById(int $id): ?GameSession
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM game_sessions WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }

    public static function bestScoresForGame(string $gameCode, int $limit = 10): array
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
        $stmt->bindValue(':code', $gameCode, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
