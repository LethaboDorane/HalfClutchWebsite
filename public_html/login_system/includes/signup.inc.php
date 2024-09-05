<?php
// This is the main signup file which links the database to the signup page
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["pwd"];
    $phone = $_POST["phone"];

    try {
        //code...
        require_once 'dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_view.inc.php';
        require_once 'signup_contr.inc.php';

        // ERROR HANDLERS
        $errors = [];

        if (is_input_empty($firstname, $lastname, $email, $password, $phone)) {
            $errors["empty_input"] = "Fill in all fields!";
        }
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email entered!";
        }
        if (is_phone_invalid($phone)) {
            $errors["invalid_phone"] = "Invalid phone number entered!";
        }
        if (is_email_registered($pdo, $email)) {
            $errors["email_used"] = "Email already registered!";
        }
        if (is_phone_registered($pdo, $phone)) {
            $errors["phone_used"] = "Phone number already registered!";
        }

        require_once 'config_session.inc.php';

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;

            $signupData = [
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email,
                "phone" => $phone
            ];

            $_SESSION["signup_data"] = $signupData;

            header("Location: ../sign_up.php");
            die();
        }

        create_user($pdo, $firstname, $lastname, $email, $password, $phone);

        // Sends user to login page after a successful signup
        header("Location: ../login.php?signup=successful");
        
        $pdo = null;
        $stmt = null;
        
        die();

    } catch (PDOException $e) {
        //throw $th;
        echo "Query failed: " . $e->getMessage();
    }

} else {
    header("Location: ../sign_up.php?signup=failed");
    die();
}