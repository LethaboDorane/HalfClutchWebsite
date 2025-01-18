<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/signup_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Sign Up</title>

    <!-- font awesome cdnjs link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/mainstyle.css?v=1.0">
    <link rel="stylesheet" href="../css/mainstyle_2.css?v=1.0">
    <link rel="stylesheet" href="../css/mainstyle_3.css?v=1.0">
    <link rel="stylesheet" href="../css/altstyle.css?v=1.0">
    <!--The ?v=1.0 ensures that is load the most recent version of the css file-->
</head>
<body>

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

<section class="signup" id="signup">
    <h3>Sign Up Here</h3>
    
    <form action="includes/signup.inc.php" method="post">
        <?php
            signup_input()
        ?>
        <?php
            check_signup_errors(); 
        ?>
        <input type="submit" value="Sign Up">
    </form>
    <a href='login.php'>Already have an account? Click Here.</a>
</section>

<footer>
    <div class="socials">
        <h3>Find us on our socials (:</h3>
        <a href="https://web.facebook.com/people/Half-Clutch/61556008367891/" target = "_blank"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="https://www.tiktok.com/discover/half-clutch-food-tembisa" target = "_blank"><i class="fab fa-tiktok"></i></a>
        <p>&copy; 2024 Half Clutch. All rights reserved.</p>
    </div>  
</footer>

<!-- custom js file link  -->
<script src="../js/signin.js"></script>

</body>
</html>
