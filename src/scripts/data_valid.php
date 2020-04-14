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


/* will validate whether strings has required max length */
function validate_string($string, $length) {
    if (strlen($string) > $length) return false;
    else return true;
}


/* validate */
function validate_year ($year) {
    if (preg_match('/[a-zA-Z0-9\.\,\-\_\ ]+/', $year)) {
        return true;
    } else {
        return false;
    }
}

?>
