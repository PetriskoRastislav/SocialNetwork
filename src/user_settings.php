<?php

require_once('scripts/scripts.php');

session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$page = new Page();
$page->displayHead( "settings", array());
$page->displayBodyStart();



$page->displayBodyEnd();

?>