<?php

require_once __DIR__ . '/../config/db.php';

class DebugChallenge
{
    public int $id;
    public string $title;
    public string $description;
    public string $language;
    public string $difficulty;
    public string $code;
    public string $fixed_code;
    public string $correct_lines;
    public string $explanation;
    public int $is_active;
    public string $created_at;
    public ?int $created_by;

    public static function fromRow(array $row): DebugChallenge
    {
        $c = new self();
        $c->id            = (int)$row['id'];
        $c->title         = $row['title'];
        $c->description   = $row['description'];
        $c->language      = $row['language'];
        $c->difficulty    = $row['difficulty'];
        $c->code          = $row['code'];
        $c->fixed_code    = $row['fixed_code'];
        $c->correct_lines = $row['correct_lines'];
        $c->explanation   = $row['explanation'];
        $c->is_active     = (int)$row['is_active'];
        $c->created_at    = $row['created_at'];
        $c->created_by    = $row['created_by'] !== null ? (int)$row['created_by'] : null;
        return $c;
    }

    public static function findById(int $id): ?DebugChallenge
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM debug_challenges WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }

    public static function allActive(): array
    {
        global $pdo;
        $stmt = $pdo->query("
            SELECT * FROM debug_challenges
            WHERE is_active = 1
            ORDER BY created_at DESC
        ");
        $rows = $stmt->fetchAll();
        return array_map([self::class, 'fromRow'], $rows);
    }

    public static function all(): array
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM debug_challenges ORDER BY created_at DESC");
        $rows = $stmt->fetchAll();
        return array_map([self::class, 'fromRow'], $rows);
    }
}
