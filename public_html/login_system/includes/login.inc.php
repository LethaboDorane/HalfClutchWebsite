<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["pwd"];

    try {
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_view.inc.php';
        require_once 'login_contr.inc.php';

        // ERROR HANDLERS
        $errors = [];

        if (is_input_empty($email, $password)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $result = get_user($pdo, $email);

        if (is_email_wrong($result)) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        if (!is_email_wrong($result) && is_password_wrong($password, $result["pwd"])) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        // Check for errors before starting the session
        if ($errors) {
            session_start(); // Ensure session is started
            $_SESSION["errors_login"] = $errors;
            header("Location: ../login.php?login=error");
            exit();
        }

        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Regenerate session ID securely
        session_regenerate_id(true);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_name"] = htmlspecialchars($result["firstname"]);
        $_SESSION["last_regeneration"] = time();

        header("Location: ../../index.php");
        exit();
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
    }

} else {
    header("Location: ../login.php?login=failed");
    exit();
}
