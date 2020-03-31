<?php

require_once('db_connect.php');

session_start();

try {

    /* Connection to database. */
    $db = db_connect();
    mysqli_set_charset($db, "utf8");


    /* will determine the mode in which will proceed script */
    $mode = $_POST['mode'];


    if($mode == "all") {

        /* fetch all users with whom had logged user communication with all data */

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

            /* will determine wheter particular user is still active or not */
            $time_now = strtotime(date('Y-m-d H:i:s') . '-5 seconds');
            $time_now = date('Y-m-d H:i:s', $time_now);

            if ($last_active > $time_now) {
                $status = " <span class='active_mark' id='active_mark_" . $id_user . "'></span>";
            } else {
                $status = " <span class='' id='active_mark_" . $id_user . "'></span>";
            }

            /* will create list item of the list of users */
            $output .= "
                <div class='list_users_item' id_user_to='" . $id_user . "' name_user_to='" . $name . " " . $surname . "' last_active='" . $last_active . "'>
                    <span class='user'>" .
                        $name . " " . $surname . $status .
                        "</span>
                </div>
            ";
        }

        $statement->free_result();

        print $output;

    }
    else if($mode == "refresh"){

        /* will only fetch last_active data and will make notification when user has new message */

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

            $output .= $id_user . " " . $status . " ";
        }

        $statement->free_result();

        print $output;

    }

}
catch (Exception $ex){
    $ex->getMessage();
    exit();
}

?>