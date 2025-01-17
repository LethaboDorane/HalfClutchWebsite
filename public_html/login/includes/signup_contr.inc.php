<?php
// This is the signup controller
declare(strict_types=1);

function is_input_empty(string $firstname, string $lastname, string $email, string $pwd, string $confirm_pwd, string $phone): bool {
    return empty($firstname) || empty($lastname) || empty($email) || empty($pwd) || empty($confirm_pwd) || empty($phone);
}

function is_email_invalid(string $email): bool {
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_phone_invalid(string $phone): bool {
    $pattern = '/^0\d{9}$/';
    return !filter_var($phone, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $pattern]]);
}

function is_email_registered(object $pdo, string $email): bool {
    return (bool)get_email($pdo, $email);
}

function is_phone_registered(object $pdo, string $phone): bool {
    return (bool)get_phone($pdo, $phone);
}

function create_user(object $pdo, string $firstname, string $lastname, string $email, string $pwd, string $phone): int {
    set_user($pdo, $firstname, $lastname, $email, $pwd, $phone);

    // Generate OTP
    $otp = random_int(100000, 999999);
    save_user_otp($pdo, $email, $otp);

    // Send OTP to user (implementation needed for email or SMS)
    // Example: send_otp_email($email, $otp);

    return $otp; // Return OTP for debugging or further handling (in production, this is only logged internally)
}
?>
