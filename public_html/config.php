<?php
# Check if a session is already active before modifying session settings
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_only_cookies', 1);
    ini_set('session.use_strict_mode', 1);

    session_set_cookie_params([
        'lifetime' => 1800,
        'domain' => 'halfclutch.com',
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None' // allow cookies to be sent with cross-site requests
    ]);

    session_start();
}

if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} else {
    $interval = 60 * 30;

    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}
?>
