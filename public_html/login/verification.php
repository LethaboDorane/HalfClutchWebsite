<?php
// Ensure session is started
session_start();

// Check if the user accessed this page after signup
if (!isset($_SESSION['verified_signup']) || $_SESSION['verified_signup'] !== true) {
    // Redirect to login.php with a message query parameter
    header("Location: login.php?message=redirected");
    exit();
}



// Unset the session variable to prevent reuse
unset($_SESSION['verified_signup']);

// Required includes
require_once 'includes/config_session.inc.php';
require_once 'includes/signup_view.inc.php';
require_once 'includes/login_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Verify Account</title>

    <!-- font awesome cdnjs link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/mainstyle.css?v=1.0">
    <link rel="stylesheet" href="../css/mainstyle_2.css?v=1.0">
    <link rel="stylesheet" href="../css/mainstyle_3.css?v=1.0">
    <link rel="stylesheet" href="../css/altstyle.css?v=1.0">
    <link rel="stylesheet" href="../css/verify_style.css?v=1.0">
    <!-- The ?v=1.0 ensures that it loads the most recent version of the css file -->
</head>

<body>

<!-- Header Section -->
<header class="header">
    <div class="logo-container">
        <a href="https://halfclutch.com/" class="logo">
            <img src="../images/HalfClutch_Logo.png" alt="">
        </a>
    </div>
    <nav class="navbar">
        <a href="https://halfclutch.com/">home</a>
        <a href="https://halfclutch.com/#menu">menu</a>
        <a href="https://halfclutch.com/#about">about us</a>
        <a href="https://halfclutch.com/#contact">contact us</a>
        <a href="https://halfclutch.com/#reviews">reviews</a>
    </nav>

    <div class="icons">
        <div class="fas fa-bars" id="menu-btn"></div>
        <div class="fas fa-times" id="close-btn"></div>
    </div>
</header>

<!-- OTP Verification Section -->
<section class="otp-container" id="otp-container">
    <div class="otp-box">
        <h3>Verify Your Email</h3>
        <p>Please enter the 6-digit OTP sent to your email address to complete verification.</p>

        <form action="includes/verify_otp.inc.php" method="post">
            <?php
                if (!empty($_SESSION['error_otp'])) {
                    echo '<p class="error">' . htmlspecialchars($_SESSION['error_otp']) . '</p>';
                    unset($_SESSION['error_otp']); // Clear the error after displaying it
                }
            ?>
            <input type="text" id="otp" name="otp" placeholder="Enter 6-digit OTP" required>
            <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">
            <input type="submit" value="Verify">
        </form>
        
        <a href='verification.php?email=<?= urlencode(htmlspecialchars($_GET['email'] ?? '')) ?>'>Resend OTP</a>
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

<!-- Custom JS File -->
<script src="../js/script.js"></script>

</body>
</html>
