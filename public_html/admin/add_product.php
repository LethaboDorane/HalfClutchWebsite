<?php
    require_once "../config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Admin Page</title>

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
    <h3>This is your admin dashboard where you can manage various aspects of the application.</h3>
    <h2>Add New Product</h2>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required><br><br>
        
        <label for="brandname">Brand Name:</label>
        <input type="text" id="brandname" name="brandname"><br><br>
        
        <label for="image">Image URL:</label>
        <input type="text" id="image" name="image"><br><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>
        
        <label for="in_stock">In Stock:</label>
        <input type="checkbox" id="in_stock" name="in_stock" value="1"><br><br>
        
        <button class="btn" type="submit">Add Product</button>
    </form>
    
    <?php
        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Database connection settings
            $servername = "154.56.34.9";
            $username = "u871886705_info";
            $password = "@7ekQH7TRH3g=b&";
            $dbname = "u871886705_halfclutch";
            
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve product details from the form
            $title = $_POST['title'];
            $price = $_POST['price'];
            $brandname = $_POST['brandname'];
            $image = $_POST['image'];
            $description = $_POST['description'];
            $in_stock = isset($_POST['in_stock']) ? 1 : 0; // Convert checkbox value to boolean

            // Prepare SQL statement to insert the new product into the database
            $sql = "INSERT INTO menu (title, price, brandname, image, description, in_stock)
                    VALUES ('$title', '$price', '$brandname', '$image', '$description', '$in_stock')";

            if ($conn->query($sql) === TRUE) {
                echo "New product added successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
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
