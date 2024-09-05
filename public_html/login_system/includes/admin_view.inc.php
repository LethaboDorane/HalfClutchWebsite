<?php
// This is the login view
declare(strict_types=1);

function output_name() {
    if (isset($_SESSION["user_id"])) {
        echo "Hello " . $_SESSION["username"];
    } else {
        echo "You are not logged in.";
    }
}

function check_login_errors(){
    if (isset($_SESSION["errors_login"])) {
        # code...
        $errors = $_SESSION["errors_login"];

        echo '<br>';
        foreach ($errors as $error) {
            # code...
            echo '<p class=form-error>' . $error . '</p>';
        }
        unset($_SESSION['errors_login']);
    }
    else if (isset($_GET['login']) && $_GET['login'] === "successful"){
        echo '<p class="form-success">Login successful (:</p>';
        echo '<br>';   
    }
}
