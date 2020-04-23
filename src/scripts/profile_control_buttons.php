<?php


/* returns button to send message to user */
function print_write_message_button ($id_user) {

    $button =
        '<a href="messages.php?user=' . $id_user . '" class="requests_a">' .
        '<img class="requests_image requests_image_en" src="';

    if($_SESSION['color_mode'] === "dark") $button .= "src_pictures/icons8-new-message-100-white.png";
    else $button .= "src_pictures/icons8-new-message-100.png";

    $button .= '" title="Write a Message" alt="Write a Message"></a>';

    return $button;

}


/* returns button to show user's profile */
function print_profile_button ($id_user) {

    $button =
        '<a href="profile.php?user=' . $id_user . '" class="requests_a">' .
        '<img class="requests_image requests_image_en" src="';

    if ($_SESSION['color_mode'] == "dark") $button .= "src_pictures/icons8-user-100-white.png";
    else $button .= "src_pictures/icons8-user-100.png";

    $button .= '" title="Profile" alt="Profile"></a>';

    return $button;

}


/* returns button to show user's friends */
function print_friends_button ($id_user) {

    $button =
        '<a href="friends.php?user=' . $id_user . '" class="requests_a">' .
        '<img class="requests_image requests_image_en" src="';

    if($_SESSION['color_mode'] == "dark") $button .= "src_pictures/icons8-user-account-100-white.png";
    else $button .= "src_pictures/icons8-user-account-100.png";

    $button .= '" title="Friends" alt="Friends"></a>';

    return $button;

}


/* returns button to show settings of logged user (only in logged user's profile) */
function print_settings_button () {

    $button =
        '<a href="user_settings.php" class="requests_a">' .
        '<img class="requests_image requests_image_en" src="';

    if($_SESSION['color_mode'] == "dark") $button .= "src_pictures/icons8-settings-100-white.png";
    else $button .= "src_pictures/icons8-settings-100.png.png";

    $button .= '" title="Settings" alt="Settings"></a>';

    return $button;

}


function print_friendship_button ($id_user) {

    /* connect to database */

    try {
        $db = db_connect();
        mysqli_set_charset($db, "utf8");
    }
    catch (Exception $ex) {
        $ex->getMessage();
        exit();
    }


    /* finds out if user is friend of logged user */

    $query =
        "SELECT id_friendship
                FROM friends
                WHERE (id_user_1 = ? AND id_user_2 = ?)
                OR (id_user_1 = ? AND id_user_2 = ?)";
    $statement = $db->prepare($query);
    $statement->bind_param("iiii", $id_user, $_SESSION['id_user'], $_SESSION['id_user'], $id_user);
    $statement->execute();
    $statement->bind_result($id_friendship);
    $statement->fetch();

    $button = '<img class="requests_image requests_image_en" src="';

    if ($id_friendship > 0) {

        /* if user is friend of logged user returns button to cancel friendship */

        if($_SESSION['color_mode'] == "dark") $button .= "src_pictures/icons8-remove-user-group-man-man-100-white.png";
        else $button .= "src_pictures/icons8-remove-user-group-man-man-100.png";

        $button .= '" id="cancel_friendship" title="Cancel Friendship" alt="Cancel Friendship">';
    }
    else {

        /* if user isn't friend of logged user finds out if request for friendship has been sent */

        $query =
            "SELECT id_request
                    FROM friendship_requests
                    WHERE (id_user_sender = ? AND id_user_receiver = ?)
                    OR (id_user_sender = ? AND id_user_receiver = ?)";
        $statement2 = $db->prepare($query);
        $statement2->bind_param("iiii", $id_user, $_SESSION['id_user'], $_SESSION['id_user'], $id_user);
        $statement2->execute();
        $statement2->bind_result($id_request);
        $statement2->fetch();

        if ($id_request > 0){

            /* if request for friendship has been sent returns button to cancel request */

            if($_SESSION['color_mode'] == "dark") $button .= "src_pictures/icons8-remove-user-group-man-man-100-white.png";
            else $button .= "src_pictures/icons8-remove-user-group-man-man-100.png";

            $button .= '" id="cancel_friendship_request" title="Cancel Friendship Request" alt="Cancel Friendship Request">';

        }
        else {

            /* if request hasn't been sent returns button to send request */

            if($_SESSION['color_mode'] == "dark") $button .= "src_pictures/icons8-add-user-group-man-man-100-white.png";
            else $button .= "src_pictures/icons8-add-user-group-man-man-100.png";

            $button .= '" id="request_friendship" title="Request Friendship" alt="Request Friendship">';

        }

        $statement2->free_result();
        $statement2->close();

    }

    $statement->free_result();
    $statement->close();
    $db->close();

    return $button;

}


?>