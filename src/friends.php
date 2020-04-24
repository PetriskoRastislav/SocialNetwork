<?php

require_once('scripts/scripts.php');
session_start();


/* checks if user is logged */

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}


/* gets id of user to whom belongs profile */

if (filled_out($_GET)) $id_user = $_GET['user'];
else $id_user = $_SESSION['id_user'];;


/* fills friends page */

try {
    $db = db_connect();
    mysqli_set_charset($db, "utf8");
}
catch (Exception $ex) {
    $ex->getMessage();
    exit();
}


/* heading */

if ($id_user == $_SESSION['id_user']) {

    $profile_heading = $_SESSION['name'] . " " . $_SESSION['surname'] . "'s Friends";

}
else {

    $query =
        "SELECT name, surname
    FROM users
    WHERE id_user = ?";
    $statement = $db->prepare($query);
    $statement->bind_param("i", $id_user);
    $statement->execute();
    $statement->bind_result($name, $surname);
    $statement->fetch();

    $profile_heading = $name . " " . $surname . "'s Friends";

    $statement->free_result();
    $statement->close();

}


/* informations about user (to left panel) */

require_once ("scripts/fills_user_s_info.php");


/* prints header of page */

$page = new Page();
$page->display_header( $profile_heading, array("styles/profile", "styles/friends"));
$page->display_body_start();

?>

<!-- heading of page -->

<div class='profile_name'>
    <h1 class="users_name"><?php echo $profile_heading; ?></h1>
</div>

<!-- left column with informations about user -->

<div class='left_column'>

    <!-- user's profile picture -->

    <img id="info_profile_picture" class="profile_picture" src="<?php echo $profile_picture_content; ?>" title="Avatar" alt="Avatar">

    <!-- buttons for profile control -->

    <div class="requests">

        <?php

        /* profile control buttons */


        /* button send message */
        echo print_write_message_button($id_user);


        /* button to show user's profile */
        echo print_profile_button($id_user);


        /* button to show settings */

        if ($id_user == $_SESSION['id_user']){

            echo print_settings_button();

        }


        /* button send friendship request / cancel friendship / cancel friendship request */

        if ($id_user != $_SESSION['id_user']){

            echo print_friendship_button($id_user);

        }


        ?>


    </div>

    <!-- informations about user -->

    <ul class="informations">
        <li>
            <span class="info_tag">Last Online</span>
            <span id="info_last_active" class="value"><?php echo $last_active_content; ?></span>
        </li>
        <li>
            <span class="info_tag">Gender</span>
            <span id="info_gender" class="value"><?php echo $gender_content; ?></span>
        </li>
        <li>
            <span class="info_tag">Location</span>
            <span id="info_location" class="value"><?php echo $location_content; ?></span>
        </li>
        <li>
            <span class="info_tag">Registered</span>
            <span id="info_registered" class="value"><?php echo $registered_content; ?></span>
        </li>
        <li>
            <span class="info_tag">Date of Birth</span>
            <span id="info_date_of_birth" class="value"><?php echo $date_of_birth; ?></span>
        </li>
    </ul>
</div>

<!-- main content of a page -->

<div class='right_column'>

    <?php


    /* if a logged user is viewing his list of friend will also see request for friendship */

    $is_requests = false;

    if ($id_user == $_SESSION['id_user']) {

        $query =
            "SELECT id_user, name, surname, profile_picture
            FROM users
            JOIN friendship_requests
            ON (friendship_requests.id_user_sender = users.id_user AND friendship_requests.id_user_receiver = ?)";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($id_user, $name, $surname, $profile_picture);

        $requests_list = "<div id='friendship_requests'>";

        while ($statement->fetch()) {

            $requests_list .= '<div class="friend">';

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

        }

        $requests_list .= "</div>";

        if ($is_requests) {

            print '<h2 class="friends_page">Pending Friendship requests</h2>';
            print $requests_list;

        }

        $statement->free_result();
        $statement->close();

    }



    /* prints user's list of friends */

    $query =
        "SELECT DISTINCT id_user, name, surname, profile_picture, last_active, gender, location
            FROM users
            JOIN friends
            ON ((friends.id_user_1 = ? AND friends.id_user_2 = users.id_user)
            OR (friends.id_user_1 = users.id_user AND friends.id_user_2 = ?))";
    $statement = $db->prepare($query);
    $statement->bind_param("ii", $id_user, $id_user);
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

    if ($is_requests) print '<h2 class="friends_page">Friends</h2>';
    print $friend_list;

    ?>

</div>

<?php

/* default js scripts */
$page->display_default_scripts();

?>

<script>

    let theme = "<?php echo $_SESSION['color_mode']; ?>";

</script>

<?php

/* additional js scripts */
$page->display_scripts(array("js/friend-control.js"));

/* end of document */
$page->display_body_end();

/* closing connection with database */
$db->close();

?>