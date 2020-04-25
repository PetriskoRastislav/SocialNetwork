<?php

require_once('scripts_min.php');
session_start();

try {

    /* Connection to database. */
    $db = db_connect();
    mysqli_set_charset($db, "utf8");


    /* will determine the mode in which will proceed script */
    $mode = $_POST["mode"];


    /* fetch all users with whom had logged user communication with all data */
    if ($mode == "all") {

        $query =
            "SELECT DISTINCT id_user, name, surname, profile_picture, last_active
            FROM users
            JOIN messages ON 
            (users.id_user = messages.id_user_sender AND messages.id_user_receiver = ?)
            OR (users.id_user = messages.id_user_receiver AND messages.id_user_sender = ?)";

        $statement = $db->prepare($query);
        $statement->bind_param("ii", $_SESSION['id_user'], $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($id_user, $name, $surname, $profile_picture, $last_active);

        $output = "";

        while ($statement->fetch()) {

            /* will determine whether particular user is still active or not */
            $time_now = strtotime(date('Y-m-d H:i:s') . '-6 seconds');
            $time_now = date('Y-m-d H:i:s', $time_now);

            /* profile picture */
            if ($profile_picture != null) {
                $img = "user_pictures/" . $profile_picture;
            }
            else {
                $img = "src_pictures/blank-profile-picture-png-8.png";
            }

            $profile_pic = "background-image: url('" . $img . "');";
            $profile_pic = '<div class="avatar avatar-list" style="' . $profile_pic . '"></div>';

            /* last active */
            if ($last_active > $time_now) {
                $status = " <span class='active_mark' id='active_mark_" . $id_user . "'></span>";
            } else {
                $status = " <span class='' id='active_mark_" . $id_user . "'></span>";
            }

            /* count of unseen messages */
            $mes_count = get_unseen_messages_notification($id_user, $_SESSION['id_user']);
            if ($mes_count > 0 ) {
                $mes_notification = " <span class='notification_mark' id='mes_not_" . $id_user . "' ></span>";
            }
            else {
                $mes_notification = " <span class='' id='mes_not_" . $id_user . "' ></span>";
            }

            /* will create list item of the list of users */
            $output .=
                "<div class='list_users_item' id_user_to='" . $id_user . "'>" .
                    $profile_pic .
                    "<span class='user'>" .
                        $name . " " . $surname . $status . $mes_notification .
                    "</span>
                </div>
            ";
        }

        $statement->free_result();
        $statement->close();
        $db->close();

        print $output;

        exit();

    }


    /* will fetch only a list of conversations and will pass them to js script, which will refresh list */
    else if ($mode == "refresh_list") {


        $query =
            "SELECT DISTINCT id_user, name, surname, last_active, profile_picture
            FROM users
            JOIN messages ON 
            (users.id_user = messages.id_user_sender AND messages.id_user_receiver = ?)
            OR (users.id_user = messages.id_user_receiver AND messages.id_user_sender = ?)";

        $statement = $db->prepare($query);
        $statement->bind_param("ii", $_SESSION['id_user'], $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($id_user, $name, $surname, $last_active, $profile_picture);

        $output = "";

        while ($statement->fetch()) {

            $output .= $id_user . "|";

            /* profile picture */
            if ($profile_picture != null) {
                $img = "user_pictures/" . $profile_picture;
            }
            else {
                $img = "src_pictures/blank-profile-picture-png-8.png";
            }

            $profile_pic = "background-image: url('" . $img . "');";
            $profile_pic = '<div class="avatar avatar-list" style="' . $profile_pic . '"></div>';

            $status = " <span class='' id='active_mark_" . $id_user . "'></span>";
            $mes_notification = " <span class='' id='mes_not_" . $id_user . "' ></span>";

            $output .= "
                <div class='list_users_item' id_user_to='" . $id_user . "'>".
                    $profile_pic .
                    "<span class='user'>" .
                        $name . " " . $surname . $status . $mes_notification .
                    "</span>
                </div>
            ";

            $output .= "|";
        }

        $statement->free_result();
        $statement->close();
        $db->close();

        print $output;

        exit();

    }


    /* will only fetch last_active data, will create marker of active user and notification when user has new message */
    else if ($mode == "refresh_marks") {

        $query =
            "SELECT DISTINCT users.id_user, users.last_active
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

            $time_now = strtotime(date('Y-m-d H:i:s') . '-6 seconds');
            $time_now = date('Y-m-d H:i:s', $time_now);

            if ($last_active > $time_now) {
                $status = "online";
            } else {
                $status = "offline";
            }

            $mes_count = get_unseen_messages_notification($id_user, $_SESSION['id_user']);

            $output .= $id_user . "|" . $status . "|" . process_last_active($last_active) . "|" . $mes_count . "|";
        }

        $statement->free_result();
        $statement->close();
        $db->close();

        print $output;

        exit();

    }


    /* will update time of last activity of logged user */
    else if ($mode == "update_active") {

        $time_now = date("Y-m-d H:i:s");

        $query =
            "UPDATE users
            SET last_active = ?
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("si", $time_now, $_SESSION['id_user']);
        $statement->execute();

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will return id, username, and last_active of a user with given id */
    else if ($mode == "get_username") {

        $id = $_POST['id_user'];
        if ($id == "me") $id = $_SESSION['id_user'];

        $query =
            "SELECT id_user, name, surname, last_active, profile_picture
            FROM users
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->bind_result($id_user, $name, $surname, $last_active, $profile_picture);
        $statement->fetch();

        $result = $id_user . "|" . $name . " " . $surname . "|" . process_last_active($last_active) . "|" . $profile_picture;

        print $result;

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will return result of searching for a user */
    else if ($mode == "find_user") {

        $value = $_POST['value'];

        $query =
            "SELECT id_user, email, name, surname, profile_picture, last_active
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

            if ($profile_picture != null) {
                $img = "user_pictures/" . $profile_picture;
            }
            else {
                $img = "src_pictures/blank-profile-picture-png-8.png";
            }

            $profile_pic = "background-image: url('" . $img . "');";
            $profile_pic = '<div class="avatar avatar-list" style="' . $profile_pic . '"></div>';

            $output .= "
                <div id='search_result_" . $id . "' class='search_result_item'>".
                    $profile_pic .
                    "<p>" . $name . " " . $surname . "</p>
                </div>";
        }

        print $output;

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will return notifications, which will be displayed in menu, if there will be any */
    else if ($mode == "update_notifications") {

        /* selects message notification */

        $query =
            "SELECT id_message
            FROM messages
            WHERE (id_user_receiver = ? AND status = 'unseen')";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($id_message);
        $statement->fetch();

        $is_new_message = false;

        if ($id_message > 0) $is_new_message = true;

        $statement->free_result();
        $statement->close();


        /* selects friends notification */

        $query =
            "SELECT id_request
            FROM friendship_requests
            WHERE (id_user_receiver = ? AND status = 'unseen')";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($id_request);
        $statement->fetch();

        $is_new_request = false;

        if ($id_request > 0) $is_new_request = true;

        $statement->free_result();
        $statement->close();
        $db->close();

        print $is_new_message . "|" . $is_new_request;
        exit();

    }


}
catch (Exception $ex){
    $ex->getMessage();
    exit();
}

?>