<?php
// This is the main signup.inc.php file which links the database to the signup page
session_start();

// Include PHPMailer
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST["firstname"] ?? '';
    $lastname = $_POST["lastname"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["pwd"] ?? '';
    $confirm_password = $_POST['confirm_pwd'] ?? '';
    $phone = $_POST["phone"] ?? '';

    // Reset errors
    $_SESSION['errors_signup'] = [];
    $_SESSION['signup_data'] = [];

    try {
        require_once 'dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_view.inc.php';
        require_once 'signup_contr.inc.php';

        // Initialize error array
        $errors = [];

        // Input validation
        if (is_input_empty($firstname, $lastname, $email, $password, $confirm_password, $phone)) {
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
        if ($password !== $confirm_password) {
            $errors["password_mismatch"] = "Passwords do not match.";
        }

        // If errors exist, redirect back with error messages
        if (!empty($errors)) {
            $_SESSION["errors_signup"] = $errors;

            $_SESSION["signup_data"] = [
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email,
                "phone" => $phone
            ];

            header("Location: ../sign_up.php");
            exit();
        }

        // Create the user
        create_user($pdo, $firstname, $lastname, $email, $confirm_password, $phone);

        // Generate OTP
        $otp = random_int(100000, 999999); // Secure 6-digit OTP

        // Save OTP and mark user as unverified
        save_user_otp($pdo, $email, $otp);

        // Send OTP to user's email
        try {
            $mail = new PHPMailer(true);

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = ''; // Replace with your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = ''; // Replace with your SMTP email
            $mail->Password = ''; // Replace with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use PHPMailer::ENCRYPTION_SMTPS for port 465
            $mail->Port =  465; // Replace with your SMTP port

            // Sender and recipient settings
            $mail->setFrom('no-reply@halfclutch.com', 'Half Clutch');
            $mail->addAddress($email, $firstname);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "<p>Hello $firstname,</p><p>Your OTP code is: <strong>$otp</strong></p><p>Please use this code to verify your email.</p><p>Thank you,<br>Half Clutch</p>";

            // Send email
            $mail->send();
        } catch (Exception $e) {
            error_log("Email could not be sent. Error: " . $mail->ErrorInfo);
            throw new Exception("Failed to send OTP email.");
        }

        // Redirect to OTP verification page

        $_SESSION['verified_signup'] = true;
        header("Location: ../verification.php?email=" . urlencode($email));
        exit();


    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        header("Location: ../sign_up.php?signup=error&message=" . urlencode($e->getMessage()));
        exit();
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        $_SESSION["errors_signup"] = ["otp_error" => "Unable to send OTP. Please try again later."];
        header("Location: ../sign_up.php");
        exit();
    }

} else {
    // Redirect to signup page if accessed incorrectly
    header("Location: ../sign_up.php");
    exit();
}
