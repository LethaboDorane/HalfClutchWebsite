<?php
declare(strict_types=1);
// This is the signup view file

function signup_input() {
    // Retain First Name
    if (isset($_SESSION["signup_data"]["firstname"])) {
        echo '<input type="text" name="firstname" placeholder="Enter First Name" value="' . htmlspecialchars($_SESSION["signup_data"]["firstname"], ENT_QUOTES) . '">';
    } else {
        echo '<input type="text" name="firstname" placeholder="Enter First Name">';
    }

    // Retain Last Name
    if (isset($_SESSION["signup_data"]["lastname"])) {
        echo '<input type="text" name="lastname" placeholder="Enter Last Name" value="' . htmlspecialchars($_SESSION["signup_data"]["lastname"], ENT_QUOTES) . '">';
    } else {
        echo '<input type="text" name="lastname" placeholder="Enter Last Name">';
    }

    // Retain Email
    if (isset($_SESSION["signup_data"]["email"])) {
        echo '<input type="text" name="email" autocapitalize="none" placeholder="Enter Email" value="' . htmlspecialchars($_SESSION["signup_data"]["email"], ENT_QUOTES) . '">';
    } else {
        echo '<input type="text" name="email" autocapitalize="none" placeholder="Enter Email">';
    }

    // Password fields - no value retained for security
    echo '<input type="password" name="pwd" placeholder="Enter Password">';
    echo '<input type="password" name="confirm_pwd" placeholder="Re-enter Password">';

    // Retain Phone
    if (isset($_SESSION["signup_data"]["phone"])) {
        echo '<input type="text" name="phone" placeholder="Enter Phone Number" value="' . htmlspecialchars($_SESSION["signup_data"]["phone"], ENT_QUOTES) . '">';
    } else {
        echo '<input type="text" name="phone" placeholder="Enter Phone Number">';
    }
}

function otp_input() {
    echo '<input type="text" name="otp" placeholder="Enter OTP">';
}

function check_signup_errors() {
    if (isset($_SESSION['errors_signup'])) {
        foreach ($_SESSION['errors_signup'] as $error) {
            echo '<p class="form-error">' . htmlspecialchars($error, ENT_QUOTES) . '</p>';
        }
        unset($_SESSION['errors_signup']);
    } elseif (isset($_GET["signup"]) && $_GET["signup"] === "successful") {
        echo '<p class="form-success">Signup successful (:</p>';
    }
}

function check_otp_errors() {
    if (isset($_SESSION['errors_otp'])) {
        foreach ($_SESSION['errors_otp'] as $error) {
            echo '<p class="form-error">' . htmlspecialchars($error, ENT_QUOTES) . '</p>';
        }
        unset($_SESSION['errors_otp']);
    } elseif (isset($_GET["otp"]) && $_GET["otp"] === "verified") {
        echo '<p class="form-success">OTP verified! Signup complete.</p>';
    }
}
?>
