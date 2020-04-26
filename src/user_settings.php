<?php

require_once('scripts/scripts.php');
session_start();


/* checks if user is logged */

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}


/* gets id of user to whom belongs profile */
$id_user_page = $_SESSION['id_user'];;


/* fills settings page */

try {
    $db = db_connect();
    mysqli_set_charset($db, "utf8");
}
catch (Exception $ex) {
    $ex->getMessage();
    exit();
}


/* informations about user (to left panel) */

require_once ("scripts/fills_user_s_info.php");


/* prints header of page */

$page = new Page();
$page->display_header( "Settings", array("styles/profile", "styles/user_settings"));
$page->display_body_start();

?>

<!-- heading of page -->

<div class='profile_name'>
	<h1 class="users_name">Settings</h1>
</div>

<!-- left column with informations about user -->

<div class='left_column'>

    <!-- user's profile picture -->

    <img id="info_profile_picture" class="profile_picture" src="<?php echo $profile_picture_content; ?>" title="Avatar" alt="Avatar">

    <div class="hr reduced_width"></div>

    <!-- buttons for profile control -->

    <div class="requests">

        <?php

        /* profile control buttons */

        /* button send message */
        echo print_write_message_button($id_user_page);


        /* button to show user's profile */
        echo print_profile_button($id_user_page);


        /* button to show user's friends */
        echo print_friends_button($id_user_page);

        ?>

    </div>

    <!-- informations about user -->

    <div class="hr reduced_width"></div>

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

        <!-- division for changing password -->

		<h2>Change Password</h2>
			<ul>
				<li>
					<label for="password_old" class="info_tag_setting">Type your old Password</label>
					<input type="password" class="input_form" name="password_old" id="password_old" placeholder="Enter your old password">
                    <img id="pass_old_status" src="" alt="" class="stat hide">
				</li>
				<li>
					<label for="password_new" class="info_tag_setting">Type your new Password</label>
					<input type="password" class="input_form" name="password_new" id="password_new" placeholder="Enter your new password">
                    <img id="pass_new_status" src="" alt="" class="stat hide">
				</li>
				<li>
					<label for="password_new_again" class="info_tag_setting">Type your new Password again</label>
                    <input type="password" class="input_form" name="password_new_again" id="password_new_again" placeholder="Enter your new password again">
                    <img id="pass_new_again_status" src="" alt="" class="stat hide">
                </li>
			</ul>
		    <input id="change_pass_button" type="button" value="Change" class="spacing_form button_form_submit button_setting">
            <div id="res_pass" class="form_result"><p></p></div>
        <div class="hr double_margin"></div>

        <!-- division for changing name -->

        <h2>Change Name</h2>
			<ul>
				<li>
					<label for="name" class="info_tag_setting">Change your Name</label>
					<input id="name" type="text" class="input_form" name="name" placeholder="Enter your new name" maxlength="40">
				</li>
				<li>
					<label for="surname" class="info_tag_setting">Change your Surname</label>
					<input id="surname" type="text" class="input_form" name="surname" placeholder="Enter your new surname" maxlength="40">
				</li>
			</ul>
            <input id="change_name_button" type="button" value="Change" class="spacing_form button_form_submit button_setting">
            <div id="res_name" class="form_result"><p></p></div>
		<div class="hr"></div>

        <!-- division for changing email -->

		<h2>Change Email</h2>
			<ul>
				<li>
					<label for="email" class="info_tag_setting">Change your Email</label>
					<input type="email" id="email" class="input_form" name="email" placeholder="Enter your new email" maxlength="100">
                    <img id="mail_status" src="" alt="" class="stat hide">
				</li>
			</ul>
			<input id="change_email_button" type="button" value="Change" class="spacing_form button_form_submit button_setting">
            <div id="res_mail" class="form_result"><p></p></div>
		<div class="hr"></div>

        <!-- division for changing profile picture -->

		<h2>Change Profile Picture</h2>
            <form method="post" enctype="multipart/form-data" id="change_pic">
                <ul>
                    <li>
                        <div id="preview"><img src="" alt="Upload image preview"></div>
                    </li>
                    <li>
                        <label for="profile_pic" class="info_tag_setting">Choose your new Profile Picture</label>
                        <input type="file" class="" name="profile_pic" id="profile_pic" accept="image/*">
                    </li>
                </ul>
                <input id="change_pic_button" type="button" value="Change" class="spacing_form button_form_submit button_setting" accept="image/jpeg image/png">
                <div id="res_pic" class="form_result"><p></p></div>
            </form>
		<div class="hr"></div>

        <!-- division for changing other informations about user -->

		<h2>Change Profile Details</h2>
			<ul>
				<li>
					<label for="location" class="info_tag_setting">Change your Location</label>
					<input id="location" type="text" class="input_form" name="location" placeholder="Enter your new location" maxlength="100">
				</li>
				<li>
					<label for="gender" class="info_tag_setting">Change your Gender</label>
					<select id="gender" name="gender" class="select_form">
	    				<option value="other">Other</option>
	    				<option value="male">Male</option>
	   					<option value="female">Female</option>
					</select>
				</li>
				<li>
					<label for="day_of_birth" class="info_tag_setting">Change your Day of Birth</label>
					<select id="day_of_birth" name="day_of_birth" class="select_form">
	    				<option value="--">--</option>
	    				<option value="01">01</option>
	   					<option value="02">02</option>
	   					<option value="03">03</option>
	   					<option value="04">04</option>
	   					<option value="05">05</option>
	   					<option value="06">06</option>
	   					<option value="07">07</option>
	   					<option value="08">08</option>
	   					<option value="09">09</option>
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
					<label for="month_of_birth" class="info_tag_setting">Change your Month of Birth</label>
					<select id="month_of_birth" name="month_of_birth" class="select_form">
	    				<option value="--">--</option>
	    				<option value="01">January</option>
	   					<option value="02">February</option>
	   					<option value="03">March</option>
	   					<option value="04">April</option>
	   					<option value="05">May</option>
	   					<option value="06">June</option>
	   					<option value="07">July</option>
	   					<option value="08">August</option>
	   					<option value="09">September</option>
	   					<option value="10">October</option>
	   					<option value="11">November</option>
	   					<option value="12">December</option>
	   				</select>
				</li>
				<li>
					<label for="year_of_birth" class="info_tag_setting">Change your Year of Birth</label>
					<input type="text" class="input_form" id="year_of_birth" name="year_of_birth" placeholder="Enter your year of birth" maxlength="4">
				</li>
			</ul>
			<input id="change_info_button" type="button" value="Change" class="spacing_form button_form_submit button_setting">
            <div id="res_info" class="form_result"><p></p></div>
		<div class="hr"></div>

        <!-- division for changing theme (dark / light) -->

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
            <div id="res_theme" class="form_result"><p></p></div>
		<div class="hr"></div>

        <!-- division for changing biography -->

		<h2>Change the Biography</h2>
			<ul>
				<li>
					<label for="biography" class="info_tag_setting">Write something about you</label>
				</li>
				<li>
					<textarea name="biography" id="biography" class="text_area_form" cols="50" rows="5" placeholder="Write something about you"></textarea>
				</li>
			</ul>
			
			<input id="change_bio_button" type="button" value="Change" class="spacing_form button_form_submit button_setting">
            <div id="res_bio" class="form_result"><p></p></div>


</div>


<?php

/* default js scripts */
$page->display_default_scripts();

?>

<script>



</script>

<?php

/* additional js scripts */
$page->display_scripts(array("js/validate_inputs.js", "js/user_settings.js"));

/* end of document */
$page->display_body_end();

/* closing connection with database */
$db->close();

?>