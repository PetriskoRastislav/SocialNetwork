<?php

require_once('scripts/scripts.php');

session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$page = new Page();
$page->display_header( "'s Profile", array("styles/profile"));
$page->display_body_start();

?>

<!-- heading of page -->

<div class='profile_name'>
	<h1 class="users_name"></h1>
</div>

<!-- left column with informations about user -->

<div class='left_column'>

    <!-- user's profile picture -->

    <img id="info_profile_picture" class="profile_picture" src="" title="Avatar" alt="Avatar">

    <!-- buttons for profile control -->

    <div class="requests">

    </div>

    <!-- informations about user -->

    <ul class="informations">
        <li>
            <span class="info_tag">Last Online</span>
            <span id="info_last_active" class="value"></span>
        </li>
        <li>
            <span class="info_tag">Gender</span>
            <span id="info_gender" class="value"></span>
        </li>
        <li>
            <span class="info_tag">Location</span>
            <span id="info_location" class="value"></span>
        </li>
        <li>
            <span class="info_tag">Registered</span>
            <span id="info_registered" class="value"></span>
        </li>
        <li>
            <span class="info_tag">Date of Birth</span>
            <span id="info_date_of_birth" class="value"></span>
        </li>
    </ul>
</div>

<!-- main content of a page -->

<div class='right_column'>
	<p id="profile_bio" class="bio"></p>
</div>

<script>
    let theme = "<?php echo $_SESSION['color_mode']; ?>";
</script>

<?php
$page->display_body_end(array("js/profile_functions.js", "js/profile.js"));

?>