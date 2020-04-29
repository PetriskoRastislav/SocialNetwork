<?php

/* functions to process data */


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
        case "01": return "January";
        case "02": return "February";
        case "03": return "March";
        case "04": return "April";
        case "05": return "May";
        case "06": return "June";
        case "07": return "July";
        case "08": return "August";
        case "09": return "September";
        case "10": return "October";
        case "11": return "November";
        case "12": return "December";
        default: return false;
    }

}


/* will return only date from complete timestamp */
function process_to_only_date ($timestamp) {
    $date = explode(" ", $timestamp)[0];
    $date = explode("-", $date);

    $date[1] = process_month($date[1]);

    return intval($date[2],10) . ". " . $date[1] . " " . $date[0];
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

        if ($day_diff > 1) return $day_diff . " days ago";
        else return $day_diff . " day ago";
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

        if ($hour_diff > 1) return $hour_diff . " hours ago";
        else return $hour_diff . " hour ago";
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

        if ($minute_diff > 1) return $minute_diff . " minutes ago";
        return $minute_diff . " minute ago";
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
            return $second_diff . " seconds ago";
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
        default: return false;
    }
}


?>