<?php
    require('page.php');
    $page = new Page();
    $page->displayHead( "login", array("styles/reset.css", "styles/style.css", "styles/style_form.css"));
?>
<body>
    <?php
    $page->displayTitle("Prihlásenie / Registrácia");
    ?>

    <div class="div_form_logreg" id="div_reg">

        <h2>Registrácia</h2>

        <form method="POST" class="logreg" id="reg" action="">

            <p class="odsadenie_form">
                Meno
                <span class="povinne">*</span>
            </p>
            <input required class="odsadenie_form input_form" type="text" name="meno" size="35" placeholder="meno">

            <p class="odsadenie_form">
                Priezvisko
                <span class="povinne">*</span>
            </p>
            <input required class="odsadenie_form input_form" type="text" name="priezvisko" size="35" placeholder="priezvisko">

            <p class="odsadenie_form">
                Heslo
                <span class="povinne">*</span>
            </p>
            <input required class="odsadenie_form input_form" type="password" name="password" size="35" placeholder="heslo">

            <p class="odsadenie_form">
                Heslo znova
                <span class="povinne">*</span>
            </p>
            <input required class="odsadenie_form input_form" type="password" name="password2" size="35" placeholder="heslo znovu">

            <p class="odsadenie_form">
                E-mail
                <span class="povinne">*</span>
            </p>
            <input required class="odsadenie_form input_form" type="email" name="email" size="35" placeholder="e-mail">

            <p class="odsadenie_form">
                <button class="odsadenie_form button_form_submit" type="submit" form="pridat_ludia" formaction="php_script/pridat_ludia.php">Pridať</button>
            </p>

        </form>

        <p class="odsadenie"><span class="povinne">*</span>Povinné pole.</p>

    </div>

    <div class="div_form_logreg" id="div_log">

        <h2>Prihlásenie</h2>

        <form method="POST" class="logreg" id="log" action="">

            <p class="odsadenie_form">
                E-mail
                <span class="povinne">*</span>
            </p>
            <input required class="odsadenie_form input_form" type="email" name="email" size="35" placeholder="e-mail">

            <p class="odsadenie_form">
                Heslo
                <span class="povinne">*</span>
            </p>
            <input required class="odsadenie_form input_form" type="password" name="password" size="35" placeholder="heslo">

            <p class="odsadenie_form">
                <button class="odsadenie_form button_form_submit" type="submit" form="pridat_ludia" formaction="php_script/pridat_ludia.php">Pridať</button>
            </p>

        </form>

        <p class="odsadenie"><span class="povinne">*</span>Povinné pole.</p>

    </div>

    <?php

    ?>
</body>
</html>


