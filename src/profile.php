<?php

require_once('scripts/scripts.php');

session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$page = new Page();
$page->displayHead( "", array());
$page->displayBodyStart();

//echo "<p class='spacing'>User's id: " . $_SESSION['id_user'] . "</p>";

$page->displayBodyEnd();

?>