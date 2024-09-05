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
    <link rel="stylesheet" href="../css/mainstyle.css">
    <link rel="stylesheet" href="../css/mainstyle_2.css">
    <link rel="stylesheet" href="../css/mainstyle_3.css">
    <link rel="stylesheet" href="../css/altstyle.css">
</head>
<body>

<header class="header">
    <div class="logo-container">
        <a href="../index.php" class="logo">
            <img src="../images/HalfClutch_Logo.png" alt="">
        </a>
    </div>
    <nav class="navbar">
        <a href="../index.php">home</a>
        <a href="../index.php#menu">menu</a>
        <a href="../index.php#about">about us</a>
        <a href="../index.php#contact">contact us</a>
        <a href="../index.php#reviews">reviews</a>
    </nav>

    <div class="icons">
        <div class="fas fa-bars" id="menu-btn"></div>
        <div class="fas fa-times" id="close-btn"></div>
    </div>

</header>

<section class="signup" id="signup">
    <h3>Sign Up Here</h3>
    
    <form action="includes/signup.inc.php" method="post" onsubmit="return validatePassword()">
        <?php signup_input(); ?>
        <?php check_signup_errors(); ?>
        <input type="submit" value="Sign Up">
    </form>
    <a href='login.php'>Already have an account? Click Here.</a>
</section>

<footer>
    <div class="socials">
        <h3>Find us on our socials (:</h3>
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-tiktok"></i></a>
        <p>&copy; 2024 Half Clutch. All rights reserved.</p>
    </div>  
</footer>

<!-- custom js file link  -->
<script src="../js/signin.js"></script>
<script>
    function validatePassword() {
        var pwd = document.querySelector('input[name="pwd"]').value;
        var specialChars = /[@!#\.]/;

        if (!specialChars.test(pwd)) {
            alert("Password must contain at least one special character: @, !, #, .");
            return false;
        }

        return true;
    }
</script>

</body>
</html>
