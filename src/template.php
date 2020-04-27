<?php

require_once('scripts/scripts.php');
session_start();


/* checks if user is logged */

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}


/* prints header of page */

$page = new Page();
$page->display_header("", array());
$page->display_body_start();

?>



<!-- main body oh html document -->



<?php

/* default js scripts */
$page->display_default_scripts();

?>


<?php

/* additional js scripts */
$page->display_scripts(array("js/friend-control.js"));

/* end of document */
$page->display_body_end();

/* closing connection with database */
$db->close();

?>
