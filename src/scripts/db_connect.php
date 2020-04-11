<?php

/* Connects to database */
function db_connect() {
    $result = new mysqli("localhost", 'WebUser', 'SN13wEb19-20', 'SocialNetwork');
    if (!$result) {
        throw new Exception('Failed to connect to database.');
    } else {
        return $result;
    }
}

?>
