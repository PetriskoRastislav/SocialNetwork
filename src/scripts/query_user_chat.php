<?php

require_once('db_connect.php');

session_start();

try {

    /* Connection to database. */

    $db = db_connect();
    mysqli_set_charset($db, "utf8");

    /* will determine the mode in which will proceed script */

    $mode = $_POST['mode'];


    /* will fetch entire chat with particular user from database */
    if($mode == "all") {

        $id_user_to = $_POST['id_user_to'];

        $query = "
            SELECT * 
            FROM messages
            WHERE (id_user_sender = ? AND id_user_receiver = ?)
            OR (id_user_sender = ? AND id_user_receiver = ?)
            ORDER BY id_message ASC";
        $statement = $db->prepare($query);
        $statement->bind_param("iiii", $id_user_to, $_SESSION['id_user'], $_SESSION['id_user'], $id_user_to);
        $statement->execute();
        $statement->bind_result($id_message, $id_user_sender, $id_user_receiver, $message, $time, $status);

        $output = "";

        while ($statement->fetch()) {
            if ($id_user_to == $id_user_sender) {
                $output .= "<div class='message' id='" . $id_message . "'>";
            }
            else {
                $output .= "<div class='my_mes_wrap'><img id='rem_mes_" . $id_message . "' class='remove_message' src='srcPictures/icons8-deleted-message-100.png' alt='delete message button' />";
                $output .= "<div class='message message_my' id='" . $id_message . "'>";
            }

            $output .= "<img class='avatar' src='' alt='Avatar' />";

            if ($status == "unseen" || $status == "seen") {
                $output .= "<p>" . $message . "</p>";
            }
            else {
                $output .= "<p>Message has been removed</p>";
            }

            $output .= "<span class='time'>" . $time . "</span></div>";

            if ($id_user_to != $id_user_sender) {
                $output .= "</div>";
            }
        }

        $statement->free_result();

        $query = "
            UPDATE messages
            SET status = 'seen', time = ?
            WHERE id_user_sender = ? AND id_user_receiver = ? AND status = 'unseen'";
        $statement = $db->prepare($query);
        $statement->bind_param("sii", $time, $id_user_to, $_SESSION['id_user']);
        $statement->execute();

        print $output;

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
    }


    /* will fetch all messages newer then message with given id */
    else if ($mode == "refresh") {

        $id_user_to = $_POST['id_user_to'];
        @$last_message = $_POST['last_message_id'];

        $query = "
            SELECT * 
            FROM messages
            WHERE (id_user_sender = ? AND id_user_receiver = ? AND id_message > ?)
            OR (id_user_sender = ? AND id_user_receiver = ? AND id_message > ?)
            ORDER BY id_message ASC";
        $statement = $db->prepare($query);
        $statement->bind_param("iiiiii", $id_user_to, $_SESSION['id_user'],
            $last_message, $_SESSION['id_user'], $id_user_to, $last_message);
        $statement->execute();
        $statement->bind_result($id_message, $id_user_sender, $id_user_receiver, $message, $time, $status);

        $output = "";

        while ($statement->fetch()) {
            if ($id_user_to == $id_user_sender) {
                $output .= "<div class='message'>";
            }
            else {
                $output .= "<div class='my_mes_wrap'><img id='rem_mes_" . $id_message . "' class='remove_message' src='srcPictures/icons8-deleted-message-100.png' alt='delete message button' />";
                $output .= "<div class='message message_my'>";
            }

            $output .= "<img class='avatar' src='' alt='Avatar' />";

            if ($status == "unseen" || $status == "seen") {
                $output .= "<p>" . $message . "</p>";
            }
            else {
                $output .= "<p>Message has been removed</p>";
            }

            $output .= "<span class='time'>" . $time . "</span></div>";

            if ($id_user_to != $id_user_sender) {
                $output .= "</div>";
            }
        }

        $statement->free_result();

        $query = "
            UPDATE messages
            SET status = 'seen', time = ?
            WHERE id_user_sender = ? AND id_user_receiver = ? AND status = 'unseen'";
        $statement = $db->prepare($query);
        $statement->bind_param("sii", $time, $id_user_to, $_SESSION['id_user']);
        $statement->execute();

        print $output;

    }


    /* will "remove" particular message of logged user from chat */
    else if ($mode == "remove_message") {

        $id_message = $_POST['id_message'];

        /* fetches old timestamps */
        $query = "
            SELECT time_sent, time_seen
            FROM messages
            WHERE id_user_sender = ? AND id_message = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("ii", $_SESSION['id_user'], $id_message);
        $statement->execute();
        $statement->bind_result($time_sent, $time_seen);
        $statement->fetch();

        $time_now = date("Y-m-d H:i:s");

        /* will update row in database */
        $query = "
            UPDATE messages
            SET status = 'deleted', time_sent = ?, time_seen = ?, time_delted = ?
            WHERE id_user_sender = ? AND id_message = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("sssii", $time_sent, $time_seen, $time_now, $_SESSION['id_user'], $id_message);
        $statement->execute();

        $statement->free_result();

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
    }


}
catch (Exception $ex){
    $ex->getMessage();
    exit();
}

?>
