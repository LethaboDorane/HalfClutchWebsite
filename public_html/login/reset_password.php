<?php
require_once 'includes/config_session.inc.php'; // Ensures session and configuration are loaded
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
    <link rel="stylesheet" href="../css/reset_password_style.css?v=1.0">
    <!-- The ?v=1.0 ensures that it loads the most recent version of the CSS file -->
    
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
<section class="reset-container" id="reset-container">
    <div class="reset-box">
        <h3>Reset Your Password</h3>

        <form action="includes/reset_password.inc.php" method="post">
            <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>" required>
            <input type="password" name="new_password" placeholder="Enter New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
            <br>
            <?php
            // Display any error messages
            if (!empty($_SESSION['reset_error'])) {
                echo '<p class="error">' . htmlspecialchars($_SESSION['reset_error']) . '</p>';
                unset($_SESSION['reset_error']);
            }

            // Display success messages
            if (!empty($_SESSION['reset_success'])) {
                echo '<p class="success">' . htmlspecialchars($_SESSION['reset_success']) . '</p>';
                unset($_SESSION['reset_success']);
            }
            ?>
            <input type="submit" value="Reset Password">
        </form>
        <br>
        <a href="login.php" class="a">Back to Login</a>
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

<!-- Redirect Pop-Up Script -->
<?php
if (isset($_GET['message']) && $_GET['message'] === 'redirected') {
    echo '<script>
        window.onload = function() {
            alert("You must complete OTP verification before resetting your password.");
        };
    </script>';
}
?>

<!-- Custom JS File -->
<script src="../js/script.js"></script>

</body>
</html>
