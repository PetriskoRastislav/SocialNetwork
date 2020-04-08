<?php

try {

    require_once('scripts.php');
    session_start();

    /* Storing the id of a user to verify that user was successfully logged off */

    $old_user = $_SESSION['valid_user'];

    /* Logging off */

    unset($_SESSION['id_user']);
    $result_dest = session_destroy();

    /* Verifying of logging off */

    if (!empty($old_user)) {
        if ($result_dest) {

            /* user was successfully logged off, now will be redirected to a login/register page */

            header('Location: ../index.php');
            exit();

        } else {

            /* Logging off has failed */

            throw new Exception("Failed to log off");
        }
    }
    else {

        /* User wasn't logged in  but somehow managed to get here so we will send him back */

        header('Location: ../index.php');
        exit();
    }

}
catch (Exception $ex) {
    echo $ex->getMessage();

    exit();
}

?>

