<?php
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = $_POST["username"];
    $password = $_POST["pwd"];

    try {
        //code...
        require_once 'dbh.inc.php';
        require_once 'employee_model.inc.php';
        require_once 'employee_view.inc.php';
        require_once 'employee_contr.inc.php';

        // ERROR HANDLERS
        $errors = [];

        if (is_input_empty($username, $password)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $result = get_user($pdo, $username);

        if (is_username($result)) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        if (!is_username($result) && !is_password_wrong($password, $result["pwd"])) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        require_once 'config_session.inc.php';

        if ($errors) {
            $_SESSION["errors_login"] = $errors;

            header("Location: ../employee_login.php?login=error");
            die();
        }
        
        $newSessionID = session_create_id();
        $sessionID = $newSessionID . "_" . $result["id"];
        session_id($sessionID);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_name"] = htmlspecialchars($result["username"]);
        
        $_SESSION["last_regeneration"] = time();

        header("Location: ../../employees/orders.php");
        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $e) {
        //throw $th;
        echo "Query failed: " . $e->getMessage();
    }

} else {
    header("Location: ../employee_login.php?login=failed");
    die();
}