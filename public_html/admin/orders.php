<?php
    require_once "../config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Clutch - Orders Page</title>

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
        <a href="#" class="logo">
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
        <h3>Orders Page</h3>
        <h1>View Order Database</h1>
    </div>
    <?php if (isset($_SESSION["user_id"])): ?>
            <form action="../login_system/includes/logout.inc.php" method="post">
                <button class="btn">Logout</button>
            </form>
        <?php else: ?>
            <a href="../login_system/login.php" class="btn">sign in/sign up</a>
        <?php endif; ?>
</section>

<div class="main">
    <h3>This is the orders page where you can view and manage all incoming orders.</h3>
    <h2>Orders List</h2>

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

        // Update order status if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"]) && isset($_POST["status"])) {
            $order_id = $_POST["order_id"];
            $status = $_POST["status"];

            $update_sql = "UPDATE orders SET status = ? WHERE id = ?";
            if ($stmt = $conn->prepare($update_sql)) {
                $stmt->bind_param("si", $status, $order_id);
                if ($stmt->execute()) {
                    echo "<p>Order status updated successfully.</p>";
                } else {
                    echo "<p>Error updating order status: " . $stmt->error . "</p>";
                }
                $stmt->close();
            } else {
                echo "<p>Error preparing update statement: " . $conn->error . "</p>";
            }
        }

        // Fetch data from database
        $sql = "SELECT id, user_id, product_ids, total_amount, status, order_date FROM orders";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table style="align-items: center;">
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Product IDs</th>
                        <th>Total Amount</th>
                        <th>Order Status</th>
                        <th>Order Date</th>
                        <th>Change Status</th>
                    </tr>';
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"]. "</td>
                        <td>" . $row["user_id"]. "</td>
                        <td>" . $row["product_ids"]. "</td>
                        <td>" . $row["total_amount"]. "</td>
                        <td>" . $row["status"]. "</td>
                        <td>" . $row["order_date"]. "</td>
                        <td>
                            <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>
                                <input type='hidden' name='order_id' value='" . $row["id"] . "'>
                                <select name='status'>
                                    <option value='in progress'" . ($row["status"] == 'in progress' ? ' selected' : '') . ">In Progress</option>
                                    <option value='ready for pickup'" . ($row["status"] == 'ready for pickup' ? ' selected' : '') . ">Ready for Pickup</option>
                                    <option value='completed'" . ($row["status"] == 'completed' ? ' selected' : '') . ">Completed</option>
                                </select>
                                <button type='submit' class='btn'>Update</button>
                            </form>
                        </td>
                    </tr>";
            }
            echo '</table>';
        } else {
            echo "<tr><td colspan='7'>No records found</td></tr>";
        }
        $conn->close();
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
