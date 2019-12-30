<?php
    require_once('scripts/scripts.php');

    session_start();

    if(isset($_SESSION['id_user'])){
        header('Location: user.php');
        exit();
    }

    $page = new Page();
    $page->displayHead( "login", array("styles/style_form.css", "styles/style_form-dark.css"));
    $page->displayBodyStart();
?>

<div class="div_form_logreg" id="div_reg">

    <button onclick="showLogForm()" class="logreg_button logreg_active" id="log_button">Prihlásenie</button>
    <button onclick="showRegForm()" class="logreg_button" id="reg_button">Registrácia</button>

    <form method="POST" class="logreg" id="registration">

        <p class="spacing_form">
            <label for="name_reg">
                Meno:
                <span class="required">*</span>
            </label>
        </p>
        <input required class="spacing_form input_form" type="text" name="name" id="name_reg" size="35" placeholder="meno" />

        <p class="spacing_form">
            <label for="surname_reg">
                Priezvisko:
                <span class="required">*</span>
            </label>
        </p>
        <input required class="spacing_form input_form" type="text" name="surname" id="surname_reg" size="35" placeholder="priezvisko" />

        <p class="spacing_form">
            <label for="email_reg">
                E-mail:
                <span class="required">*</span>
            </label>
        </p>
        <input required class="spacing_form input_form" type="email" name="email" id="email_reg" size="35" placeholder="e-mail" />

        <p class="spacing_form">
            <label for="password1_reg">
                Heslo:
                <span class="required">*</span>
            </label>
        </p>
        <input required class="spacing_form input_form" type="password" name="password1" id="password1_reg" size="35" placeholder="heslo" />

        <p class="spacing_form">
            <label for="password2_reg">
                Heslo znova:
                <span class="required">*</span>
            </label>
        </p>
        <input required class="spacing_form input_form" type="password" name="password2" id="password2_reg" size="35" placeholder="heslo znovu" />

        <p class="spacing_form">
            <button class="spacing_form button_form_submit" type="submit" form="registration" formaction="scripts/registration.php">Zaregistrovať</button>
        </p>

        <p class="spacing_form"><span class="required">*</span> Povinné pole.</p>

    </form>

    <form method="POST" class="logreg" id="login">

        <p class="spacing_form">
            <label for="email_log">
                E-mail:
            </label>
        </p>
        <input required class="spacing_form input_form" type="email" name="email" id="email_log" size="35" placeholder="e-mail" />

        <p class="spacing_form">
            <label for="password_log">
                Heslo:
            </label>
        </p>
        <input required class="spacing_form input_form" type="password" name="password" id="password_log" size="35" placeholder="heslo" />

        <p class="spacing_form">
            <button class="spacing_form button_form_submit" type="submit" form="login" formaction="scripts/login.php">Prihlásiť</button>
        </p>

    </form>



</div>

<script src="js/toggle_log_reg_forms.js"></script>

<?php
    $page->displayBodyEnd();
?>


