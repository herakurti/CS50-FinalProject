<?php

require_once __DIR__ . '/../config/db.php';

class DebugAttempt
{
    public int $id;
    public int $challenge_id;
    public int $user_id;
    public string $selected_lines;
    public ?string $submitted_code;
    public int $is_correct;
    public ?int $response_time_seconds;
    public string $submitted_at;

    public static function fromRow(array $row): DebugAttempt
    {
        $a = new self();
        $a->id                   = (int)$row['id'];
        $a->challenge_id         = (int)$row['challenge_id'];
        $a->user_id              = (int)$row['user_id'];
        $a->selected_lines       = $row['selected_lines'];
        $a->submitted_code       = $row['submitted_code'] ?? null;
        $a->is_correct           = (int)$row['is_correct'];
        $a->response_time_seconds= $row['response_time_seconds'] !== null ? (int)$row['response_time_seconds'] : null;
        $a->submitted_at         = $row['submitted_at'];
        return $a;
    }

    public static function create(
        int $challengeId,
        int $userId,
        string $selectedLines,
        ?string $submittedCode,
        int $isCorrect,
        ?int $responseTimeSeconds = null
    ): DebugAttempt {
        global $pdo;

        $stmt = $pdo->prepare("
            INSERT INTO debug_attempts
                (challenge_id, user_id, selected_lines, submitted_code, is_correct, response_time_seconds)
            VALUES
                (:cid, :uid, :selected, :submitted, :correct, :time)
        ");

        $stmt->execute([
            ':cid'      => $challengeId,
            ':uid'      => $userId,
            ':selected' => $selectedLines,
            ':submitted'=> $submittedCode,
            ':correct'  => $isCorrect,
            ':time'     => $responseTimeSeconds,
        ]);

        $id = (int)$pdo->lastInsertId();
        return self::findById($id);
    }

    public static function findById(int $id): ?DebugAttempt
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM debug_attempts WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }

    public static function lastForUserAndChallenge(int $userId, int $challengeId): ?DebugAttempt
    {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT *
            FROM debug_attempts
            WHERE user_id = :uid AND challenge_id = :cid
            ORDER BY submitted_at DESC
            LIMIT 1
        ");
        $stmt->execute([
            ':uid' => $userId,
            ':cid' => $challengeId,
        ]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }
}
