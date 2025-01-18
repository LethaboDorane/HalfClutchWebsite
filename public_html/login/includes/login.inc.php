<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["pwd"];

    try {
        // Require necessary files
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_view.inc.php';
        require_once 'login_contr.inc.php';

        // Initialize errors array
        $errors = [];

        // Check if inputs are empty
        if (is_input_empty($email, $password)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        // Fetch user details from the database
        $result = get_user($pdo, $email);

        if (!$result) {
            // If no user found, return an error
            $errors["login_incorrect"] = "Email entered is incorrect or doesn't exist.";
        } else {
            // Check if password matches
            $stored_hash = $result["pwd"];
            if (!password_verify($password, $stored_hash)) {
                $errors["login_incorrect"] = "Incorrect password entered.";
            }

            // Check if the user is verified
            if ($result["is_verified"] != 1) {
                $errors["account_not_verified"] = "Your account is not verified. Please verify your email to log in.";
            }
        }

        // Require session setup
        require_once 'config_session.inc.php';

        // If there are errors, redirect to login page with errors
        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            header("Location: ../login.php?login=error");
            die();
        }

        // Create a new session ID for security purposes
        $newSessionID = session_create_id();
        $sessionID = $newSessionID . "_" . $result["id"];
        session_id($sessionID);

        // Store session variables
        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_name"] = htmlspecialchars($result["firstname"]);
        $_SESSION["last_regeneration"] = time();

        // Redirect to the main page after successful login
        header("Location: https://halfclutch.com/");
        $pdo = null; // Close database connection
        die();
    } catch (PDOException $e) {
        // Handle database errors
        error_log("Database error: " . $e->getMessage());
        header("Location: ../login.php?login=error");
        die();
    }
} else {
    // Redirect to login page if accessed incorrectly
    header("Location: ../login.php?login=failed");
    die();
}
