<?php
    require_once "config.php";
    require_once 'login_system/includes/login_view.inc.php';

    // Check if user is logged in
    $isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Menu</title>

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
        <a href="index.php">Home</a>
        <a href="index.php#about">About us</a>
        <a href="index.php#contact">Contact us</a>
        <a href="index.php#reviews">Reviews</a>
        <h3 style="text-align: center;">
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
        <button class="btn checkout" id="clear-cart-btn" style="display: none;">Clear cart</button> 
    </div>
</header>

<!-- header section ends here -->

<!-- menu section starts here  -->

<section class="menu" id="menu">

    <h1 class="heading">Our <span>menu</span></h1>

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

            // Fetch menu items from the database
            $sql = "SELECT title, price, image, in_stock FROM menu";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $stock_status = $row["in_stock"] == 1 ? "In Stock" : "Out of stock";
                    echo "<div class='box'>
                            <img src='images/" . $row["image"]. "' alt='" . $row["title"]. "'>
                            <h3>" . $row["title"]. "</h3>
                            <div class='price'>R" . $row["price"]. "</div>
                            <div class='in_stock'>" . $stock_status . "</div>";
                    if ($row["in_stock"] == 1) {
                        echo "<button class='btn add-to-cart'>Add to cart</button>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p>No menu items found</p>";
            }
        ?>
    </div>

</section>

<!-- menu section ends here  -->

<!-- drinks section starts here  -->

<section class="drinks" id="drinks">
    <h1 class="heading">Drinks<span> for </span>sale</h1>
    <div class="box-container">
        <?php
            // Fetch drinks items from the database
            $sql = "SELECT title, price, image, in_stock FROM drinks";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $stock_status = $row["in_stock"] == 1 ? "In Stock" : "Out of stock";
                    echo "<div class='box'>
                            <img src='images/" . $row["image"]. "' alt='" . $row["title"]. "'>
                            <h3>" . $row["title"]. "</h3>
                            <div class='price'>R" . $row["price"]. "</div>
                            <div class='in_stock'>" . $stock_status . "</div>";
                    if ($row["in_stock"] == 1) {
                        echo "<button class='btn add-to-cart'>Add to cart</button>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p>No drinks items found</p>";
            }
            $conn->close();
        ?>
    </div>
</section>

<!-- drinks section ends here  -->

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
<script src="js/script.js"></script>

</body>
</html>
