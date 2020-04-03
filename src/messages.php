<?php

require_once('scripts/scripts.php');

session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$page = new Page();
$page->displayHead( "messages", array("styles/messages.css", "styles/messages-dark.css"));
$page->displayBodyStart();

?>


<div id="list_users">

    <div id="list_users_header">
        <span id="list_users_header_title">
            Koverzácie
        </span>
        <input id="search_user_con_list" name="search_user_conversation_list" type="text" placeholder="username" >
        <div id="search_result_con_list"></div>
    </div>

    <div id="list_users_list"></div>
</div>

<div id="conversation_header">

</div>

<div id="conversation">

</div>

<div id="chat_control">
    <textarea name="message" id="message_to_send" cols="" rows="" placeholder="Tvoja správa ..."></textarea>
    <img id="send_button" class="chat_control_button" src="srcPictures/icons8-send-100.png" alt="send icon" />
    <img id="plus_button" class="chat_control_button" src="srcPictures/icons8-plus-100.png" alt="plus icon" />
</div>


<?php

$page->displayBodyEnd(array("js/messages.js"));

?>