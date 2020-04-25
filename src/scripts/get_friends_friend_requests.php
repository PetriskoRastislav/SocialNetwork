<?php


/* if a logged user is viewing his list of friend will also see request for friendship */


$central_area = "";

$is_requests = false;

if ($id_user_page == $_SESSION['id_user']) {

    $query =
        "SELECT users.id_user, users.name, users.surname, users.profile_picture, friendship_requests.status
        FROM users
        JOIN friendship_requests
        ON (friendship_requests.id_user_sender = users.id_user AND friendship_requests.id_user_receiver = ?)";
    $statement = $db->prepare($query);
    $statement->bind_param("i", $_SESSION['id_user']);
    $statement->execute();
    $statement->bind_result($id_user, $name, $surname, $profile_picture, $status);

    $requests_list = "<div id='friendship_requests'>";

    while ($statement->fetch()) {

        $requests_list .= '<div class="friend" id="f_r_' . $id_user . '">';

        if ($profile_picture == null) {
            $img = "src_pictures/blank-profile-picture-png-8.png";
        }
        else {
            $img = "user_pictures/" . $profile_picture;
        }

        $profile_pic = "background-image: url('" . $img . "')";

        $requests_list .= '<div class="friend_avatar request_f_a" style="' . $profile_pic . '" title="' . $name . ' ' . $surname . '\'s Avatar"></div>';

        $requests_list .=
            '<ul class="informations">' .
            '<li>' .
            '<span class="info_tag_friend">Name</span>' .
            '<a href="profile.php?user=' . $id_user . '" class="common">' .
            '<span class="value_friend">' . $name . ' ' . $surname . '</span>' .
            '</a>' .
            '</li>' .
            '<li>' .
            '<span id="accept_' . $id_user . '" class="process_request accept">Accept</span>' .
            '<span id="decline_' . $id_user . '" class="process_request decline">Decline</span>' .
            '</li>' .
            '</ul>' .
            '</div>';

        $is_requests = true;


        /* updates status of request to seen */

        if ($status == "unseen") {

            try {
                $db2 = db_connect();
                mysqli_set_charset($db2, "utf8");
            }
            catch (Exception $ex) {
                $ex->getMessage();
            }


            $query2 =
                "UPDATE friendship_requests
                SET status = 'seen'
                WHERE (id_user_sender = ? AND id_user_receiver = ? AND status = 'unseen')";
            $statement2 = $db2->prepare($query2);
            $statement2->bind_param("ii", $id_user, $_SESSION['id_user']);
            $statement2->execute();

            $statement2->free_result();
            $statement2->close();
            $db2->close();

        }

    }

    $requests_list .= "</div>";

    if ($is_requests) {

        $central_area .= '<h2 class="friends_page">Pending Friendship requests</h2>';
        $central_area .= $requests_list;

    }

    $statement->free_result();
    $statement->close();


}



/* prints user's list of friends */

$query =
    "SELECT id_user, name, surname, profile_picture, last_active, gender, location
            FROM users
            JOIN friends
            ON ((friends.id_user_1 = ? AND friends.id_user_2 = users.id_user)
            OR (friends.id_user_1 = users.id_user AND friends.id_user_2 = ?))";
$statement = $db->prepare($query);
$statement->bind_param("ii", $id_user_page, $id_user_page);
$statement->execute();
$statement->bind_result($id_user, $name, $surname, $profile_picture, $last_active, $gender, $location);

$friend_list = "<div id='friends_list'>";

while ($statement->fetch()) {

    $friend_list .= '<div class="friend">';

    if ($profile_picture == null) {
        $img = "src_pictures/blank-profile-picture-png-8.png";
    }
    else {
        $img = "user_pictures/" . $profile_picture;
    }

    $profile_pic = "background-image: url('" . $img . "')";

    $friend_list .= '<div class="friend_avatar" style="' . $profile_pic . '" title="' . $name . ' ' . $surname . '\'s Avatar"></div>';

    $friend_list .=
        '<ul class="informations">' .
        '<li>' .
        '<span class="info_tag_friend">Name</span>' .
        '<a href="profile.php?user=' . $id_user . '" class="common">' .
        '<span class="value_friend">' . $name . ' ' . $surname . '</span>' .
        '</a>' .
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
        $friend_list .= '<span class="value_friend">---</span>';
    }
    else {
        $friend_list .= '<span class="value_friend">' . $location . '</span>';
    }

    $friend_list .=
        '</li>' .
        '</ul>' .
        '</div>';

}

$friend_list .= "</div>";

$statement->free_result();
$statement->close();

if ($is_requests) $central_area .= '<h2 class="friends_page">Friends</h2>';
$central_area .= $friend_list;

print $central_area;

?>