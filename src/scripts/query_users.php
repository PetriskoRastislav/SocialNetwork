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
            $time_now = strtotime(date('Y-m-d H:i:s') . '-6 seconds');
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

            $time_now = strtotime(date('Y-m-d H:i:s') . '-6 seconds');
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


    /* will return information of a profile to the left info panel of profile page */
    else if ($mode = "get_profile_left_info") {

        $id_user = $_POST['id'];

        $query = "
            SELECT profile_picture, last_active, gender, location, registered, day_of_birth, month_of_birth, year_of_birth
            FROM users
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->bind_result($profile_picture, $last_active, $gender, $location, $registered, $day_of_birth,
            $month_of_bith, $year_of_birth);
        $statement->fetch();

        $output = "";

        if ($profile_picture == null) {
            $output .= "#info_profile_picture|" . "srcPictures/blank-profile-picture-png-8.png";
        }
        else {
            $output .= "#info_profile_picture|" . "usersPictures/" . $profile_picture . "|";
        }

        $output .= "|#info_last_active|" . process_last_active($last_active);

        $output .= "|#info_gender|" . $gender;

        $output .= "|#info_location|" . $location;

        $output .= "|#info_registered|" . process_to_only_date($registered);

        $output .= "|#info_date_of_birth|";

        if ($day_of_birth != null) {
            $output .= $day_of_birth . ".";
        }

        if ($day_of_birth != null || $year_of_birth != null) {
            $output .= " ";
        }

        if ($month_of_bith != null) {
            $output .= process_month($month_of_bith);
        }

        if ($month_of_bith != null && $year_of_birth != null){
            $output .= $year_of_birth;
        }

        print $output;

    }

}
catch (Exception $ex){
    $ex->getMessage();
    exit();
}



/* functions */


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


/* will translate decimal expression of month to a name of a month */
function process_month ($month) {

    switch ($month) {
        case "01": return "january";
        case "02": return "february";
        case "03": return "march";
        case "04": return "april";
        case "05": return "may";
        case "06": return "jun";
        case "07": return "july";
        case "08": return "august";
        case "09": return "september";
        case "10": return "october";
        case "11": return "november";
        case "12": return "december";
    }

}


/* will return only date from complete timestamp */
function process_to_only_date ($timestamp) {
    $date = explode(" ", $timestamp)[0];
    $date = explode("-", $date);

    $date[1] = process_month($date[1]);

    return  $date[0] . ". " . $date[1] . " " . $date[2];
}


function process_last_active ($timestamp) {
    $date = explode(" ", $timestamp);
    $time = explode(":", $date[1]);
    $date = explode("-", $date[0]);

    $time_limit = strtotime(date('Y-m-d H:i:s') . '-7 days');
    $time_limit = date('Y-m-d H:i:s', $time_limit);

    if ($timestamp > $time_limit) {
        return process_to_only_date($timestamp);
    }

    $time_limit = strtotime(date('Y-m-d H:i:s') . '-1 day');
    $time_limit = date('Y-m-d H:i:s', $time_limit);

    if ($timestamp > $time_limit) {
        $day_la = $date[0];
        $time_limit = explode(" ", $time_limit);
        $date_l = explode("-", $time_limit[0]);
        $day_l = $date_l[0];

        $day_la = intval($day_la, 10);
        $day_l = intval($day_l, 10);

        return ($day_la - $day_l) . " days";
    }

    $time_limit = strtotime(date('Y-m-d H:i:s') . '-1 hour');
    $time_limit = date('Y-m-d H:i:s', $time_limit);

    if ($timestamp > $time_limit) {
        $hour_la = $time[0];
        $time_limit = explode(" ", $time_limit);
        $time_l = explode(":", $time_limit[1]);
        $hour_l = $time_l[0];

        $hour_la = intval($hour_la, 10);
        $hour_l = intval($hour_l, 10);

        return ($hour_la - $hour_l) . " hours";
    }

    $time_limit = strtotime(date('Y-m-d H:i:s') . '-1 minute');
    $time_limit = date('Y-m-d H:i:s', $time_limit);

    if ($timestamp > $time_limit) {
        $minute_la = $time[1];
        $time_limit = explode(" ", $time_limit);
        $time_l = explode(":", $time_limit[1]);
        $minute_l = $time_l[1];

        $minute_la = intval($minute_la);
        $minute_l = intval($minute_l);

        return ($minute_la - $minute_l) . " minutes";
    }
    else {
        $second_la = $time[3];
        $time_limit = explode(" ", $time_limit);
        $time_l = explode(":", $time_limit[1]);
        $second_l = $time_l[2];

        $second_la = intval($second_la);
        $second_l = intval($second_l);

        $second_diff = ($second_la - $second_l);

        if ($second_diff > 6) {
            return $second_diff . " seconds";
        }
        else {
            return "now";
        }

    }

}

?>