<?php
    require('page.php');
    $page = new Page();
    $page->displayHead( "login", array("styles/style_form.css", "styles/style_form-dark.css"));
    $page->displayBodyStart();
    $page->displayHeader();
?>

<div class="div_form_logreg" id="div_reg">

    <button onclick="showLogForm()" class="logreg_button logreg_active" id="log_button">Prihlásenie</button>
    <button onclick="showRegForm()" class="logreg_button" id="reg_button">Registrácia</button>

    <form method="POST" class="logreg" id="registration" action="">

        <p class="spacing_form">
            Meno
            <span class="required">*</span>
        </p>
        <input required class="spacing_form input_form" type="text" name="meno" size="35" placeholder="meno">

        <p class="spacing_form">
            Priezvisko
            <span class="required">*</span>
        </p>
        <input required class="spacing_form input_form" type="text" name="priezvisko" size="35" placeholder="priezvisko">

        <p class="spacing_form">
            Heslo
            <span class="required">*</span>
        </p>
        <input required class="spacing_form input_form" type="password" name="password" size="35" placeholder="heslo">

        <p class="spacing_form">
            Heslo znova
            <span class="required">*</span>
        </p>
        <input required class="spacing_form input_form" type="password" name="password2" size="35" placeholder="heslo znovu">

        <p class="spacing_form">
            E-mail
            <span class="required">*</span>
        </p>
        <input required class="spacing_form input_form" type="email" name="email" size="35" placeholder="e-mail">

        <p class="spacing_form">
        <button class="spacing_form button_form_submit" type="submit" form="registration" formaction="">Zaregistrovať</button>
        </p>

    </form>

    <form method="POST" class="logreg" id="login" action="">

        <p class="spacing_form">
            E-mail
            <span class="required">*</span>
        </p>
        <input required class="spacing_form input_form" type="email" name="email" size="35" placeholder="e-mail">

        <p class="spacing_form">
            Heslo
            <span class="required">*</span>
        </p>
        <input required class="spacing_form input_form" type="password" name="password" size="35" placeholder="heslo">

        <p class="spacing_form">
            <button class="spacing_form button_form_submit" type="submit" form="login" formaction="">Prihlásiť</button>
        </p>

    </form>

    <p class="spacing"><span class="required">*</span> Povinné pole.</p>

</div>

<script src="js/toggle_log_reg_forms.js"></script>

<?php
    $page->displayBodyEnd();
?>


