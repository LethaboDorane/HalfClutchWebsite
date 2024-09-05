<?php

declare(strict_types=1);

function is_input_empty(string $username, string $password) {
    if (empty($username) || empty($password)) {
        # code...
        return true;
    } else {
        return false;
    }
}

function is_username($input) {
    if (is_string($input) && !empty($input)) {
        return true;
    } else {
        return false;
    }
}

// function is_password_wrong(string $password, string $password1) {

//     if (!password_verify($password, $password1)) {
//         # code...
//         return true;
//     } else {
//         return false;
//     }
// }