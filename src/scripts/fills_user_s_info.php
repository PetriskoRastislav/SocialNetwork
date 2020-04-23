<?php

/* informations about user (to left panel) */

$query =
    "SELECT profile_picture, last_active, gender, location, registered, day_of_birth, month_of_birth, year_of_birth
    FROM users
    WHERE id_user = ?";
$statement = $db->prepare($query);
$statement->bind_param("i", $id_user);
$statement->execute();
$statement->bind_result($profile_picture, $last_active, $gender, $location, $registered, $day_of_birth, $month_of_bith, $year_of_birth);
$statement->fetch();


$profile_picture_content = "src_pictures/blank-profile-picture-png-8.png";
if ($profile_picture != null) {
    $profile_picture_content = "user_pictures/" . $profile_picture;
}

$last_active_content = process_last_active($last_active);

$gender_content = "" . $gender;

$location_content = "---";
if ($location != null) {
    $location_content = $location;
}

$registered_content = process_to_only_date($registered);

$date_of_birth = "";
if ($day_of_birth == null && $month_of_bith == null && $year_of_birth == null) {
    $date_of_birth = "---";
}
else {

    if ($day_of_birth != null) {
        $date_of_birth .= intval($day_of_birth, 10) . ".";
    }

    if ($day_of_birth != null && ($month_of_bith != null || $year_of_birth != null)) {
        $date_of_birth .= " ";
    }

    if ($month_of_bith != null) {
        $date_of_birth .= process_month($month_of_bith);
    }

    if (($month_of_bith != null || $day_of_birth != null) && $year_of_birth != null) {
        $date_of_birth .= " ";
    }

    if ($year_of_birth != null) {
        $date_of_birth .= $year_of_birth;
    }

}

$statement->free_result();
$statement->close();


?>