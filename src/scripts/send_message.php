<?php

require_once('db_connect.php');

session_start();

try {

    /* Connection to database. */
    $db = db_connect();
    mysqli_set_charset($db, "utf8");

    /* will insert message into a database and refresh chat */

    $id_user_to = $_POST['id_user_to'];
    $message = $_POST['message'];

    $query = "
        INSERT INTO messages (id_user_sender, id_user_receiver, message, time, status)
        VALUES (?, ?, ?, now(), 'unseen')";
    $statement = $db->prepare($query);
    $statement->bind_param("iis", $_SESSION['id_user'], $id_user_to, $message);
    $statement->execute();

    
}
catch(Exception $ex){
    $ex->getMessage();
}

?>

