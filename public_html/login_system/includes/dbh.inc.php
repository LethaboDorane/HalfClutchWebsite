<?php
// This is the database handler
$host = "localhost";
$dbname = "id22343844_halfclutch";
$dbusername = "id22343844_lethabodorane";
$dbpassword = "LethaboMay05.";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername,$dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    //throw $th;
    echo "Connection failed: " . $e->getMessage();
}