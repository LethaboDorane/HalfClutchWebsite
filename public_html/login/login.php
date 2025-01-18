<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/signup_view.inc.php';
require_once 'includes/login_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Login</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom CSS Files -->
    <link rel="stylesheet" href="../css/mainstyle.css?v=1.0">
    <link rel="stylesheet" href="../css/mainstyle_2.css?v=1.0">
    <link rel="stylesheet" href="../css/mainstyle_3.css?v=1.0">
    <link rel="stylesheet" href="../css/altstyle.css?v=1.0">
    <!--The ?v=1.0 ensures that is load the most recent version of the css file-->
    
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

<!-- Login Section -->
<section class="login-container" id="login-container">
    <div class="login-box">
        <h3>Login Here</h3>

        <form action="includes/login.inc.php" method="post">
            <input type="text" name="email" placeholder="Enter Email" required>
            <input type="password" name="pwd" placeholder="Enter Password" required>
            <br>
            <a href='forgot_password.php'>Forgot password? Click Here.</a>
            <br>
            <?php
            check_login_errors(); // Display any login errors
            ?>
            <input type="submit" value="Login">
        </form>
        <a href='sign_up.php'>Not Yet Signed Up? Click Here.</a>
        <br>
        <a href='admin_login.php'>Admin Login</a>
        <br>
        <a href='employee_login.php'>Employee Login</a>
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
            alert("You are being redirected to the login page because the OTP verification page must be accessed after signing up.");
        };
    </script>';
}
?>

<!-- Custom JS File -->
<script src="../js/signin.js"></script>

</body>
</html>
