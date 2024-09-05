<?php
    require_once "../config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Remove Product</title>

    <!-- font awesome cdnjs link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/mainstyle.css">
    <link rel="stylesheet" href="../css/mainstyle_2.css">
    <link rel="stylesheet" href="../css/mainstyle_3.css">
    <link rel="stylesheet" href="../css/altstyle.css">

</head>

<body style="margin-top: 7.5rem;">
<header class="header">
    <div class="logo-container">
        <a href="admin_page.php" class="logo">
        <img src="../images/HalfClutch_Logo.png" alt="">
        </a>
    </div>
    <nav class="navbar">
        <a href="admin_page.php">Dashboard</a>
        <a href="drinks.php">Drinks</a>
        <a href="users.php">Users</a>
        <a href="orders.php">Orders</a>
        <a href="employees.php">Employees</a>
    </nav>

    <div class="icons">
        <div class="fas fa-search" id="search-btn"></div>
        <div class="fas fa-bars" id="menu-btn"></div>
        <div class="fas fa-times" id="close-btn"></div>
    </div>

    <div class="search-form">
        <input type="search" id="search-box" placeholder="search here..">
        <label for="search-box" class="fas fa-search"></label>
    </div>
</header>

<div class="main">
    <h2>Remove Product</h2>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="table">Enter Table Name:</label>
        <input type="text" id="table" name="table" required><br><br>

        <label for="product_id">Product ID:</label>
        <input type="text" id="product_id" name="product_id" required><br><br>
        
        <button class="btn" type="submit">Remove Product</button>
    </form>
    
    <?php
        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

            // Retrieve table and product ID from the form
            $table = $_POST['table'];
            $product_id = $_POST['product_id'];

            // Prepare SQL statement to delete the product from the database
            $sql = "DELETE FROM $table WHERE id = ?";

            if ($stmt = $conn->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("i", $product_id);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    echo "Product removed successfully";
                } else {
                    echo "Error: Could not execute the query: " . $stmt->error;
                }

                // Close statement
                $stmt->close();
            } else {
                echo "Error: Could not prepare the query: " . $conn->error;
            }

            // Close the database connection
            $conn->close();
        }
    ?>
</div>

<footer>
    <div class="socials">
        <p>=====</p>
        <p>=====</p>
        <p>&copy; 2024 Half Clutch. All rights reserved.</p>
        <p>=====</p>
        <p>=====</p>
    </div>  
</footer>

<!-- custom js file link  -->
<script src="../js/script.js"></script>

</body>
</html>
