<?php

require_once('db_connect.php');

session_start();

try {

    /* Connection to database. */
    $db = db_connect();
    mysqli_set_charset($db, "utf8");

    /* will fetch chat with particular user from database */

    $id_user_to = $_POST['id_user_to'];

    $query = "
        SELECT * 
        FROM messages
        WHERE (id_user_sender = ? AND id_user_receiver = ?)
        OR (id_user_sender = ? AND id_user_receiver = ?)
        ORDER BY time ASC";
    $statement = $db->prepare($query);
    $statement->bind_param("iiii", $id_user_to, $_SESSION['id_user'], $_SESSION['id_user'], $id_user_to);
    $statement->execute();
    $statement->bind_result($id_message, $id_user_sender, $id_user_receiver, $message, $time, $status);

    $output = "";

    while($statement->fetch()){
        if ($id_user_to == $id_user_sender) {
            $output .= "<div class='message'>";
        }
        else {
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
catch (Exception $ex){
    $ex->getMessage();
    exit();
}

?>
