<?php

require_once('db_connect.php');

session_start();

try {

    /* Connection to database. */
    $db = db_connect();
    mysqli_set_charset($db, "utf8");


    /* will determine the mode in which will proceed script */
    $mode = $_POST["mode"];


    /* fetch all users with whom had logged user communication with all data */
    if ($mode == "all") {

        $query = "
            SELECT DISTINCT id_user, name, surname, last_active
            FROM users
            JOIN messages ON 
            (users.id_user = messages.id_user_sender AND messages.id_user_receiver = ?)
            OR (users.id_user = messages.id_user_receiver AND messages.id_user_sender = ?)";

        $statement = $db->prepare($query);
        $statement->bind_param("ii", $_SESSION['id_user'], $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($id_user, $name, $surname, $last_active);

        $output = "";

        while ($statement->fetch()) {

            /* will determine whether particular user is still active or not */
            $time_now = strtotime(date('Y-m-d H:i:s') . '-5 seconds');
            $time_now = date('Y-m-d H:i:s', $time_now);

            if ($last_active > $time_now) {
                $status = " <span class='active_mark' id='active_mark_" . $id_user . "'></span>";
            } else {
                $status = " <span class='' id='active_mark_" . $id_user . "'></span>";
            }

            $mes_count = get_unseen_messages_notification($id_user, $_SESSION['id_user']);
            if ($mes_count > 0 ) {
                $mes_notification = " <span class='mes_not_chat' id='mes_not_" . $id_user . "' ></span>";
            }
            else {
                $mes_notification = " <span class='' id='mes_not_" . $id_user . "' ></span>";
            }

            /* will create list item of the list of users */
            $output .= "
                <div class='list_users_item' id_user_to='" . $id_user . "' name_user_to='" . $name . " " . $surname . "' last_active='" . $last_active . "'>
                    <span class='user'>" .
                        $name . " " . $surname . $status . $mes_notification .
                    "</span>
                </div>
            ";
        }

        $statement->free_result();

        print $output;

    }


    /* will fetch only a list od conversations and wil pass them to js script, which will rfresh list */
    else if ($mode == "refresh_list") {


        $query = "
            SELECT DISTINCT id_user, name, surname, last_active
            FROM users
            JOIN messages ON 
            (users.id_user = messages.id_user_sender AND messages.id_user_receiver = ?)
            OR (users.id_user = messages.id_user_receiver AND messages.id_user_sender = ?)";

        $statement = $db->prepare($query);
        $statement->bind_param("ii", $_SESSION['id_user'], $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($id_user, $name, $surname, $last_active);

        $output = "";

        while ($statement->fetch()) {

            $output .= $id_user . "|";
            $status = " <span class='' id='active_mark_" . $id_user . "'></span>";
            $mes_notification = " <span class='' id='mes_not_" . $id_user . "' ></span>";

            $output .= "
                <div class='list_users_item' id_user_to='" . $id_user . "' name_user_to='" . $name . " " . $surname . "' last_active='" . $last_active . "'>
                    <span class='user'>" .
                        $name . " " . $surname . $status . $mes_notification .
                    "</span>
                </div>
            ";

            $output .= "|";
        }

        print $output;
    }


    /* will only fetch last_active data, will create marker of active user and notification when user has new message */
    else if ($mode == "refresh_marks") {

        $query = "
            SELECT DISTINCT users.id_user, users.last_active
            FROM users
            JOIN messages ON
            (users.id_user = messages.id_user_sender AND messages.id_user_receiver = ?)
            OR (users.id_user = messages.id_user_receiver AND messages.id_user_sender = ?)";
        $statement = $db->prepare($query);
        $statement->bind_param("ii", $_SESSION['id_user'], $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($id_user, $last_active);

        $output = "";

        while ($statement->fetch()){

            $time_now = strtotime(date('Y-m-d H:i:s') . '-5 seconds');
            $time_now = date('Y-m-d H:i:s', $time_now);

            if ($last_active > $time_now) {
                $status = "online";
            } else {
                $status = "offline";
            }

            $mes_count = get_unseen_messages_notification($id_user, $_SESSION['id_user']);

            $output .= $id_user . " " . $status . " " . $last_active . " " . $mes_count . " ";
        }

        $statement->free_result();

        print $output;

    }


    /* will update time of last activity of logged user */
    else if ($mode == "update_active") {

        $time_now = date("Y-m-d H:i:s");

        $query = "
            UPDATE users
            SET last_active = ?
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("si", $time_now, $_SESSION['id_user']);
        $statement->execute();

        $statement->free_result();

    }


    /* will return result of searching for a user */
    else if ($mode == "find_user") {

        $value = $_POST['value'];

        $query = "
            SELECT id_user, email, name, surname, profile_picture, last_active
            FROM users
            WHERE name LIKE ? 
            OR surname LIKE ?";
        $statement = $db->prepare($query);
        $val = "%" . $value . "%";
        $statement->bind_param("ss", $val, $val);
        $statement->execute();
        $statement->bind_result($id, $email, $name, $surname, $profile_picture, $last_active);

        $output = "";

        while ($statement->fetch()){
            $output .= "
                <div id='search_result_" . $id . "' class='search_result_item' name_user_to='" . $name . " " . $surname . "' last_active='" . $last_active . "'>
                    <img class='avatar' src='' alt='Avatar' />
                    <p>" . $name . " " . $surname . "</p>
                </div>";
        }

        print $output;

    }

}
catch (Exception $ex){
    $ex->getMessage();
    exit();
}


/* will return number of unseen messages send from a particular user to logged user */
function get_unseen_messages_notification ($id_user_sender, $id_user_receiver) {

    try{

        /* Connection to database. */
        $db = db_connect();
        mysqli_set_charset($db, "utf8");

        $query = "
            SELECT id_message
            FROM messages
            WHERE id_user_sender = ? AND id_user_receiver = ? AND status = 'unseen'";
        $statement = $db->prepare($query);
        $statement->bind_param("ii", $id_user_sender, $id_user_receiver);
        $statement->execute();
        $statement->bind_result($id);

        $num_of_notifications = 0;

        while($statement->fetch()){
            if($id > 0 ) $num_of_notifications += 1;
        }

        return $num_of_notifications;

    }
    catch (Exception $ex){
        $ex->getMessage();
        return 0;
    }

}

?>