<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/User.php';

function find_user_by_username_or_email(string $identifier): ?array
{
    global $pdo;

    $sql = "SELECT * FROM users WHERE username = :username OR email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $identifier,
        ':email'    => $identifier,
    ]);
    $row = $stmt->fetch();

    return $row ?: null;
}

function find_user_by_id(int $id): ?array
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();

    return $row ?: null;
}

function register_user(string $name, string $username, string $email, string $password): array
{
    global $pdo;

    $errors = [];

    if ($name === '' || $username === '' || $email === '' || $password === '') {
        $errors[] = 'All fields are required.';
        return $errors;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    }

    if (strlen($username) < 3) {
        $errors[] = 'Username must be at least 3 characters long.';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters long.';
    }

    if ($errors) {
        return $errors;
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :u OR email = :e");
    $stmt->execute([
        ':u' => $username,
        ':e' => $email,
    ]);

    if ((int)$stmt->fetchColumn() > 0) {
        $errors[] = 'Username or email is already taken.';
        return $errors;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO users (name, username, email, password_hash, role, created_at)
        VALUES (:name, :username, :email, :hash, 'user', NOW())
    ");

    $stmt->execute([
        ':name'     => $name,
        ':username' => $username,
        ':email'    => $email,
        ':hash'     => $hash,
    ]);

    return [];
}

function login_user(string $identifier, string $password): array
{
    global $pdo;

    $errors = [];

    if ($identifier === '' || $password === '') {
        $errors[] = 'Both fields are required.';
        return $errors;
    }

    $user = find_user_by_username_or_email($identifier);

    if (!$user) {
        $errors[] = 'Invalid credentials.';
        return $errors;
    }

    if (!password_verify($password, $user['password_hash'])) {
        $errors[] = 'Invalid credentials.';
        return $errors;
    }

    $_SESSION['user_id']   = (int)$user['id'];
    $_SESSION['user_role'] = $user['role'];

    $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
    $stmt->execute([':id' => $user['id']]);

    return [];
}

function logout_user(): void
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
}
