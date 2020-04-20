<?php


/* Tests whether form variables contains values. */
function filled_out($form_vars) {
    foreach ($form_vars as $key => $value) {
        if ((!isset($key)) || ($value == '')) {
            return false;
        }
    }
    return true;
}


/* Verifying that the email address has a valid format. */
function valid_email($address) {
    if (preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/', $address)) {
        return true;
    } else {
        return false;
    }
}


/* will validate if password contains lowercase letter, uppercase letter, digit, and symbol (not letter nor digit) */
function valid_password($password) {
    if (preg_match('/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{10,}/', $password)) {
        return true;
    } else {
        return false;
    }
}


/* validates if string has minimum length */
function string_has_length ($string, $length) {
    if (strlen($string) >= $length) return true;
    else return false;
}


/* validates if string isn't longer than allowed */
function string_isn_t_longer ($string, $length) {
    if (strlen($string) > $length) return false;
    else return true;
}


?>
