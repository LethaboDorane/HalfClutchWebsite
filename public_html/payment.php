<?php
    require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Payment</title>

    <!-- font awesome cdnjs link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/mainstyle.css">
    <link rel="stylesheet" href="css/mainstyle_2.css">
    <link rel="stylesheet" href="css/mainstyle_3.css">
    <link rel="stylesheet" href="css/altstyle.css">
    <link rel="stylesheet" href="css/checkout.css">

    <!-- additional custom css for payment page -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .checkout-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .checkout-container h1 {
            text-align: center;
            color: #333;
        }
        .cart-summary {
            margin-bottom: 20px;
            font-size: medium;
        }
        .cart-summary h2 {
            margin-bottom: 10px;
            color: #333;
        }
        #checkout-items {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        #checkout-items li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        #total-cost {
            font-weight: bold;
            margin-top: 10px;
            text-align: right;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group.half {
            display: inline-block;
            width: 48%;
        }
        .form-group.half:nth-child(odd) {
            margin-right: 4%;
        }
        .checkout-button {
            display: block;
            width: 100%;
            padding: 10px;
            background: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
        }
        .checkout-button:hover {
            background: #555;
        }
        .checkout-button + .checkout-button {
            margin-top: 10px;
        }
        .payment-method {
            margin-bottom: 20px;
        }
        .payment-method label {
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h1>Payment</h1>
        <div class="cart-summary">
            <h2>Cart</h2>
            <ul id="checkout-items">
                <!-- Checkout items will be dynamically inserted here -->
            </ul>
            <div id="total-cost">Total: R<?php echo isset($_POST['total-cost']) ? htmlspecialchars($_POST['total-cost']) : '0.00'; ?></div>
        </div>

        <section class="checkout" id="checkout">
            <h1 class="heading">Your <span>Payment</span></h1>
            <div class="box-container">
                <div class="box">    
                    <form id="checkout-form" action="index.php" method="POST">
                        <div class="form-group">
                            <label for="full-name">Full Name:</label>
                            <input type="text" name="fullname" placeholder="Enter full name here" required>
                        </div>
                        
                        <div class="payment-method">
                            <label>
                                <input type="radio" name="payment-method" value="card" checked> Credit Card
                            </label>
                            <label>
                                <input type="radio" name="payment-method" value="cash"> Cash
                            </label>
                        </div>
                        
                        <div id="card-details">
                            <div class="form-group">
                                <label for="card-name">Name on Card:</label>
                                <input type="text" id="card-name" name="card-name" placeholder="Enter card name here" required>
                            </div>
                            <div class="form-group">
                                <label for="card-number">Credit Card Number:</label>
                                <input type="text" id="card-number" name="card-number" placeholder="Enter card number here" required>
                            </div>
                            <div class="form-group">
                                <label for="exp-month">Exp Month:</label>
                                <input type="text" id="exp-month" name="exp-month" placeholder="Enter card expiry month here" required>
                            </div>
                            <div class="form-group half">
                                <label for="exp-year">Exp Year:</label>
                                <input type="text" id="exp-year" name="exp-year" placeholder="Enter card expiry year here" required>
                            </div>
                            <div class="form-group half">
                                <label for="cvv">CVV:</label>
                                <input type="text" id="cvv" name="cvv" placeholder="Enter CVV here" required>
                            </div>
                        </div>
                        
                        <input type="hidden" id="total-input" name="total-cost" value="0">
                        <input type="hidden" id="cart-items-input" name="product-ids" value="">
                        <a href="index.php">
                            <button type="submit" class="checkout-button">Complete payment</button>
                        </a>
                        <br>
                        <a href="checkout.php">
                            <button type="button" class="checkout-button">Back to checkout</button>
                        </a>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    <script src="js/checkout.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const paymentMethodInputs = document.querySelectorAll('input[name="payment-method"]');
            const cardDetails = document.getElementById('card-details');

            function toggleCardDetails() {
                if (this.value === 'card') {
                    cardDetails.style.display = 'block';
                    cardDetails.querySelectorAll('input').forEach(input => input.required = true);
                } else {
                    cardDetails.style.display = 'none';
                    cardDetails.querySelectorAll('input').forEach(input => input.required = false);
                }
            }

            paymentMethodInputs.forEach(input => {
                input.addEventListener('change', toggleCardDetails);
            });

            // Initially call the function to set the correct display
            paymentMethodInputs.forEach(input => {
                if (input.checked) {
                    toggleCardDetails.call(input);
                }
            });
        });
    </script>
</body>
</html>
