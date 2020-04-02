<?php

require_once('db_connect.php');

session_start();

try {

    /* Connection to database */
    $db = db_connect();
    mysqli_set_charset($db, "utf8");

    /* will update time of last activity of logged user */

    $time_now = date("Y-m-d H:i:s");

    $query = "
        UPDATE users
        SET last_active = ?
        WHERE id_user = ?";
    $statement = $db->prepare($query);
    $statement->bind_param("si", $time_now, $_SESSION['id_user']);
    $statement->execute();

}
catch (Exception $ex){
    $ex->getMessage();
}



?>