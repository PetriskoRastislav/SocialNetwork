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

<div class='namer'>
	<h1 class="users_name">'s Profile</h1>
</div>

<div class='image_informations'>
	<img class="image" src="srcPictures/defaultpicture.png" title="Avatar">
	<div class="requests">
		<img class="requests_image" src="srcPictures/icons8-new-message-100.png" title="Write a Message" alt="Write a Message">
		<img class="requests_image" src="srcPictures/icons8-add-user-group-man-man-100.png" title="Request Frienship" alt="Request Frienship">
		<img class="requests_image" src="srcPictures/icons8-user-account-100.png" title="Friends" alt="Friends">
	</div>
	<ul class="informations">
		<li><span class="info_tag">Last Online</span><span class="value">Now</span></li>
		<li><span  class="info_tag">Gender</span><span class="value">Male</span></li>
		<li><span  class="info_tag">Location</span><span class="value">Motherfucking Earth</span></li>
		<li><span  class="info_tag">Registered</span><span class="value">17.6.1873</span></li>
		<li><span  class="info_tag">Date of Birth</span><span class="value">13.6.1728 BC</span></li>
	</ul>
</div>

<div class='bio'>
	<p>bio</p>
</div>


<?php
$page->displayBodyEnd(array());

?>