<?php

require_once('db_connect.php');
require_once('data_valid.php');

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
            "SELECT DISTINCT id_user, name, surname, last_active
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


    /* will fetch only a list od conversations and wil pass them to js script, which will refresh list */
    else if ($mode == "refresh_list") {


        $query =
            "SELECT DISTINCT id_user, name, surname, last_active
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

            $output .= $id_user . " " . $status . " " . $last_active . " " . $mes_count . " ";
        }

        $statement->free_result();

        print $output;

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
            $output .= "
                <div id='search_result_" . $id . "' class='search_result_item' name_user_to='" . $name . " " . $surname . "' last_active='" . $last_active . "'>
                    <img class='avatar' src='' alt='Avatar' />
                    <p>" . $name . " " . $surname . "</p>
                </div>";
        }

        print $output;

    }


    /* will return information of a profile to the left info panel of profile page */
    else if ($mode == "get_profile_left_info") {

        $id_user = $_POST['id_user'];
        if ($id_user == "me") $id_user = $_SESSION['id_user'];

        $query =
            "SELECT profile_picture, last_active, gender, location, registered, day_of_birth, month_of_birth, year_of_birth
            FROM users
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $id_user);
        $statement->execute();
        $statement->bind_result($profile_picture, $last_active, $gender, $location, $registered, $day_of_birth, $month_of_bith, $year_of_birth);
        $statement->fetch();

        $output = "";

        if ($profile_picture == null) {
            $output .= "#info_profile_picture|" . "srcPictures/blank-profile-picture-png-8.png";
        } else {
            $output .= "#info_profile_picture|" . "usersPictures/" . $profile_picture . "|";
        }

        $output .= "|#info_last_active|" . process_last_active($last_active);

        $output .= "|#info_gender|" . $gender;

        $output .= "|#info_location|";
        if ($location == null) {
            $output .= "---";
        }
        else {
            $output .= $location;
        }

        $output .= "|#info_registered|" . process_to_only_date($registered);

        $output .= "|#info_date_of_birth|";

        if ($day_of_birth == null && $month_of_bith == null && $year_of_birth == null) {
            $output .= "---";
        }
        else {

            if ($day_of_birth != null) {
                $output .= $day_of_birth . ".";
            }

            if ($day_of_birth != null || $year_of_birth != null) {
                $output .= " ";
            }

            if ($month_of_bith != null) {
                $output .= process_month($month_of_bith);
            }

            if ($month_of_bith != null && $year_of_birth != null) {
                $output .= $year_of_birth;
            }

        }

        print $output;

    }


    /* will return name of a user and his biography */
    else if ($mode == "get_profile_profile_info") {

        $id_user = $_POST['id_user'];
        if ($id_user == "me") $id_user = $_SESSION['id_user'];

        $query =
            "SELECT name, surname, bio
            FROM users
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $id_user);
        $statement->execute();
        $statement->bind_result($name, $surname, $bio);
        $statement->fetch();

        $output = "";

        $output .= ".profile_name h1|" . $name . " " . $surname . "'s Profile";

        $output .= "|#profile_bio|";

        if ($bio == null) {
            if ($id_user == $_SESSION['id_user']) {
                $output .= "No biography written yet. Write it <a class='common' href='user_settings.php?id=" . $id_user . "#user_bio'>now</a>!";
            }
            else {

            }
        }
        else {
            $output .= $bio;
        }

        print $output;

    }


    /* will return heading of page with someone's friends */
    else if ($mode == "get_profile_friend_page_heading") {

        $id_user = $_POST['id_user'];
        if ($id_user == "me") $id_user = $_SESSION['id_user'];

        $query =
            "SELECT name, surname
            FROM users
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $id_user);
        $statement->execute();
        $statement->bind_result($name, $surname);
        $statement->fetch();

        $output = "";

        $output .= ".profile_name h1|" . $name . " " . $surname . "'s Friends";

        print $output;

    }


    /* will return list of particular user's friends */
    else if ($mode == "get_profile_friends_list") {

        $id_user = $_POST['id_user'];
        if ($id_user == "me") $id_user = $_SESSION['id_user'];

        $query =
            "SELECT DISTINCT name, surname, profile_picture, last_active, gender, location
            FROM users
            JOIN friends
            ON ((friends.id_user_1 = ? AND friends.id_user_2 = users.id_user)
            OR (friends.id_user_2 = users.id_user AND friends.id_user_2 = ?))";
        $statement = $db->prepare($query);
        $statement->bind_param("ii", $id_user, $id_user);
        $statement->execute();
        $statement->bind_result($name, $surname, $profile_picture, $last_active, $gender, $location);

        $output = "";

        while ($statement->fetch()) {
            $output .= '<div class="friend">';

            if ($profile_picture == null) {
                $output .= '<img class="friend_avatar" src="srcPictures/blank-profile-picture-png-8.png" title="' . $name .
                    ' ' . $surname . '\'s Avatar" alt="' . $name . ' ' . $surname . '\'s Avatar">';
            }
            else {
                $output .= '<img class="friend_avatar" src="usersPictures/' . $profile_picture . '" title="' . $name .
                    ' ' . $surname . '\'s Avatar" alt="' . $name . ' ' . $surname . '\'s Avatar">';
            }

            $output .=  '<ul class="informations">' .
                '<li>' .
                '<span class="info_tag_friend">Name</span>' .
                '<span class="value_friend">' . $name . ' ' . $surname . '</span>' .
                '</li>' .
                '<li>' .
                '<span class="info_tag_friend">Last Online</span>' .
                '<span class="value_friend">' . process_last_active($last_active) . '</span>' .
                '</li>' .
                '<li>' .
                '<span class="info_tag_friend">Gender</span>' .
                '<span class="value_friend">' . $gender . '</span>' .
                '</li>' .
                '<li>' .
                '<span class="info_tag_friend">Location</span>';

            if ($location == null) {
                $output .= '<span class="value_friend">---</span>';
            }
            else {
                $output .= '<span class="value_friend">' . $location . '</span>';
            }

            $output .= '</li>' .
                '</ul>' .
                '</div>';

	    }

        print $output;

    }


    /* will return data into a some of user's settings */
    else if ($mode == "settings_fill") {

        $query =
            "SELECT name, surname, email, location, gender, day_of_birth, month_of_birth, year_of_birth, color_mode, bio
            FROM users
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($name,$surname, $email, $location, $gender,
            $day_of_birth, $month_of_birth, $year_of_birth, $color_mode, $bio);
        $statement->fetch();

        $output =
            "input[name='name']|value|" . $name .
            "|input[name='surname']|value|" . $surname .
            "|input[name='email']|value|" . $email .
            "|select[name='gender']|value|" . $gender;

        if ($location != null) $output .= "|input[name='location']|value|" . $location;
        if ($day_of_birth != null) $output .= "|select[name='day_of_birth']|value|" . $day_of_birth;
        if ($month_of_birth != null) $output .= "|select[name='month_of_birth']|value|" . $month_of_birth;
        if ($year_of_birth != null) $output .= "|input[name='year_of_birth']|value|" . $year_of_birth;
        if ($color_mode == "dark") $output .= "|input[name='change_theme']|checked|true";
        if ($bio != null) $output .= "|textarea[name='biography']|value|" . $bio;

        print $output;

    }


    /* will change name of user */
    /*else if ($mode == "change_name") {

        $name = $_POST['name'];
        $surname = $_POST['surname'];

        //if(!validate_string($name, 40) || !validate_string($surname, 40)) print "false";

        $query =
            "UPDATE users
            SET name = ?, surname = ?
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("ssi", $name, $surname, $_SESSION['id_user']);

        if ($statement->execute()) print "true";
        else print "false";

    }*/

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

    return  $date[2] . ". " . $date[1] . " " . $date[0];
}


