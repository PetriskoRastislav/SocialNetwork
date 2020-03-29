<?php

require_once('db_connect.php');

session_start();

try {

// Connection to database.
    $db = db_connect();
    mysqli_set_charset($db, "utf8");

// fetch of user with communication witch logged user

    $query = "
        SELECT DISTINCT id_user, name, surname, last_active
        FROM users
        JOIN messages ON 
        (users.id_user = messages.id_user_sender AND messages.id_user_receiver = ?)
        OR (users.id_user = messages.id_user_receiver AND messages.id_user_sender = ?)";

    $statement = $db->prepare($query);
    $statement->bind_param("ii", $_SESSION['id_user'], $_SESSION['id_user']);
    $statement->execute();
    $statement->bind_result($id_user, $name, $surname, $last_active);

    $output = "";

    while ($statement->fetch()) {

        $time_now = date("Y-m-d H:i:s");

        if ($last_active > $time_now) {
            $status = " <span class='active_mark'></span>";
        } else {
            $status = "";
        }

        $output .= "
        <div class='list_users_item' id_user_to='" . $id_user . "'>
            <span class='user'>" .
            $name . " " . $surname . $status .
            "</span>
        </div>
    ";
    }

    $statement->free_result();

//$output = $_SESSION['id_user'];

    print $output;

}
catch (Exception $ex){
    $ex->getMessage();
    exit();
}

?>