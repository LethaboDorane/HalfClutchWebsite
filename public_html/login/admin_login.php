<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/admin_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Login</title>

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

<!-- header section starts here -->

<header class="header">
    <div class="logo-container">
        <a href="https://halfclutch.com/" class="logo">
            <img src="../images/HalfClutch_Logo.png" alt="">
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

<!-- Login section starts here  -->

<section class="admin-container" id="admin-container">

<div class="admin-box">
    <h3>Admin Login</h3>

    <form action="includes/admin.inc.php" method="post">
        <input type="text" name="username" placeholder="Enter Username">
        <input type="password" name="pwd" placeholder="Enter Password">
        <?php
            check_login_errors(); 
        ?>
        <input type="submit" value="Login">
    </form>

    <?php echo "<a href='../login/login.php'>Back to regular login.</a>"; ?>
</div>

</section>

<!-- footer starts here  -->

<footer>
    <div class="socials">
        <h3>Find us on our socials (:</h3>
        <a href="https://web.facebook.com/people/Half-Clutch/61556008367891/" target = "_blank"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="https://www.tiktok.com/discover/half-clutch-food-tembisa" target = "_blank"><i class="fab fa-tiktok"></i></a>
        <p>&copy; 2024 Half Clutch. All rights reserved.</p>
    </div>  
</footer>

<!-- footer ends here  -->

<!-- custom js file link  -->
<script src="../js/signin.js"></script>

</body>
</html>