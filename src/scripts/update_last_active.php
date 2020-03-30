<?php

require_once('db_connect.php');

session_start();

try {

    // Connection to database.
    $db = db_connect();
    mysqli_set_charset($db, "utf8");

    // will update time of last activity of logged user

    $query = "
        UPDATE users
        SET last_active = now()
        WHERE id_user = ?";
    $statement = $db->prepare($query);
    $statement->bind_param("i", $_SESSION['id_user']);
    $statement->execute();

}
catch (Exception $ex){
    $ex->getMessage();
}



?>