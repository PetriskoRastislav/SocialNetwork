<?php

require_once('scripts/scripts.php');

session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$page = new Page();
$page->display_header( "Messages", array("styles/messages"));
$page->display_body_start();

?>

<!-- list of conversations -->

<div id="list_users">

    <!-- header of list of conversation with bar to search users -->

    <div id="list_users_header">
        <span id="list_users_header_title">Chats</span>
        <input id="search_user_con_list" name="search_user_conversation_list" type="text" placeholder="Search users ..." >
        <img src="<?php
            if ($_SESSION['color_mode'] == "dark") echo "src_pictures/icons8-delete-100-white.png";
            else echo "src_pictures/icons8-delete-100.png";
            ?>" alt="clear" class="clear_search_users">
        <div id="search_result_con_list" class="search_result_con_list"></div>
    </div>

    <!-- list of conversations -->

    <div id="list_users_list"></div>
</div>

<!-- header of chat with name of user and some info -->

<div id="conversation_header"></div>

<!-- chat with user -->

<div id="conversation"></div>

<!-- bar with chat controls (textarea for message, button to send) -->

<div id="chat_control">
    <input name="message" id="message_to_send" placeholder="Your message ...">
    <img id="send_button" class="chat_control_button" src="<?php
        if ($_SESSION['color_mode'] == "dark") echo "src_pictures/icons8-send-100-white.png";
        else echo "src_pictures/icons8-send-100.png";
        ?>" alt="send icon" title="Send message" />
</div>

<?php

$page->display_body_end(array("js/messages.js"));

?>