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

	<img id="info_profile_picture" class="image" src="srcPictures/defaultpicture.png" title="Avatar"  alt="Avatar">

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
	<div>

		<h2>Change Password</h2>
			<ul>
				<li>
					<label for="password_old" class="info_tag_setting">Type your old Password</label>
					<input type="password" class="value_setting input_form" name="password_old" id="password_old" placeholder="Enter your old password" maxlength="97">
				</li>
				<li>
					<label for="password_new" class="info_tag_setting">Type your new Password</label>
					<input type="password" class="value_setting input_form" name="password_new" id="password_new" placeholder="Enter your new password" maxlength="97">
				</li>
				<li>
					<label for="password_new_again" class="info_tag_setting">Type your new Password again</label>
                    <input type="password" class="value_setting input_form" name="password_new_again" id="password_new_again" placeholder="Enter your new password again" maxlength="97">
                </li>
			</ul>
		    <input id="change_pass_button" type="button" value="Change" class="spacing_form button_form_submit button_setting">
            <div id="res_pass" class="settings_result"><p></p></div>
		<hr>

		<h2>Change Name</h2>
			<ul>
				<li>
					<label for="name" class="info_tag_setting">Type your new Name</label>
					<input id="name" type="text" class="value_setting input_form" name="name" placeholder="Enter your new name" maxlength="40">
				</li>
				<li>
					<label for="surname" class="info_tag_setting">Type your new Surname</label>
					<input id="surname" type="text" class="value_setting input_form" name="surname" placeholder="Enter your new surname" maxlength="40">
				</li>
			</ul>
            <input id="change_name_button" type="button" value="Change" class="spacing_form button_form_submit button_setting">
            <div id="res_name" class="settings_result"><p></p></div>
		<hr>

		<h2>Change Email</h2>
			<ul>
				<li>
					<label for="email" class="info_tag_setting">Type your new Email</label>
					<input type="email" id="email" class="value_setting input_form" name="email" placeholder="Enter your new email" maxlength="100">
				</li>
			</ul>
			<input id="change_email_button" type="button" value="Change" class="spacing_form button_form_submit button_setting">
            <div id="res_mail" class="settings_result"><p></p></div>
		<hr>

		<h2>Change Profile Picture</h2>
			<ul>
				<li>
					<label for="profile_pic" class="info_tag_setting">Choose your new Profile Picture</label>
					<input type="file" class="value_setting" name="profile_pic" id="profile_pic">
				</li>
			</ul>
			<input id="change_pic_button" type="button" value="Change" class="spacing_form button_form_submit button_setting">
            <div id="res_pic" class="settings_result"><p></p></div>
		<hr>

		<h2>Change Profile Details</h2>
			<ul>
				<li>
					<label for="location" class="info_tag_setting">Type your new Location</label>
					<input id="location" type="text" class="value_setting input_form" name="location" placeholder="Enter your new location" maxlength="100">
				</li>
				<li>
					<label for="gender" class="info_tag_setting">Choose your new Gender</label>
					<select id="gender" name="gender" class="select_input">
	    				<option value="other">Other</option>
	    				<option value="male">Male</option>
	   					<option value="female">Female</option>
					</select>
				</li>
				<li>
					<label for="day_of_birth" class="info_tag_setting">Type your new Day of Birthday</label>
					<select id="day_of_birth" name="day_of_birth" class="select_input">
	    				<option value="0">--</option>
	    				<option value="1">01</option>
	   					<option value="2">02</option>
	   					<option value="3">03</option>
	   					<option value="4">04</option>
	   					<option value="5">05</option>
	   					<option value="6">06</option>
	   					<option value="7">07</option>
	   					<option value="8">08</option>
	   					<option value="9">09</option>
	   					<option value="10">10</option>
	   					<option value="11">11</option>
	   					<option value="12">12</option>
	   					<option value="13">13</option>
	   					<option value="14">14</option>
	   					<option value="15">15</option>
	   					<option value="16">16</option>
	   					<option value="17">17</option>
	   					<option value="18">18</option>
	   					<option value="19">19</option>
	   					<option value="20">20</option>
	   					<option value="21">21</option>
	   					<option value="22">22</option>
	   					<option value="23">23</option>
	   					<option value="24">24</option>
	   					<option value="25">25</option>
	   					<option value="26">26</option>
	   					<option value="27">27</option>
	   					<option value="28">28</option>
	   					<option value="29">29</option>
	   					<option value="30">30</option>
	   					<option value="31">31</option>
					</select>
				</li>
				<li>
					<label for="month_of_birth" class="info_tag_setting">Type your new Month of Birthday</label>
					<select id="month_of_birth" name="month_of_birth" class="select_input">
	    				<option value="0">--</option>
	    				<option value="1">01</option>
	   					<option value="2">02</option>
	   					<option value="3">03</option>
	   					<option value="4">04</option>
	   					<option value="5">05</option>
	   					<option value="6">06</option>
	   					<option value="7">07</option>
	   					<option value="8">08</option>
	   					<option value="9">09</option>
	   					<option value="10">10</option>
	   					<option value="11">11</option>
	   					<option value="12">12</option>
	   				</select>
				</li>
				<li>
					<label for="year_of_birth" class="info_tag_setting">Type your new Year of Birthday</label>
					<input type="text" class="value_setting input_form" id="year_of_birth" name="year_of_birth" placeholder="Enter your new year of birthday" maxlength="15">
				</li>
			</ul>
			<input id="change_info_button" type="button" value="Change" class="spacing_form button_form_submit button_setting">
            <div id="res_info" class="settings_result"><p></p></div>
		<hr>


		<h2>Change the Theme</h2>
			<ul>
				<li>
					<label for="change_theme" class="info_tag_setting">Enable Dark Theme</label>
				</li>
				<li>
					<label for="change_theme" class="switch">
						<input id="change_theme" name="change_theme" type="checkbox" value="dark">
  						<span class="slider round"></span>
					</label>
				</li>
			</ul>
			<input id="change_theme_button" type="button" value="Change" class="spacing_form button_form_submit button_setting">
            <div id="res_theme" class="settings_result"><p></p></div>
		<hr>

		<h2>Change the Biography</h2>
			<ul>
				<li>
					<label for="biography" class="info_tag_setting">Type something about you</label>
				</li>
				<li>
					<textarea name="biography" id="biography" cols="50" rows="5" placeholder="Write something about you"></textarea>
				</li>
			</ul>
			
			<input id="change_bio_button" type="button" value="Change" class="spacing_form button_form_submit button_setting">
            <div id="res_bio" class="settings_result"><p></p></div>
		<hr>

		<input id="change_all_button" type="button" value="Change ALL" class="spacing_form button_form_submit button_setting">
        <div id="res_all" class="settings_result"><p></p></div>

	</div>
</div>

<?php

$page->displayBodyEnd(array("js/validate_inputs.js", "js/profile_functions.js", "js/user_settings.js"));

?>