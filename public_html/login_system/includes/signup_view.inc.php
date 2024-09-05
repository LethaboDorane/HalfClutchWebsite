<?php
// This is the signup view
declare(strict_types=1);

function signup_input() {

    if (isset($_SESSION["signup_data"]["firstname"]) && !isset($_SESSION["errors_signup"]["empty_input"])) {
        echo '<input type="text" name="firstname" placeholder="Enter First Name" value="' . $_SESSION["signup_data"]["firstname"] . '">';
    } else {
        echo '<input type="text" name="firstname" placeholder="Enter First Name">';
    }

    if (isset($_SESSION["signup_data"]["lastname"]) && !isset($_SESSION["errors_signup"]["empty_input"])) {
        echo '<input type="text" name="lastname" placeholder="Enter Last Name" value="' . $_SESSION["signup_data"]["lastname"] . '">';
    } else {
        echo '<input type="text" name="lastname" placeholder="Enter Last Name">';
    }

    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
        echo '<input type="text" name="email" autocapitalize="none" placeholder="Enter Email" value="' . $_SESSION["signup_data"]["email"] . '">';
    } else {
        echo '<input type="text" name="email" autocapitalize="none" placeholder="Enter Email">';
    }

    echo '<input type="password" name="pwd" autocapitalize="none" placeholder="Enter Password">';

    if (isset($_SESSION["signup_data"]["phone"]) && !isset($_SESSION["errors_signup"]["phone_used"]) && !isset($_SESSION["errors_signup"]["invalid_phone"])) {
        echo '<input type="text" name="phone" placeholder="Enter Phone Number" value="' . $_SESSION["signup_data"]["phone"] . '">';
    } else {
        echo '<input type="text" name="phone" placeholder="Enter Phone Number">';
    }
}

function check_signup_errors() {
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];

        foreach ($errors as $error) {
            echo '<p class="form-error">' . $error . '</p>';
        }
        echo '<br>';

        unset($_SESSION['errors_signup']);
        
    } else if (isset($_GET["signup"]) && $_GET["signup"] === "successful") {
        echo '<p class="form-success">Signup successful (:</p>';
        echo '<br>';
    }
}
?>
