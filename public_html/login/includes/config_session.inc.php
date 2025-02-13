<?php
// This is the configuration session file which manages the cookies and session data
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => '154.56.34.9',
    'path' => '/',
    'secure' => true,
    'httponly' => true, 
    'samesite' => 'None' // allow cookies to be sent with cross-site requests
]);

session_start();

if (isset($_SESSION["user_id"])) {

    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id_loggedIn();
    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id_loggedIn();   
        }
    }
    
} else {
    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id();
    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id();   
        }
    }

}

function regenerate_session_id_loggedIn(){
    session_regenerate_id(true);
    
    $userID = $_SESSION["user_id"];
    $newSessionID = session_create_id();
    $sessionID = $newSessionID . "_" . $userID;
    session_id($sessionID);

    $_SESSION["last_regeneration"] = time();
}

function regenerate_session_id(){
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}
