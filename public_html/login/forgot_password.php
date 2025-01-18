<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/dbh.inc.php'; // Ensure this file sets up the database connection

// Initialize message variables
$successMessage = $errorMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Validate email
    if (empty($email)) {
        $errorMessage = "Please enter your email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format.";
    } else {
        // Check if email exists in the database
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Email exists, send reset email via `reset_password.inc.php`
            $_SESSION['reset_email'] = $email; // Store email in session for OTP
            header("Location: includes/reset_password.inc.php?email=" . urlencode($email));
            exit();
        } else {
            $errorMessage = "Email not found. Please check and try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Reset Password</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom CSS Files -->
    <link rel="stylesheet" href="../css/mainstyle.css?v=1.0">
    <link rel="stylesheet" href="../css/mainstyle_2.css?v=1.0">
    <link rel="stylesheet" href="../css/mainstyle_3.css?v=1.0">
    <link rel="stylesheet" href="../css/altstyle.css?v=1.0">
    <link rel="stylesheet" href="../css/verify_style.css?v=1.0">
</head>

<body>

<!-- Header Section -->
<header class="header">
    <div class="logo-container">
        <a href="https://halfclutch.com/" class="logo">
            <img src="../images/HalfClutch_Logo.png" alt="Half Clutch Logo">
        </a>
    </div>
    <nav class="navbar">
        <a href="https://halfclutch.com/">Home</a>
        <a href="https://halfclutch.com/#menu">Menu</a>
        <a href="https://halfclutch.com/#about">About Us</a>
        <a href="https://halfclutch.com/#contact">Contact Us</a>
        <a href="https://halfclutch.com/#reviews">Reviews</a>
    </nav>
    <div class="icons">
        <div class="fas fa-bars" id="menu-btn"></div>
        <div class="fas fa-times" id="close-btn"></div>
    </div>
</header>

<!-- Reset Password Section -->
<section class="otp-container" id="otp-container">
    <div class="otp-box">
        <h3>Reset Your Password</h3>
        <p>Enter your registered email to receive a password reset link.</p>

        <?php if (!empty($errorMessage)) : ?>
            <p class="error"><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>
        <?php if (!empty($successMessage)) : ?>
            <p class="success"><?= htmlspecialchars($successMessage) ?></p>
        <?php endif; ?>

        <form action="includes/reset_password.inc.php" method="post">
            <input 
                type="text" name="email" placeholder="Enter Email" style="text-transform: none;" required autocapitalize="none" autocorrect="off" spellcheck="false" style="text-transform: lowercase;">
            <input type="submit" value="Send Reset Link">
        </form>
    </div>
</section>


<!-- Footer Section -->
<footer>
    <div class="socials">
        <h3>Find us on our socials (:</h3>
        <a href="https://web.facebook.com/people/Half-Clutch/61556008367891/" target="_blank"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="https://www.tiktok.com/discover/half-clutch-food-tembisa" target="_blank"><i class="fab fa-tiktok"></i></a>
        <p>&copy; 2024 Half Clutch. All rights reserved.</p>
    </div>
</footer>

<!-- Custom JS -->
<script src="../js/script.js"></script>

</body>
</html>
