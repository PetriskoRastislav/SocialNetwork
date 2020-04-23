<?php

require_once('scripts/scripts.php');
session_start();

/* checks if user is logged */

if(isset($_SESSION['id_user'])) {
    header("Location: profile.php?user=" . $_SESSION['id_user']);
    exit();
}


/* prints header of page */

$page = new Page();
$page->display_header( "Login", array("styles/style_form", "styles/index"));
$page->display_body_start();

?>

<div class="div_form_log_reg" id="div_reg">

    <button class="log_reg_button log_reg_active" id="show_login">Log In</button>
    <button class="log_reg_button" id="show_registration">Register</button>

    <form id="registration" method="POST" class="log_reg hide">

        <p class="spacing_form">
            <label for="name_reg">Name</label>
        </p>
        <input required class="spacing_form input_form" type="text" name="name_reg" id="name_reg" placeholder="Name" maxlength="40"/>

        <p class="spacing_form">
            <label for="surname_reg">Surname</label>
        </p>
        <input required class="spacing_form input_form" type="text" name="surname_reg" id="surname_reg" placeholder="Surname" maxlength="40"/>

        <p class="spacing_form">
            <label for="email_reg">Email</label>
        </p>
        <input required class="spacing_form input_form" type="email" name="email_reg" id="email_reg" placeholder="Email" maxlength="100"/>
        <img id="email_reg_status" src="" alt="" class="stat">

        <p class="spacing_form">
            <label for="password_reg">Password</label>
        </p>
        <input required class="spacing_form input_form" type="password" name="password_reg" id="password_reg" placeholder="Password" />
        <img id="pass_reg_status" src="" alt="" class="stat">

        <p class="spacing_form">
            <label for="password_reg_again">Confirm your password</label>
        </p>
        <input required class="spacing_form input_form" type="password" name="password_reg_again" id="password_reg_again" placeholder="Confirm password" />
        <img id="pass_reg_again_status" src="" alt="" class="stat">

        <div id="res_reg" class="form_result spacing_form"><p></p></div>

        <p class="spacing_form">
            <input id="register_submit" class="spacing_form button_form_submit" type="button" form="register" value="Register" />
        </p>

    </form>

    <form id="login" method="POST" class="log_reg">

        <p class="spacing_form">
            <label for="email_log">Email</label>
        </p>
        <input required class="spacing_form input_form" type="email" name="email_log" id="email_log" placeholder="Email" maxlength="100"/>

        <p class="spacing_form">
            <label for="password_log">Password</label>
        </p>
        <input required class="spacing_form input_form" type="password" name="password_log" id="password_log" placeholder="Password" />

        <div id="res_log" class="form_result spacing_form"><p></p></div>

        <p class="spacing_form">
            <input id="login_submit" class="spacing_form button_form_submit" type="button" form="login" value="Log IN"/>
        </p>

    </form>



</div>


<?php

/* default js scripts */
$page->display_default_scripts();

?>


<?php

/* additional js scripts */
$page->display_scripts(array("js/validate_inputs.js", "js/log_reg.js"));

/* end of document */
$page->display_body_end();

?>