<?php
    if(isset($_SESSION['user'])) header('Location: user.php');
    require('page.php');
    $page = new Page();
    $page->displayHead( "login", array("styles/style_form.css", "styles/style_form-dark.css"));
    $page->displayBodyStart();
?>

<div class="div_form_logreg" id="div_reg">

    <button onclick="showLogForm()" class="logreg_button logreg_active" id="log_button">Prihlásenie</button>
    <button onclick="showRegForm()" class="logreg_button" id="reg_button">Registrácia</button>

    <form method="POST" class="logreg" id="registration" action="registration.php">

        <p class="spacing_form">
            Meno:
            <span class="required">*</span>
        </p>
        <input required class="spacing_form input_form" type="text" name="name" size="35" placeholder="meno">

        <p class="spacing_form">
            Priezvisko:
            <span class="required">*</span>
        </p>
        <input required class="spacing_form input_form" type="text" name="surname" size="35" placeholder="priezvisko">

        <p class="spacing_form">
            E-mail:
            <span class="required">*</span>
        </p>
        <input required class="spacing_form input_form" type="email" name="email" size="35" placeholder="e-mail">

        <p class="spacing_form">
            Heslo:
            <span class="required">*</span>
        </p>
        <input required class="spacing_form input_form" type="password" name="password" size="35" placeholder="heslo">

        <p class="spacing_form">
            Heslo znova:
            <span class="required">*</span>
        </p>
        <input required class="spacing_form input_form" type="password" name="password_again" size="35" placeholder="heslo znovu">

        <p class="spacing_form">
            <button class="spacing_form button_form_submit" type="submit" form="registration" formaction="">Zaregistrovať</button>
        </p>

        <p class="spacing_form"><span class="required">*</span> Povinné pole.</p>

    </form>

    <form method="POST" class="logreg" id="login" action="login.php">

        <p class="spacing_form">
            E-mail
        </p>
        <input required class="spacing_form input_form" type="email" name="email" size="35" placeholder="e-mail">

        <p class="spacing_form">
            Heslo
        </p>
        <input required class="spacing_form input_form" type="password" name="password" size="35" placeholder="heslo">

        <p class="spacing_form">
            <button class="spacing_form button_form_submit" type="submit" form="login" formaction="">Prihlásiť</button>
        </p>

    </form>



</div>

<script src="js/toggle_log_reg_forms.js"></script>

<?php
    $page->displayBodyEnd();
?>


