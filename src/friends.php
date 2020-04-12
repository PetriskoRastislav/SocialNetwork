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
	<img class="image" src="srcPictures/defaultpicture.png" title="Avatar">
	<div class="requests">
		<img class="requests_image" src="srcPictures/icons8-new-message-100.png" title="Write a Message" alt="Write a Message">
		<img class="requests_image" src="srcPictures/icons8-add-user-group-man-man-100.png" title="Request Frienship" alt="Request Frienship">
		<img class="requests_image" src="srcPictures/icons8-user-100.png" title="Profile" alt="Profile">
	</div>
	<ul class="informations">
		<li>
			<span class="info_tag">Last Online</span>
			<span class="value">Now</span>
		</li>
		<li>
			<span  class="info_tag">Gender</span>
			<span class="value">Male</span>
		</li>
		<li>
			<span class="info_tag">Location</span>
			<span class="value">Motherfucking Earth</span>
		</li>
		<li>
			<span class="info_tag">Registered</span>
			<span class="value">17.6.1873</span></li>
		<li>
			<span class="info_tag">Date of Birth</span>
			<span class="value">13.6.1728 BC</span>
		</li>
	</ul>
</div>

<div class='right_column'>
	<div class="friend">
		<img class="friend_avatar" src="srcPictures/defaultpicture.png" title="Friend's Avatar" alt="Friend's Avatar">
		<ul class="informations">
			<li>
				<span class="info_tag_friend">Name</span>
				<span class="value_friend">Tento Hominem</span>
			</li>
			<li>
				<span class="info_tag_friend">Last Online</span>
				<span class="value_friend">Now</span>
			</li>
			<li>
				<span class="info_tag_friend">Gender</span>
				<span class="value_friend">Male</span>
			</li>
			<li>
				<span class="info_tag_friend">Location</span>
				<span class="value_friend">Motherfucking Earth</span>
			</li>
		</ul>
	</div>

	<div class="friend">
		<img class="friend_avatar" src="srcPictures/defaultpicture.png" title="Friend's Avatar" alt="Friend's Avatar">
		<ul class="informations">
			<li>
				<span class="info_tag_friend">Name</span>
				<span class="value_friend">Tento Hominem</span>
			</li>
			<li>
				<span class="info_tag_friend">Last Online</span>
				<span class="value_friend">Now</span>
			</li>
			<li>
				<span class="info_tag_friend">Gender</span>
				<span class="value_friend">Male</span>
			</li>
			<li>
				<span class="info_tag_friend">Location</span>
				<span class="value_friend">Motherfucking Earth</span>
			</li>
		</ul>
	</div>

	<div class="friend">
		<img class="friend_avatar" src="srcPictures/defaultpicture.png" title="Friend's Avatar" alt="Friend's Avatar">
		<ul class="informations">
			<li>
				<span class="info_tag_friend">Name</span>
				<span class="value_friend">Tento Hominem</span>
			</li>
			<li>
				<span class="info_tag_friend">Last Online</span>
				<span class="value_friend">Now</span>
			</li>
			<li>
				<span class="info_tag_friend">Gender</span>
				<span class="value_friend">Male</span>
			</li>
			<li>
				<span class="info_tag_friend">Location</span>
				<span class="value_friend">Motherfucking Earth</span>
			</li>
		</ul>
	</div>
</div>

<?php

$page->displayBodyEnd(array());

?>