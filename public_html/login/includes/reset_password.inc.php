<?php
session_start();

// Include PHPMailer
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? '';
    $new_password = $_POST["new_password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';

    // Reset errors
    $_SESSION['reset_error'] = [];
    
    try {
        require_once 'dbh.inc.php';
        // require_once 'password_model.inc.php'; // Contains password-related helper functions
        // require_once 'password_contr.inc.php'; // Contains controller logic

        $errors = [];

        // Validate email and passwords
        if (empty($email) || empty($new_password) || empty($confirm_password)) {
            $errors["empty_fields"] = "All fields are required!";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["invalid_email"] = "Invalid email format!";
        }

        if ($new_password !== $confirm_password) {
            $errors["password_mismatch"] = "Passwords do not match!";
        }

        if (!is_password_strong($new_password)) { // Function to validate password strength
            $errors["weak_password"] = "Password must be at least 8 characters, include uppercase, lowercase, and numbers.";
        }

        // If errors exist, redirect back with error messages
        if (!empty($errors)) {
            $_SESSION["reset_error"] = $errors;
            header("Location: ../reset_password.php?email=" . urlencode($email));
            exit();
        }

        // Check if email exists in the database
        if (!is_email_registered($pdo, $email)) {
            $_SESSION["reset_error"] = ["email_not_found" => "This email is not registered."];
            header("Location: ../reset_password.php?email=" . urlencode($email));
            exit();
        }

        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        if (!update_user_password($pdo, $email, $hashed_password)) {
            throw new Exception("Failed to update the password. Please try again.");
        }

        // Send confirmation email
        try {
            $mail = new PHPMailer(true);

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = ''; // Replace with your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = ''; // Replace with your SMTP email
            $mail->Password = ''; // Replace with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use PHPMailer::ENCRYPTION_SMTPS for port 465
            $mail->Port = 465;

            // Sender and recipient settings
            $mail->setFrom('no-reply@halfclutch.com', 'Half Clutch');
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Confirmation';
            $mail->Body = "<p>Hello,</p><p>Your password has been successfully reset.</p><p>If you did not initiate this reset, please contact our support immediately.</p><p>Thank you,<br>Half Clutch</p>";

            // Send email
            $mail->send();
        } catch (Exception $e) {
            error_log("Email could not be sent. Error: " . $mail->ErrorInfo);
        }

        // Redirect to login page with success message
        $_SESSION["reset_success"] = "Your password has been reset successfully. Please log in.";
        header("Location: ../login.php");
        exit();

    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $_SESSION["reset_error"] = ["db_error" => "An error occurred while processing your request. Please try again later."];
        header("Location: ../reset_password.php?email=" . urlencode($email));
        exit();
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        $_SESSION["reset_error"] = ["general_error" => "An unexpected error occurred. Please try again later."];
        header("Location: ../reset_password.php?email=" . urlencode($email));
        exit();
    }

} else {
    // Redirect to reset password page if accessed incorrectly
    header("Location: ../reset_password.php");
    exit();
}
