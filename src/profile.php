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


/* fills profile page */

try {
    $db = db_connect();
    mysqli_set_charset($db, "utf8");
}
catch (Exception $ex) {
    $ex->getMessage();
    exit();
}


/* heading and user's biography */

$query =
    "SELECT name, surname, bio
    FROM users
    WHERE id_user = ?";
$statement = $db->prepare($query);
$statement->bind_param("i", $id_user);
$statement->execute();
$statement->bind_result($name, $surname, $bio);
$statement->fetch();


$profile_heading = $name . " " . $surname . "'s Profile";

$bio_content = "";

if ($bio == null) {
    if ($id_user == $_SESSION['id_user']) {
        $bio_content = "No biography written yet. Write it <a class='common' href='user_settings.php#user_bio'>now</a>!";
    }
}
else {
    $bio_content = $bio;
}

$statement->free_result();
$statement->close();


/* informations about user (to left panel) */

require_once ("scripts/fills_user_s_info.php");


/* prints header of page */

$page = new Page();
$page->display_header( $profile_heading, array("styles/profile"));
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


        /* button to show user's friends */
        echo print_friends_button($id_user);


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
	<p id="profile_bio" class="bio"><?php echo $bio_content; ?></p>
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