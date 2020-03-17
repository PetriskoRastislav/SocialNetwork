<?php

require_once('scripts/scripts.php');

session_start();

$page = new Page();
$page->displayHead( "user", array("styles/style_form-dark.css"));
$page->displayBodyStart();



$page->displayBodyEnd();

?>