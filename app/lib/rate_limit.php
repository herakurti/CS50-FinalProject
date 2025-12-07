<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Rate limit i thjeshtë me session.
 *
 * @param string $key           identifikues (p.sh. 'submit_score:USERID' ose 'submit_attempt:USERID')
 * @param int    $maxRequests   sa kërkesa lejohen
 * @param int    $windowSeconds brenda sa sekondave
 * @return bool                 true nëse LEJOHET, false nëse RATE LIMITED
 */
function rate_limit(string $key, int $maxRequests, int $windowSeconds): bool
{
    $now = time();

    if (!isset($_SESSION['rate_limit'])) {
        $_SESSION['rate_limit'] = [];
    }

    if (!isset($_SESSION['rate_limit'][$key])) {
        $_SESSION['rate_limit'][$key] = [
            'start' => $now,
            'count' => 0,
        ];
    }

    $bucket = &$_SESSION['rate_limit'][$key];

    if ($now - $bucket['start'] > $windowSeconds) {
        $bucket['start'] = $now;
        $bucket['count'] = 0;
    }

    if ($bucket['count'] >= $maxRequests) {
        return false;
    }

    $bucket['count']++;
    return true;
}
