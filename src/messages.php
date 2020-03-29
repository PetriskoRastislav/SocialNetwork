<?php

require_once('scripts/scripts.php');

session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$page = new Page();
$page->displayHead( "messages", array("styles/messages.css"));
$page->displayBodyStart();

?>


<div id="list_users">

    <div id="list_users_header">
        <span id="list_users_header_title">
            Koverzácie
        </span>
        <img id="start_new_conversation" src="srcPictures/icons8-new-message-100.png" alt="start new conversation"/>
    </div>

    <div id="list_users_list"></div>
</div>

<div id="conversations">
</div>






<?php

$page->displayBodyEnd(array("js/messages.js"));

?>