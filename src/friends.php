<?php

require_once('scripts/scripts.php');

session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$page = new Page();
$page->displayHead( "Friends", array("styles/profile.css", "styles/profile-dark.css", "styles/friends.css"));
$page->displayBodyStart();

?>

<div class='profile_name'>
	<h1 class="users_name">'s Friends</h1>
</div>

<div class='left_column'>

    <img id="info_profile_picture" class="image" src="" title="Avatar" alt="Avatar">

	<div class="requests">
        <!--
        <img class="requests_image requests_image_en" src="srcPictures/icons8-new-message-100.png" title="Write a Message" alt="Write a Message">
        <img class="requests_image requests_image_en" src="srcPictures/icons8-add-user-group-man-man-100.png" title="Request Friendship" alt="Request Friendship">
		<img class="requests_image requests_image_en" src="srcPictures/icons8-user-100.png" title="Profile" alt="Profile">
		-->
	</div>

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

<div class='right_column'>

</div>

<?php

$page->displayBodyEnd(array("js/profile_functions.js", "js/friends.js"));

?>