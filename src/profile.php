<?php

require_once('scripts/scripts.php');

session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$page = new Page();
$page->displayHead( "'s Profile", array("styles/profile.css", "styles/profile-dark.css"));
$page->displayBodyStart();
?>

<div class='profile_name'>
	<h1 class="users_name"><!--'s Profile--></h1>
</div>

<div class='left_column'>
	<img id="info_profile_picture" class="image" src="srcPictures/defaultpicture.png" title="Avatar" alt="Avatar">
	<div class="requests">
		<img class="requests_image" src="srcPictures/icons8-new-message-100.png" title="Write a Message" alt="Write a Message">
		<img class="requests_image" src="srcPictures/icons8-add-user-group-man-man-100.png" title="Request Friendship" alt="Request Friendship">
		<img class="requests_image" src="srcPictures/icons8-user-account-100.png" title="Friends" alt="Friends">
	</div>
	<ul class="informations">
		<li>
            <span class="info_tag">Last Online</span>
            <span id="info_last_active" class="value"><!--Now--></span>
        </li>
		<li>
            <span class="info_tag">Gender</span>
            <span id="info_gender" class="value"><!--Male--></span>
        </li>
		<li>
            <span class="info_tag">Location</span>
            <span id="info_location" class="value"><!--Motherfucking Earth--></span>
        </li>
		<li>
            <span class="info_tag">Registered</span>
            <span id="info_registered" class="value"><!--17.6.1873--></span>
        </li>
		<li>
            <span class="info_tag">Date of Birth</span>
            <span id="info_date_of_birth" class="value"><!--13.6.1728 BC--></span>
        </li>
	</ul>
</div>

<div class='right_column'>
	<p id="profile_bio" class="bio"><!--Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Viverra tellus in hac habitasse. Habitant morbi tristique senectus et netus et malesuada fames. Porta non pulvinar neque laoreet suspendisse interdum. Lectus sit amet est placerat in egestas erat imperdiet sed. Quam lacus suspendisse faucibus interdum. Vitae aliquet nec ullamcorper sit. Nunc sed id semper risus in hendrerit gravida rutrum. Auctor elit sed vulputate mi. Tortor condimentum lacinia quis vel eros donec ac. Nisl rhoncus mattis rhoncus urna neque viverra justo nec. Habitasse platea dictumst vestibulum rhoncus est. Eget gravida cum sociis natoque penatibus et magnis dis parturient. Egestas quis ipsum suspendisse ultrices gravida dictum. Neque viverra justo nec ultrices dui sapien. Facilisis leo vel fringilla est. Enim nulla aliquet porttitor lacus luctus. Pharetra diam sit amet nisl suscipit adipiscing bibendum est ultricies. Arcu dictum varius duis at.--></p>
</div>


<?php
$page->displayBodyEnd(array("js/profile.js"));

?>