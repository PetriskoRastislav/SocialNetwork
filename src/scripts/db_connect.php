<?php

// Connects to database
function db_connect() {
    $result = new mysqli('localhost', 'WebUser', 'SN13wEb19-20', 'SocialNetwork');
    if (!$result) {
        throw new Exception('Nepodařilo se připojit k databázi.');
    } else {
        return $result;
    }
}

?>
