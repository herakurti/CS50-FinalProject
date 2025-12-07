<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/helpers.php';

function debug_get_all_challenges(): array
{
    global $pdo;
    $stmt = $pdo->query("
        SELECT id, title, language, difficulty, created_at, is_active
        FROM debug_challenges
        ORDER BY created_at DESC
    ");
    return $stmt->fetchAll();
}

function debug_get_active_challenges(): array
{
    global $pdo;
    $stmt = $pdo->query("
        SELECT id, title, language, difficulty, created_at
        FROM debug_challenges
        WHERE is_active = 1
        ORDER BY created_at DESC
    ");
    return $stmt->fetchAll();
}

function debug_get_challenge(int $id): ?array
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM debug_challenges WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function debug_get_tags(): array
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM debug_tags ORDER BY name ASC");
    return $stmt->fetchAll();
}

function debug_get_tags_for_challenge(int $challengeId): array
{
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT t.id, t.name
        FROM debug_tags t
        JOIN debug_challenge_tags ct ON ct.tag_id = t.id
        WHERE ct.challenge_id = :cid
        ORDER BY t.name ASC
    ");
    $stmt->execute([':cid' => $challengeId]);
    return $stmt->fetchAll();
}

function debug_save_challenge(array $data, ?int $id = null): int
{
    global $pdo;

    $fields = [
        'title'         => $data['title'],
        'description'   => $data['description'],
        'language'      => $data['language'],
        'difficulty'    => $data['difficulty'],
        'code'          => $data['code'],
        'fixed_code'    => $data['fixed_code'],
        'correct_lines' => $data['correct_lines'],
        'explanation'   => $data['explanation'],
        'is_active'     => $data['is_active'] ? 1 : 0,
        'created_by'    => current_user_id(),
    ];

    if ($id === null) {
        $stmt = $pdo->prepare("
            INSERT INTO debug_challenges
                (title, description, language, difficulty, code, fixed_code, correct_lines,
                 explanation, is_active, created_at, created_by)
            VALUES
                (:title, :description, :language, :difficulty, :code, :fixed_code, :correct_lines,
                 :explanation, :is_active, NOW(), :created_by)
        ");
        $stmt->execute($fields);
        return (int)$pdo->lastInsertId();
    }

    $fields['id'] = $id;

    $stmt = $pdo->prepare("
        UPDATE debug_challenges
        SET title = :title,
            description = :description,
            language = :language,
            difficulty = :difficulty,
            code = :code,
            fixed_code = :fixed_code,
            correct_lines = :correct_lines,
            explanation = :explanation,
            is_active = :is_active
        WHERE id = :id
    ");
    $stmt->execute($fields);

    return $id;
}

function debug_save_tags_for_challenge(int $challengeId, array $tagIds): void
{
    global $pdo;

    $stmt = $pdo->prepare("DELETE FROM debug_challenge_tags WHERE challenge_id = :cid");
    $stmt->execute([':cid' => $challengeId]);

    if (empty($tagIds)) {
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO debug_challenge_tags (challenge_id, tag_id)
        VALUES (:cid, :tid)
    ");

    foreach ($tagIds as $tid) {
        $stmt->execute([
            ':cid' => $challengeId,
            ':tid' => (int)$tid,
        ]);
    }
}

function debug_get_user_last_attempt(int $challengeId, int $userId): ?array
{
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT *
        FROM debug_attempts
        WHERE challenge_id = :cid AND user_id = :uid
        ORDER BY submitted_at DESC
        LIMIT 1
    ");
    $stmt->execute([
        ':cid' => $challengeId,
        ':uid' => $userId,
    ]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function debug_save_attempt(array $data): void
{
    global $pdo;

    $stmt = $pdo->prepare("
        INSERT INTO debug_attempts (
            challenge_id,
            user_id,
            selected_lines,
            submitted_code,
            is_correct,
            response_time_seconds,
            submitted_at
        )
        VALUES (
            :challenge_id,
            :user_id,
            :selected_lines,
            :submitted_code,
            :is_correct,
            :response_time_seconds,
            NOW()
        )
    ");

    $stmt->execute([
        ':challenge_id' => $data['challenge_id'],
        ':user_id' => $data['user_id'],
        ':selected_lines' => $data['selected_lines'],
        ':submitted_code' => $data['submitted_code'],
        ':is_correct' => $data['is_correct'] ? 1 : 0,
        ':response_time_seconds' => $data['response_time_seconds']
    ]);
}
