<?php

/* pripojenie skriptov */

require_once('scripts/scripts.php');

/* spustenie relácie, (sprístupnenie relačných premenných naprieč sktiptami) */

session_start();

/* overenie či je užívateľ prihlásený, ak nie tak ho presmeruje na login/registration stránku */

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

/* vytvorí inštanciu triedy page.php */

$page = new Page();

/* vypíše html hlavičku */
/* napr. $page->display_header( "messages", array("styles/messages")); */
/* napr. $page->display_header( "", array()); */

$page->display_header( /* titul stránky, (to čo je napísane hore na lište okna/stránky) */"", array(/* tu sa vymenujú dodatočné súbory css, ktoré potrebuješ na konkrétnu stránku */));

/* vypíše hlavičku stránky, menu */

$page->display_body_start();

?>


<!--

tu
ide
telo
stránky,
bez
hlavičky html,
bez
hlavičky stránky,
bez
menu,
bez
štýlov,
bez
javascriptu,
čisté
telo
stránky

-->


<?php

/* vypíše koniec dokumentu (uzatvaracie tagy), pripojí javascript súbory */
/* napr. $page->display_body_end(array("js/messages.js")); */
/* napr. $page->display_body_end(array()); */

$page->display_body_end(array(/* tu sa vymenujú dodatočné súbory js, ktoré potrebuješ na konkrétnu stránku */));

?>
