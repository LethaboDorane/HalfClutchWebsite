<?php
    require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Checkout</title>

    <!-- font awesome cdnjs link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/mainstyle.css">
    <link rel="stylesheet" href="css/mainstyle_2.css">
    <link rel="stylesheet" href="css/mainstyle_3.css">
    <link rel="stylesheet" href="css/altstyle.css">
    <link rel="stylesheet" href="css/checkout.css">

</head>
<body>

<!-- checkout section starts here  -->
<section class="checkout" id="checkout">
    <h1 class="heading">Your <span>Order</span></h1>
    <div class="box-container">
        <div class="box">    
            <div class="cart-items-container">
                <div id="cart-items" class="cart-items">
                    <!-- Cart items will be dynamically added here -->
                </div>
                <p id="cart-empty-message">Your cart is empty.</p>
                <p id="cart-total">Total: R0</p>
            </div>

            <div class="checkout-buttons">
                <a href="menu.php" class="btn" style="align-items: center;">Continue shopping</a>
                <form action="payment.php" method="POST">
                    <input type="hidden" id="total-input" name="total-cost" value="0">
                    <button type="submit" id="place-order-btn" class="btn" style="align-items: center;">Place order</button>
                </form>
                <button id="clear-cart" class="btn" style="align-items: center;">Clear cart</button>
            </div>
        </div>
    </div>
</section>
<!-- checkout section ends here  -->

<footer>
    <div class="socials">
        <h3>Find us on our socials (:</h3>
        <a href="https://web.facebook.com/people/Half-Clutch/61556008367891/" target = "_blank"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="https://www.tiktok.com/discover/half-clutch-food-tembisa" target = "_blank"><i class="fab fa-tiktok"></i></a>
        <p>&copy; 2024 Half Clutch. All rights reserved.</p>
        <p>Website by: Lethabo Dorane.</p>
        <p></p>
    </div>  
</footer>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/checkout.js"></script>
<script>
</script>

</body>
</html>
