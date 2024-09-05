<?php
// This is the signup controller
declare(strict_types=1);

function is_input_empty(string $firstname, string $lastname, string $email, string $pwd, string $phone) {
    if (empty($firstname) || empty($lastname) || empty($email) || empty($pwd) || empty($phone)) {
        return true;
    } else {
        return false;
    }
}

function is_email_invalid(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function is_phone_invalid(string $phone) {
    $pattern = '/^0\d{9}$/';
    
    if (!filter_var($phone, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $pattern]])) {
        return true;
    } else {
        return false;
    }
}


function is_email_registered(object $pdo, string $email) {
    if (get_email($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}

function is_phone_registered(object $pdo, string $phone) {
    if (get_phone($pdo, $phone)) {
        return true;
    } else {
        return false;
    }
}

function create_user(object $pdo, string $firstname, string $lastname, string $email, string $pwd, string $phone) {
    set_user($pdo, $firstname, $lastname, $email, $pwd, $phone);

}