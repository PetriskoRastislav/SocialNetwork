<?php

require_once('scripts_min.php');
session_start();

try {

    /* Connection to database. */
    $db = db_connect();
    mysqli_set_charset($db, "utf8");


    /* will determine the mode in which will proceed script */
    $mode = $_POST["mode"];


    /* will write friendship request into a table friendship_requests */
    if ($mode == "request_friendship") {

        $id_user_to = $_POST['user_to'];
        $time_now = date("Y-m-d H:i:s");

        $query =
            "INSERT INTO friendship_requests (id_user_sender, id_user_receiver, time_sent, status)
            VALUES (?, ?, ?, 'unseen')";
        $statement = $db->prepare($query);
        $statement->bind_param("iis", $_SESSION['id_user'], $id_user_to, $time_now);
        $result = $statement->execute();

        $statement->close();
        $db->close();

        print $result;
        exit();

    }


    /* will cancel friendship request in table friendship_requests */
    else if ($mode == "cancel_friendship_request") {

        $id_user_to = $_POST['user_to'];

        $query =
            "DELETE FROM friendship_requests
            WHERE (id_user_sender = ? AND id_user_receiver = ?)";
        $statement = $db->prepare($query);
        $statement->bind_param("ii", $_SESSION['id_user'], $id_user_to);
        $result = $statement->execute();

        $statement->close();
        $db->close();

        print $result;
        exit();

    }


    /* will cancel friendship in table friends */
    else if ($mode == "cancel_friendship") {

        $id_user_to = $_POST['user_to'];

        $query =
            "DELETE FROM friends
            WHERE (id_user_1 = ? AND id_user_2 = ?)
            OR (id_user_1 = ? AND id_user_2 = ?)";
        $statement = $db->prepare($query);
        $statement->bind_param("iiii", $_SESSION['id_user'], $id_user_to, $id_user_to, $_SESSION['id_user']);
        $result = $statement->execute();

        $statement->close();
        $db->close();

        print $result;
        exit();

    }


    /* will decline friendship request -> will remove request from friendship_requests */
    else if ($mode == "decline_request") {

        $id_user_to = $_POST['user_to'];

        $query =
            "DELETE FROM friendship_requests
            WHERE (id_user_sender = ? AND id_user_receiver = ?)";
        $statement = $db->prepare($query);
        $statement->bind_param("ii", $id_user_to, $_SESSION['id_user']);
        $result = $statement->execute();

        $statement->close();
        $db->close();

        print $result . "|" . $id_user_to;
        exit();

    }


    /* will accept friendship request -> will remove friendship request form friendship_requests and add friendship into a friends table */
    else if ($mode == "accept_request") {

        $id_user_to = $_POST['user_to'];

        /* removes request from friendship_request */

        $query =
            "DELETE FROM friendship_requests
            WHERE (id_user_sender = ? AND id_user_receiver = ?)";
        $statement = $db->prepare($query);
        $statement->bind_param("ii", $id_user_to, $_SESSION['id_user']);
        $result = $statement->execute();

        $statement->close();

        if (!$result) {
            print $result;
            $db->close();
            exit();
        }

        /* adds friendship into a friends */

        $time_now = date("Y-m-d H:i:s");

        $query =
            "INSERT INTO friends (id_user_1, id_user_2, time)
            VALUES (?, ?, ?)";
        $statement = $db->prepare($query);
        $statement->bind_param("iis", $id_user_to, $_SESSION['id_user'], $time_now);
        $result = $statement->execute();

        $statement->close();
        $db->close();

        print $result;
        exit();

    }


    /* returns list of friends and friendship_requests */
    else if ($mode == "refresh_friends_list") {

        $id_user_page = $_POST['id_user'];

        require_once ('get_friends_friend_requests.php');

        $db->close();

        exit();

    }


}
catch (Exception $ex){
    $ex->getMessage();
    exit();
}

?>