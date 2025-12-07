<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function redirect(string $url): void
{
    header("Location: {$url}");
    exit;
}

function is_post(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function current_user_id(): ?int
{
    return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
}

function current_user_role(): ?string
{
    return $_SESSION['user_role'] ?? null;
}

function is_logged_in(): bool
{
    return current_user_id() !== null;
}

function require_login(): void
{
    if (!is_logged_in()) {
        redirect('login.php');
    }
}

function require_admin(): void
{
    require_login();
    if (current_user_role() !== 'admin') {
        redirect('dashboard.php');
    }
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message === null) {
        if (!empty($_SESSION['flash'][$key])) {
            $msg = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $msg;
        }
        return null;
    }

    $_SESSION['flash'][$key] = $message;
    return null;
}
