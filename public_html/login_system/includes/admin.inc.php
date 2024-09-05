<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["pwd"];

    try {
        // Load required files
        require_once 'dbh.inc.php';
        require_once 'admin_model.inc.php';
        require_once 'admin_view.inc.php';
        require_once 'admin_contr.inc.php';

        // Error handlers
        $errors = [];

        if (is_input_empty($username, $password)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $result = get_user($pdo, $username);

        if (is_username($result)) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        // Additional password validation logic (if needed)
        // if (!is_username($result) && is_password_wrong($password, $result["pwd"])) {
        //     $errors["login_incorrect"] = "Incorrect login info!";
        // }

        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            header("Location: ../admin_login.php?login=error");
            exit();
        }

        // Regenerate session ID for security
        session_regenerate_id();

        // Set session variables
        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_name"] = htmlspecialchars($result["username"]);
        $_SESSION["last_regeneration"] = time();

        header("Location: ../../admin/admin_page.php");
        exit();
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
    }
} else {
    header("Location: ../../admin/admin.php?login=failed");
    exit();
}
?>
