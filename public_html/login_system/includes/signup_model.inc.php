<?php
// This is the signup model
declare(strict_types=1);

function get_email(object $pdo, string $email) {

    $query = "SELECT email FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
} 

function get_phone(object $pdo, string $phone) {

    $query = "SELECT phone FROM users WHERE phone = :phone;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":phone", $phone);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo, string $firstname, string $lastname, string $email, string $pwd, string $phone) {
    $query = "INSERT INTO users (firstname, lastname, email, pwd, phone) VALUES (:firstname, :lastname, :email, :pwd, :phone);";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":phone", $phone);
    $stmt->execute();
}