/* from timestamp will create time how long hasn't been active */
function process_last_active ($timestamp) {
    $date = explode(" ", $timestamp);
    $time = explode(":", $date[1]);
    $date = explode("-", $date[0]);

    $timestamp_now = date('Y-m-d H:i:s');
    $date_now = explode(" ", $timestamp_now);
    $time_now = explode(":", $date_now[1]);
    $date_now = explode("-", $date_now[0]);

    $time_limit = strtotime(date('Y-m-d H:i:s') . '-7 days');
    $time_limit = date('Y-m-d H:i:s', $time_limit);

    if ($timestamp < $time_limit) {
        return process_to_only_date($timestamp);
    }

    $time_limit = strtotime(date('Y-m-d H:i:s') . '-1 day');
    $time_limit = date('Y-m-d H:i:s', $time_limit);

    if ($timestamp < $time_limit) {
        $year_la = $date[0];
        $month_la = $date[1];
        $day_la = intval($date[2], 10);
        $hour_la = intval($time[0], 10);

        $year_n = $date_now[0];
        $month_n = $date_now[1];
        $day_n = intval($date_now[2], 10);
        $hour_n = intval($time_now[0], 10);

        $hour_la = $hour_la + ($day_la + get_days_in_month($month_la, $year_la)) * 24;
        $hour_n = $hour_n + ($day_n + get_days_in_month($month_n, $year_n)) * 24;

        $hour_diff = ($hour_n - $hour_la);
        $day_diff = (int) ($hour_diff / 24);

        if ($day_diff > 1) return $day_diff . " days";
        else return $day_diff . " day";
    }

    $time_limit = strtotime(date('Y-m-d H:i:s') . '-1 hour');
    $time_limit = date('Y-m-d H:i:s', $time_limit);

    if ($timestamp < $time_limit) {
        $day_la = intval($date[2], 10);
        $hour_la = intval($time[0], 10);
        $minute_la = intval($time[1], 10);

        $day_n = intval($date_now[2], 10);
        $hour_n = intval($time_now[0], 10);
        $minute_n = intval($time_now[2], 10);

        $minute_la = $minute_la + (($hour_la + ($day_la * 24)) * 60);
        $minute_n = $minute_n + (($hour_n + ($day_n * 24)) * 60);

        $minute_diff = ($minute_n - $minute_la);
        $hour_diff = (int) ($minute_diff / 60);

        if ($hour_diff > 1) return $hour_diff . " hours";
        else return $hour_diff . " hour";
    }

    $time_limit = strtotime(date('Y-m-d H:i:s') . '-1 minute');
    $time_limit = date('Y-m-d H:i:s', $time_limit);

    if ($timestamp < $time_limit) {
        $hour_la = intval($time[0], 10);
        $minute_la = intval($time[1], 10);
        $second_la = intval($time[2], 10);

        $hour_n = intval($time_now[0], 10);
        $minute_n = intval($time_now[1], 10);
        $second_n = intval($time_now[2], 10);

        $second_la = $second_la + (($minute_la + ($hour_la * 60)) * 60);
        $second_n = $second_n + (($minute_n + ($hour_n * 60)) * 60);

        $second_diff = ($second_n - $second_la);
        $minute_diff = (int) ($second_diff / 60);

        if ($minute_diff > 1) return $minute_diff . " minutes";
        return $minute_diff . " minute";
    }
    else {
        $minute_la = intval($time[1], 10);
        $second_la = intval($time[2], 10);

        $minute_n = intval($time_now[1], 10);
        $second_n = intval($time_now[2], 10);

        $second_la = $second_la + ($minute_la * 60);
        $second_n = $second_n + ($minute_n * 60);

        $second_diff = ($second_n - $second_la);

        if ($second_diff > 6) {
            return $second_diff . " seconds";
        }
        else {
            return "now";
        }

    }

}


/* returns number of days in particular month */
function get_days_in_month ($month, $year) {
    $year = intval($year, 10);

    switch ($month){
        case "01":
        case "03":
        case "05":
        case "07":
        case "08":
        case "10":
        case "12":
            return 31;
        case "04":
        case "06":
        case "09":
        case "11":
            return 30;
        case "02":
            if ($year % 4 == 0) return 29;
            else return 28;
    }
}


?>