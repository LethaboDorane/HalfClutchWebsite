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

function set_user(object $pdo, string $firstname, string $lastname, string $email, string $confirm_pwd, string $phone) {
    $query = "INSERT INTO users (firstname, lastname, email, pwd, phone, is_verified) VALUES (:firstname, :lastname, :email, :pwd, :phone, 0);";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($confirm_pwd, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":phone", $phone);
    $stmt->execute();
}

function save_user_otp(object $pdo, string $email, int $otp) {
    // Update query where otp_expiry is set to current time + 2 hours + 10 minutes
    $query = "UPDATE users SET otp = :otp, otp_expiry = DATE_ADD(NOW(), INTERVAL 2 HOUR) + INTERVAL 10 MINUTE WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":otp", $otp);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
}

function verify_user_otp(object $pdo, string $email, int $otp): bool {
    $query = "SELECT otp, otp_expiry FROM users WHERE email = :email AND otp = :otp AND otp_expiry > NOW();";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":otp", $otp);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $updateQuery = "UPDATE users SET is_verified = 1, otp = NULL, otp_expiry = NULL WHERE email = :email;";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(":email", $email);
        $updateStmt->execute();
        return true;
    }

    return false;
}
