<?php
// This is the database handler
$host = "154.56.34.9";
$dbname = "u871886705_halfclutch";
$dbusername = "u871886705_info";
$dbpassword = "@7ekQH7TRH3g=b&";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername,$dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    //throw $th;
    echo "Connection failed: " . $e->getMessage();
}