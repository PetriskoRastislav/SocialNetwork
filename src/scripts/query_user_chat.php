<?php

require_once('db_connect.php');

session_start();

try {

    /* Connection to database. */

    $db = db_connect();
    mysqli_set_charset($db, "utf8");

    /* will determine the mode in which will proceed script */

    $mode = $_POST['mode'];

    $time_limit = strtotime(date('Y-m-d H:i:s') . '-30 minutes');
    $time_limit = date('Y-m-d H:i:s', $time_limit);


    /* will fetch entire chat with particular user from database */
    if($mode == "all") {

        $id_user_to = $_POST['id_user_to'];


        /* fetches and process users' avatars */

        require_once('process_profile_pictures.php');


        /* fetching messages */

        $query =
            "SELECT id_message, id_user_sender, id_user_receiver, message, time_sent, time_seen, time_deleted, status
            FROM messages
            WHERE (id_user_sender = ? AND id_user_receiver = ?)
            OR (id_user_sender = ? AND id_user_receiver = ?)
            ORDER BY id_message ASC";
        $statement = $db->prepare($query);
        $statement->bind_param("iiii", $id_user_to, $_SESSION['id_user'],
            $_SESSION['id_user'], $id_user_to);
        $statement->execute();
        $statement->bind_result($id_message, $id_user_sender, $id_user_receiver, $message, $time_sent, $time_seen, $time_deleted, $status);

        $output = "";

        while ($statement->fetch()) {

            if ($id_user_sender == $_SESSION['id_user']) {
                $output .= "<div id='mes_" . $id_message . "' class='mes_wrap my_mes_wrap'>";

                if ($status != 'deleted' && $time_sent > $time_limit) {
                    $output .= '<img id="rem_mes_' . $id_message . '" class="remove_message" src="';

                    if ($_SESSION['color_mode'] == "dark") $output .= 'src_pictures/icons8-deleted-message-100-white.png';
                    else $output .= 'src_pictures/icons8-deleted-message-100.png';

                    $output .= '" alt="delete message button" title="Delete message">';
                }
                $output .= '<div class="message message_my">' . $profile_pic_me;

            }
            else {

                $output .=
                    "<div id='mes_" . $id_message . "' class='mes_wrap'>" .
                    "<div class='message'>" .
                    $profile_pic_theirs;

            }


            if ($status == "unseen" || $status == "seen") {
                $output .= "<p>" . $message . "</p>";
            }
            else {
                $output .= "<p>Message has been removed</p>";
            }

            $output .=
                "<span class='time'>" . $time_sent . "</span>".
                "</div>";

            $output .=
                "<div class='mes_time_info'>" .
                "<p class='time'>Sent at: " . $time_sent . ",";

            if ($time_seen != null ){
                $output .= " Seen at: " . $time_seen . ",";
            }

            if ($time_deleted != null ){
                $output .= " Deleted at: " . $time_deleted . ",";
            }

            $output .= "</p></div></div>";

        }

        $statement->free_result();
        $statement->close();


        /* updates status of message to seen */

        $time_now = date("Y-m-d H:i:s");

        $query = "
            UPDATE messages
            SET status = 'seen', time_sent = ?, time_seen = ?, time_deleted = ?
            WHERE id_user_sender = ? AND id_user_receiver = ? AND status = 'unseen'";
        $statement = $db->prepare($query);
        $statement->bind_param("sssii", $time_sent, $time_now, $time_deleted,  $id_user_to, $_SESSION['id_user']);
        $statement->execute();

        print $output;

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will fetch id of last message in conversation in order to future use (to make communication more effective) */
    else if ($mode == "id_message") {

        $id_user_to = $_POST['id_user_to'];

        $query = "
            SELECT id_message 
            FROM messages
            WHERE (id_user_sender = ? AND id_user_receiver = ?)
            OR (id_user_sender = ? AND id_user_receiver = ?)
            ORDER BY id_message DESC LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bind_param("iiii", $id_user_to, $_SESSION['id_user'], $_SESSION['id_user'], $id_user_to);
        $statement->execute();
        $statement->bind_result($id);
        $statement->fetch();

        $output = $id;

        print $output;

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will fetch all messages newer then message with given id */
    else if ($mode == "load_new_messages") {

        $id_user_to = $_POST['id_user_to'];
        $last_message = $_POST['last_message_id'];


        /* fetches and process users' avatars */

        require_once('process_profile_pictures.php');


        /* fetching messages */

        $query = "
            SELECT id_message, id_user_sender, id_user_receiver, message, time_sent, time_seen, time_deleted, status 
            FROM messages
            WHERE (id_user_sender = ? AND id_user_receiver = ? AND id_message > ?)
            OR (id_user_sender = ? AND id_user_receiver = ? AND id_message > ?)
            ORDER BY id_message ASC";
        $statement = $db->prepare($query);
        $statement->bind_param("iiiiii", $id_user_to, $_SESSION['id_user'], $last_message,
            $_SESSION['id_user'], $id_user_to, $last_message);
        $statement->execute();
        $statement->bind_result($id_message, $id_user_sender, $id_user_receiver, $message, $time_sent, $time_seen, $time_deleted, $status);

        $output = "";

        while ($statement->fetch()) {
            if ($id_user_sender == $_SESSION['id_user']) {

                $output .= "<div id='mes_" . $id_message . "' class='mes_wrap my_mes_wrap'>";

                if ($status != 'deleted' && $time_sent > $time_limit) {
                    $output .= '<img id="rem_mes_' . $id_message . '" class="remove_message" src="';

                    if ($_SESSION['color_mode'] == "dark") $output .= 'src_pictures/icons8-deleted-message-100-white.png';
                    else $output .= 'src_pictures/icons8-deleted-message-100.png';

                    $output .= '" alt="delete message button" title="Delete message">';
                }
                $output .=
                    "<div class='message message_my'>" . $profile_pic_me;

            }
            else {

                $output .=
                    "<div id='mes_" . $id_message . "' class='mes_wrap'>" .
                    "<div class='message'>" .
                    $profile_pic_theirs;

            }


            if ($status == "unseen" || $status == "seen") {
                $output .= "<p>" . $message . "</p>";
            }
            else {
                $output .= "<p>Message has been removed</p>";
            }

            $output .=
                "<span class='time'>" . $time_sent . "</span>" .
                "</div>";

            $output .=
                "<div class='mes_time_info'>" .
                "<p class='time'>Sent at: " . $time_sent . ",";

            if ($time_seen != null ){
                $output .= " Seen at: " . $time_seen . ",";
            }

            if ($time_deleted != null ){
                $output .= " Deleted at: " . $time_deleted . ",";
            }

            $output .= "</p></div></div>";

        }

        $statement->free_result();
        $statement->close();


        /* updates status of message to seen */

        $time_now = date("Y-m-d H:i:s");

        $query = "
            UPDATE messages
            SET status = 'seen', time_sent = ?, time_seen = ?, time_deleted = ?
            WHERE id_user_sender = ? AND id_user_receiver = ? AND status = 'unseen'";
        $statement = $db->prepare($query);
        $statement->bind_param("sssii", $time_sent, $time_now, $time_deleted,  $id_user_to, $_SESSION['id_user']);
        $statement->execute();

        print $output;

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will fetch messages modified later then given time */
    else if ($mode == "refresh_messages") {

        $id_user_to = $_POST['id_user_to'];


        /* fetches and process users' avatars */

        require_once('process_profile_pictures.php');


        /* fetching messages */

        $query = "
            SELECT id_message, id_user_sender, id_user_receiver, message, time_sent, time_seen, time_deleted, status 
            FROM messages
            WHERE (id_user_sender = ? AND id_user_receiver = ? AND (time_seen > ? OR time_deleted > ?))
            OR (id_user_sender = ? AND id_user_receiver = ? AND (time_seen > ? OR time_deleted > ?))
            ORDER BY id_message ASC";
        $statement = $db->prepare($query);
        $statement->bind_param("iissiiss",
            $id_user_to,$_SESSION['id_user'], $time_limit, $time_limit,
            $_SESSION['id_user'], $id_user_to, $time_limit, $time_limit);
        $statement->execute();
        $statement->bind_result($id_message, $id_user_sender, $id_user_receiver, $message, $time_sent, $time_seen, $time_deleted, $status);

        $output = "";

        while ($statement->fetch()) {

            $output .= $id_message . "|";

            if ($id_user_sender == $_SESSION['id_user']) {

                if ($status != 'deleted' && $time_sent > $time_limit) {
                    $output .= '<img id="rem_mes_' . $id_message . '" class="remove_message" src="';

                    if ($_SESSION['color_mode'] == "dark") $output .= 'src_pictures/icons8-deleted-message-100-white.png';
                    else $output .= 'src_pictures/icons8-deleted-message-100.png';

                    $output .= '" alt="delete message button" title="Delete message">';
                }
                $output .= '<div class="message message_my">' . $profile_pic_me;

            }
            else {

                $output .= '<div class="message">' . $profile_pic_theirs;

            }


            if ($status == "unseen" || $status == "seen") {
                $output .= "<p>" . $message . "</p>";
            }
            else {
                $output .= '<p>Message has been removed</p>';
            }

            $output .=
                '<span class="time">' . $time_sent . '</span>' .
                '</div>';

            $output .=
                '<div class="mes_time_info">' .
                '<p class="time">Sent at: ' . $time_sent . ',';

            if ($time_seen != null ){
                $output .= ' Seen at: ' . $time_seen . ',';
            }

            if ($time_deleted != null ){
                $output .= ' Deleted at: ' . $time_deleted . ',';
            }

            $output .= '</p></div>';

            $output .= "|";

        }

        $statement->free_result();

        print $output;

        $statement->close();
        $db->close();

        exit();

    }


    /* will "remove" particular message of logged user from chat */
    else if ($mode == "remove_message") {

        $id_message = $_POST['id_message'];
        $time_now = date("Y-m-d H:i:s");

        $query = "
            UPDATE messages
            SET status = 'deleted', time_deleted = ?
            WHERE id_user_sender = ? AND id_message = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("sii", $time_now, $_SESSION['id_user'], $id_message);
        $statement->execute();

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will insert message into a database */
    else if ($mode == "send_message") {

        $id_user_to = $_POST['id_user_to'];
        $message = $_POST['message'];

        $time_now = date("Y-m-d H:i:s");

        $query = "
            INSERT INTO messages (id_user_sender, id_user_receiver, message, time_sent, time_seen, time_deleted, status)
            VALUES (?, ?, ?, ?, null, null, 'unseen')";
        $statement = $db->prepare($query);
        $statement->bind_param("iiss", $_SESSION['id_user'], $id_user_to, $message, $time_now);
        $statement->execute();

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();
    }


}
catch (Exception $ex){
    $ex->getMessage();
    exit();
}


?>
