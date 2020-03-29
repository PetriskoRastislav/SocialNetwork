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
        <img id="start_new_conversation" src="srcPictures/icons8-new-message-100.png" alt="start new conversation"/>
    </div>

    <div id="list_users_list"></div>
</div>

<div id="conversations">

    <div class="message">
        <img class="avatar" src="" alt="Avatar">
        <p>Hello. How are you today?</p>
        <span class="time">11:00</span>
    </div>

    <div class="message message_my">
        <img class="avatar" src="" alt="Avatar">
        <p>Hey! I'm fine. Thanks for asking!</p>
        <span class="time">11:01</span>
    </div>

    <div class="message">
        <img class="avatar" src="" alt="Avatar">
        <p>Sweet! So, what do you wanna do today?</p>
        <span class="time">11:02</span>
    </div>

    <div class="message message_my">
        <img class="avatar" src="" alt="Avatar">
        <p>Nah, I dunno. Play soccer.. or learn more coding perhaps?</p>
        <span class="time">11:05</span>
    </div>
</div>






<?php

$page->displayBodyEnd(array("js/messages.js"));

?>