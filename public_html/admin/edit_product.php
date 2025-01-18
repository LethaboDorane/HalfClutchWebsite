<?php
    require_once "../config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Edit Product</title>

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
    <h2>Edit Product</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Tables available: 'Menu' & 'Drinks'</h2>
        <label for="table">Enter Table Name:</label>
        <input type="text" id="table" name="table" required><br><br>

        <label for="product_id">Product ID:</label>
        <input type="text" id="product_id" name="product_id" required><br><br>
        
        <button class="btn" type="submit" name="fetch">Fetch Product</button>
    </form>

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

        // Initialize variables
        $title = $price = $brandname = $image = $description = $in_stock = "";

        // Check if the form has been submitted to fetch the product
        if (isset($_POST['fetch'])) {
            // Retrieve table and product ID from the form
            $table = $_POST['table'];
            $product_id = $_POST['product_id'];

            // Prepare SQL statement to fetch the product details
            $sql = "SELECT * FROM $table WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    // Fetch the product details
                    $row = $result->fetch_assoc();
                    $title = $row['title'];
                    $price = $row['price'];
                    $brandname = $row['brandname'];
                    $image = $row['image'];
                    $description = $row['description'];
                    $in_stock = $row['in_stock'];
                } else {
                    echo "No product found with ID $product_id in table $table";
                }

                $stmt->close();
            } else {
                echo "Error: " . $conn->error;
            }
        }

        // Check if the form has been submitted to update the product
        if (isset($_POST['update'])) {
            // Retrieve product details from the form
            $table = $_POST['table'];
            $product_id = $_POST['product_id'];
            $title = $_POST['title'];
            $price = $_POST['price'];
            $brandname = $_POST['brandname'];
            $image = $_POST['image'];
            $description = $_POST['description'];
            $in_stock = isset($_POST['in_stock']) ? 1 : 0;

            // Prepare SQL statement to update the product in the database
            $sql = "UPDATE $table SET title=?, price=?, brandname=?, image=?, description=?, in_stock=? WHERE id=?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssssssi", $title, $price, $brandname, $image, $description, $in_stock, $product_id);

                if ($stmt->execute()) {
                    echo "Product updated successfully";
                } else {
                    echo "Error: Could not execute the query: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error: Could not prepare the query: " . $conn->error;
            }
        }

        // Close the database connection
        $conn->close();
    ?>

    <?php if (isset($_POST['fetch']) && isset($title)): ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="table" value="<?php echo htmlspecialchars($table); ?>">
        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
        
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required><br><br>
        
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required><br><br>
        
        <label for="brandname">Brand Name:</label>
        <input type="text" id="brandname" name="brandname" value="<?php echo htmlspecialchars($brandname); ?>"><br><br>
        
        <label for="image">Image URL:</label>
        <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($image); ?>"><br><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50"><?php echo htmlspecialchars($description); ?></textarea><br><br>
        
        <label for="in_stock">In Stock:</label>
        <input type="checkbox" id="in_stock" name="in_stock" value="1" <?php echo $in_stock ? 'checked' : ''; ?>><br><br>
        
        <button class="btn" type="submit" name="update">Update Product</button>
    </form>
    <?php endif; ?>
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
