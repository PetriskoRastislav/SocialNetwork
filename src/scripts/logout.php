<?php

require_once('scripts.php');
session_start();

// Ukládáme si původní hodnotu relační proměnné, abychom dále mohli
// zjistit, jestli byl uživatel přihlášený.
$old_user = $_SESSION['valid_user'];

unset($_SESSION['id_user']);
$result_dest = session_destroy();

// Začneme vypisovat kód HTML.

if (!empty($old_user)) {
    if ($result_dest) {

        // Uživatel byl přihlášený a nyní se odhlásil.
        //echo 'Byl/a jste úspěšně odhlášen/a.<br>';
        header('Location: ../index.php');
        exit();

    } else {

        // Uživatel byl přihlášený, ale nyní se ho nepodařilo zcela odhlásit.
        echo 'Odhlašování selhalo.<br>';
    }
} else {

    // Uživatel nebyl přihlášený, ale dostal se nějakým způsobem na tuto
    // stránku.
    header('Location: ../index.php');
    exit();
}

?>

