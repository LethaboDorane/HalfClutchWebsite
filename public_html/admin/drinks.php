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
<body>

<!-- header section starts here -->

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

<!-- header section ends here -->

<section class="home" id="home">
    <div class="content">
        <h3>admin page</h3>
        <h1>drinks</h1>
        <?php if (isset($_SESSION["user_id"])): ?>
            <form action="../login_system/includes/logout.inc.php" method="post">
                <button class="btn">Logout</button>
            </form>
        <?php else: ?>
            <a href="../login_system/login.php" class="btn">sign in/sign up</a>
        <?php endif; ?>
    </div>
</section>

<div class="main">
    <h3>This is your admin dashboard where you can manage various aspects of the application.</h3>
    <h2>Drinks List</h2>

    <table style="align-items: center;">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Price</th>
            <th>Brand Name</th>
            <th>Image</th>
            <th>Description</th>
            <th>In Stock</th>
        </tr>
        <?php
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

            // Fetch data from database
            $sql = "SELECT id, title, price, brandname, image, description, in_stock FROM drinks";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo 
                        "<tr>
                            <td>" . $row["id"]. "</td>
                            <td>" . $row["title"]. "</td>
                            <td>" . $row["price"]. "</td>
                            <td>" . $row["brandname"]. "</td>
                            <td><img src='../images/" . $row["image"]. "' alt='" . $row["title"]. "' height='125'></td>
                            <td>" . $row["description"]. "</td>
                            <td>" . $row["in_stock"]. "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            $conn->close();
        ?>
    </table>

    <!-- Buttons for adding, removing, and editing products -->
    <div>
        <button class="btn" onclick="window.location.href='add_product.php'">Add Product</button>
        <button class="btn" onclick="window.location.href='remove_product.php'">Remove Product</button>
        <button class="btn" onclick="window.location.href='edit_product.php'">Edit Product</button>
    </div>
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