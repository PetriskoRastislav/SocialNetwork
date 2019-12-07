<?php
    require('page.php');
    $page = new Page();
    $page->displayHead( "login", array("styles/style_form.css"));
    $page->displayBodyStart("Prihlásenie / Registrácia");
?>

<div class="div_form_logreg" id="div_reg">

    <button onclick="showLogForm()" class="logreg_button logreg_active" id="log_button">Prihlásenie</button>
    <button onclick="showRegForm()" class="logreg_button" id="reg_button">Registrácia</button>

    <form method="POST" class="logreg" id="registration" action="">

        <p class="odsadenie_form">
            Meno
            <span class="required">*</span>
        </p>
        <input required class="odsadenie_form input_form" type="text" name="meno" size="35" placeholder="meno">

        <p class="odsadenie_form">
            Priezvisko
            <span class="required">*</span>
        </p>
        <input required class="odsadenie_form input_form" type="text" name="priezvisko" size="35" placeholder="priezvisko">

        <p class="odsadenie_form">
            Heslo
            <span class="required">*</span>
        </p>
        <input required class="odsadenie_form input_form" type="password" name="password" size="35" placeholder="heslo">

        <p class="odsadenie_form">
            Heslo znova
            <span class="required">*</span>
        </p>
        <input required class="odsadenie_form input_form" type="password" name="password2" size="35" placeholder="heslo znovu">

        <p class="odsadenie_form">
            E-mail
            <span class="required">*</span>
        </p>
        <input required class="odsadenie_form input_form" type="email" name="email" size="35" placeholder="e-mail">

        <p class="odsadenie_form">
        <button class="odsadenie_form button_form_submit" type="submit" form="registration" formaction="">Zaregistrovať</button>
        </p>

    </form>

    <form method="POST" class="logreg" id="login" action="">

        <p class="odsadenie_form">
            E-mail
            <span class="required">*</span>
        </p>
        <input required class="odsadenie_form input_form" type="email" name="email" size="35" placeholder="e-mail">

        <p class="odsadenie_form">
            Heslo
            <span class="required">*</span>
        </p>
        <input required class="odsadenie_form input_form" type="password" name="password" size="35" placeholder="heslo">

        <p class="odsadenie_form">
            <button class="odsadenie_form button_form_submit" type="submit" form="login" formaction="">Prihlásiť</button>
        </p>

    </form>

    <p class="odsadenie"><span class="required">*</span> Povinné pole.</p>

</div>

<script src="js/toggle_log_reg_forms.js"></script>

<?php
    $page->displayBodyEnd();
?>


