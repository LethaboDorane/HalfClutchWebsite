<?php
    require_once "config.php";
    require_once 'login_system/includes/login_view.inc.php';

    // Check if user is logged in
    $isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<!-- rest of the HTML content -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Home</title>

    <!-- font awesome cdnjs link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/mainstyle.css">
    <link rel="stylesheet" href="css/mainstyle_2.css">
    <link rel="stylesheet" href="css/mainstyle_3.css">
    <link rel="stylesheet" href="css/altstyle.css">

</head>
<body>

<!-- header section starts here -->

<header class="header">
    <div class="logo-container">
        <a href="index.php" class="logo">
            <img src="images/HalfClutch_Logo.png" alt="">
        </a>
    </div>
    <nav class="navbar">
        <a href="#menu">menu</a>
        <a href="#about">about us</a>
        <a href="#contact">contact us</a>
        <a href="#reviews">reviews</a>
        <h3>
        <?php
            output_name();
        ?>
        </h3>
    </nav>

    <div class="icons">
        <div class="fas fa-search" id="search-btn"></div>
        <div class="fas fa-shopping-cart" id="cart-btn"></div>
        <div class="fas fa-bars" id="menu-btn"></div>
        <div class="fas fa-times" id="close-btn"></div>
    </div>

    <div class="search-form">
        <input type="search" id="search-box" placeholder="search here..">
        <label for="search-box" class="fas fa-search"></label>
    </div>

    <div id="cart-items-container" class="cart-items-container">
        <div id="cart-items" class="cart-items">
            <!-- Cart items will be dynamically added here -->
        </div>
        <p id="cart-empty-message">Cart is empty.</p>
        <p id="cart-total" style="display: none;">Total: R0</p>
        <a href="<?php echo $isLoggedIn ? 'checkout.php' : 'login_system/login.php'; ?>" class="btn checkout" id="checkout-link" style="display: none;">Proceed to checkout</a> 
        <button class="btn checkout" id="checkout-link" style="display: none;">Clear cart</button>
    </div>    

</header>
<!-- header section ends here -->

<!-- home section starts here  -->

<section class="home" id="home">
    <div class="content">
        <h3>Fresh food all day, everyday</h3>
        <h1>African cuisine, just the way you like it</h1>
        <a href="menu.php" class="btn">Order now</a>
        
        <?php if (isset($_SESSION["user_id"])): ?>
            <form action="login_system/includes/logout.inc.php" method="post">
                <button class="btn">Logout</button>
            </form>
        <?php else: ?>
            <a href="login_system/login.php" class="btn">sign in/sign up</a>
        <?php endif; ?>
        
    </div>
</section>

<!-- home section ends here  -->

<!-- menu section starts here  -->

<section class="menu" id="menu">

    <h1 class="heading">At a glance:<span> Our menu</span></h1>
    
    <div class="box-container">
        <?php
            // Database connection settings
            $servername = "localhost";
            $username = "id22343844_lethabodorane";
            $password = "LethaboMay05.";
            $dbname = "id22343844_halfclutch";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from database
            $sql = "SELECT title, price, image FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {

                    echo "<div class='box'>
                            <img src='images/" . $row["image"]. "' alt='" . $row["title"]. "'>
                            <h3>" . $row["title"]. "</h3>
                            <div class='price'>R" . $row["price"]. "</div>
                            <a href='menu.php' class='btn'>view full menu</a>
                          </div>";
                }
            } else {
                echo "<p>No products found</p>";
            }
            $conn->close();
        ?>
    </div>
</section>

<!-- menu section ends here  -->

<!-- about section starts here  -->

<section class="about" id="about">
    <h1 class="heading"><span>about</span> us</h1>

    <div class="row">

    <div class="image">
       <img src="images/HalfClutch_03.jpeg" alt=""> 
    </div>

    <div class="content">
        <h3>What makes our food special</h3>
        <p>African cuisine, offering a variety of traditional, organic foods which remind one of home.</p>
        <p>Fresh from the flame all day, everyday. click below to view full menu.</p>
        <a href="menu.php" class="btn">View full menu</a>
    </div>

    </div>

</section>

<!-- about section ends here  -->

<!-- contact us starts here -->

<section class="contact" id="contact">
    <h1 class="heading">Contact<span> us</span></h1>

    <div class="row">
        <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3586.111023160452!2d28.18353707540832!3d-25.99718027720467!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e956df06abc9e2f%3A0xb4a91fdf0ba8eec1!2sHalf%20Clutch!5e0!3m2!1sen!2sza!4v1715082077124!5m2!1sen!2sza" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        <div class="contact-info">
            <h3>Get in touch</h3>
            <div class="info">
                <span class="fas fa-envelope"></span>
                <p>Email:<a href="mailto:info@halfclutch.co.za">info@halfclutch.co.za</a></p>
            </div>    
            <div class="info">
                <span class="fas fa-phone"></span>
                <p>Phone:<a href="tel:+27813337745">+27 81 333 7745</a></p>
            </div>            
            <div class="info">
                <span class="fas fa-map-marker-alt"></span>
                <p>Address:<a href="https://maps.app.goo.gl/FzCqUec7aA2E9zEa6">1718 Intaka St, Ebony Park, Midrand, 1632</a></p>
            </div>
        </div>
        
    </div>
</section>

<!-- contact us section ends here -->

<!-- reviews section starts here  -->

<section class="reviews" id="reviews">
    <h1 class="heading">Leave a<span> review</span></h1>
        <h3>Have something to say? We would love to hear your thoughts.</h3>
        <h3>Leave us a review on Google: <a href="https://g.co/kgs/QHJsgCX"><i class="fab fa-google"></i></a></h3>
    <div class="row"></div>
</section>

<!-- reviews section ends here  -->

<!-- footer starts here  -->

<footer>
    <div class="socials">
        <h3>Find us on our socials (:</h3>
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-tiktok"></i></a>
        <p>&copy; 2024 Half Clutch. All rights reserved.</p>
        <p>Website by: Lethabo Dorane. </p>
    </div>  
</footer>

<!-- footer ends here  -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
