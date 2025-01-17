<?php

ob_start(); // Start output buffering

require_once 'dbh.inc.php'; // Ensure dbh.inc.php sets up $pdo properly
require_once 'config_session.inc.php'; // Session setup, ensure it doesn’t conflict with $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $otp = $_POST['otp'] ?? '';

    if (empty($email) || empty($otp)) {
        $_SESSION['error_otp'] = 'Email and OTP are required.';
        header('Location: ../verification.php?email=' . urlencode($email));
        exit();
    }

    // Sanitize input
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $otp = htmlspecialchars($otp, ENT_QUOTES, 'UTF-8');

    try {
        // Check OTP and its expiry in the 'users' table
        $stmt = $pdo->prepare("SELECT otp, otp_expiry, is_verified FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            $stored_otp = $user['otp'];
            $otp_expiry = $user['otp_expiry'];
            $is_verified = $user['is_verified'];

            // Check if the user is already verified
            if ($is_verified) {
                $_SESSION['success_message'] = 'Your account is already verified.';
                header('Location: ../login.php?verification_successful');
                exit();
            }

            // Log the input OTP and stored OTP for debugging
            error_log("Input OTP: $otp");
            error_log("Stored OTP: $stored_otp");

            // Check if OTP matches
            if ($otp === $stored_otp) {
                // Log OTP expiry details
                $current_time = time();
                $expiry_time = strtotime($otp_expiry);

                error_log("Expiry Time: " . date('Y-m-d H:i:s', $expiry_time)); // Log expiry time for debugging
                error_log("Current Time: " . date('Y-m-d H:i:s', $current_time)); // Current server time

                // Check if OTP is expired
                if ($expiry_time > $current_time) {
                    // OTP is valid, update verification status
                    $update_stmt = $pdo->prepare("UPDATE users SET is_verified = 1, otp = NULL, otp_expiry = NULL WHERE email = :email");
                    $update_stmt->execute(['email' => $email]);
        
                    // Log successful OTP validation
                    error_log("User verified: $email. Redirecting to login.php.");
                    $_SESSION['success_message'] = 'Your account has been verified successfully!';
                    header('Location: ../login.php?verification_successful');
                    exit();
                } else {
                    // OTP expired
                    error_log("OTP expired for email: $email.");
                    $_SESSION['error_otp'] = 'Your OTP has expired. Please request a new one.';
                    header('Location: ../verification.php?email=' . urlencode($email));
                    exit();
                }
            } else {
                // OTP mismatch
                error_log("Invalid OTP for email: $email.");
                $_SESSION['error_otp'] = 'Invalid OTP. Please ensure you entered the correct OTP.';
                header('Location: ../verification.php?email=' . urlencode($email));
                exit();
            }
        } else {
            // Email not found
            error_log("No verification request found for email: $email.");
            $_SESSION['error_otp'] = 'No verification request found for this email.';
            header('Location: ../verification.php?email=' . urlencode($email));
            exit();
        }
    } catch (PDOException $e) {
        // Handle database errors
        error_log("Database error: " . $e->getMessage());
        $_SESSION['error_otp'] = 'An error occurred. Please try again later.';
        header('Location: ../verification.php?email=' . urlencode($email));
        exit();
    }
} else {
    // Invalid request method
    header('Location: ../verification.php');
    exit();
}

ob_end_clean();
?>
