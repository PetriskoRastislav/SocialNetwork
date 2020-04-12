<?php

require_once('scripts/scripts.php');

session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$page = new Page();
$page->displayHead( "Settings", array("styles/profile.css", "styles/profile-dark.css", "styles/style_form.css", "styles/style_form-dark.css", "styles/user_settings.css", "styles/user_settings-dark.css"));
$page->displayBodyStart();

?>

<div class='profile_name'>
	<h1 class="users_name">Settings</h1>
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
			<span class="info_tag">Gender</span>
			<span class="value">Male</span></li>
		<li>
			<span class="info_tag">Location</span>
			<span class="value">Motherfucking Earth</span>
		</li>
		<li>
			<span class="info_tag">Registered</span>
			<span class="value">17.6.1873</span>
		</li>
		<li>
			<span class="info_tag">Date of Birth</span>
			<span class="value">13.6.1728 BC</span>
		</li>
	</ul>
</div>

<div class='right_column'>
	<div>
		<h2>Change Password</h2>
			<ul>
				<li>
					<label for="password" class="info_tag_setting">Type your old Password</label>
					<input type="password" class="value_setting input_form" name="password" placeholder="Enter your old password" maxlength="97">
				</li>
				<li>
					<label for="password1" class="info_tag_setting">Type your new Password</label>
					<input type="password" class="value_setting input_form" name="password1" placeholder="Enter your new password" maxlength="97">
				</li>
				<li>
					<label for="password2" class="info_tag_setting">Type your new Password again</label>
					<input type="password2" class="value_setting input_form" name="password" placeholder="Enter your new password again" maxlength="97">
				</li>
			</ul>
		<input type="button" value="Change" class="spacing_form button_form_submit button_setting">
		<hr>

		<h2>Change Name</h2>
			<ul>
				<li>
					<label for="name" class="info_tag_setting">Type your new Name</label>
					<input type="text" class="value_setting input_form" name="name" placeholder="Enter your new name" maxlength="40">
				</li>
				<li>
					<label for="surname" class="info_tag_setting">Type your new Surname</label>
					<input type="text" class="value_setting input_form" name="surname" placeholder="Enter your new surname" maxlength="40">
				</li>
			</ul>
			<input type="button" value="Change" class="spacing_form button_form_submit button_setting">
		<hr>

		<h2>Change Email</h2>
			<ul>
				<li>
					<label for="email" class="info_tag_setting">Type your new Email</label>
					<input type="email" class="value_setting input_form" name="email" placeholder="Enter your new email" maxlength="100">
				</li>
			</ul>
			<input type="button" value="Change" class="spacing_form button_form_submit button_setting">	
		<hr>

		<h2>Change Profile Picture</h2>
			<ul>
				<li>
					<label for="profile_pic" class="info_tag_setting">Choose your new Profile Picture</label>
					<input type="file" class="value_setting" name="profile_pic">
				</li>
			</ul>
			<input type="button" value="Change" class="spacing_form button_form_submit button_setting">	
		<hr>

		<h2>Change Profile Details</h2>
			<ul>
				<li>
					<label for="location" class="info_tag_setting">Type your new Location</label>
					<input type="text" class="value_setting input_form" name="location" placeholder="Enter your new location" maxlength="100">
				</li>
				<!--<li>
					<label for="gender" class="info_tag_setting">Choose your new Gender</label>
					<input type="radio" class="value_setting input_form" name="gender" checked="checked">
					<label for="gender">Other</label>
					<input type="radio" class="value_setting input_form" name="gender">
					<label for="gender">Male</label>
					<input type="radio" class="value_setting input_form" name="gender">
					<label for="gender">Female</label>
				</li>-->
				<li>
					<label for="day_of_birthday" class="info_tag_setting">Type your new Day of Birthday</label>
					<input type="text" class="value_setting input_form" name="day_of_birthday" placeholder="Enter your new day of birthday" maxlength="2">
				</li>
				<li>
					<label for="month_of_birthday" class="info_tag_setting">Type your new Day of Birthday</label>
					<input type="text" class="value_setting input_form" name="month_of_birthday" placeholder="Enter your new month of birthday" maxlength="2">
				</li>
				<li>
					<label for="year_of_birthday" class="info_tag_setting">Type your new Year of Birthday</label>
					<input type="text" class="value_setting input_form" name="year_of_birthday" placeholder="Enter your new year of birthday" maxlength="15">
				</li>
			</ul>
			<input type="button" value="Change" class="spacing_form button_form_submit button_setting">
		<hr>


		<h2>Change the Theme</h2>
			<ul>
				<li>
					<label for="theme" class="info_tag_setting">Choose your new Theme</label>
				</li>
			</ul>
			<input type="button" value="Change" class="spacing_form button_form_submit button_setting">
		<hr>

		<h2>Change the Biography</h2>
			<ul>
				<li>
					<label for="bio" class="info_tag_setting">Type something about you</label>
				</li>
				<li>
					<textarea name="bio" id="user_bio" cols="50" rows="5" placeholder="Write something about you"></textarea>
				</li>
			</ul>
			
			<input type="button" value="Change" class="spacing_form button_form_submit button_setting">
		<hr>

		<input type="button" value="Change ALL" class="spacing_form button_form_submit button_setting">
	</div>
</div>

<?php

$page->displayBodyEnd(array());

?>