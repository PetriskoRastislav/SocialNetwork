<?php

require_once('scripts.php');

$email = $_POST['email'];
$password = $_POST['password'];

session_start();

try {

    /* Checks if all form line has been filled. */
    if(!filled_out($_POST)){
        throw new Exception("form");
    }

    /* Checks if email has a proper format. */
    if(!valid_email($email)){
        throw new Exception("email");
    }

    $db = db_connect();
    mysqli_set_charset($db,"utf8");


    /* Will verify user's credentials  */

    $query =
        "SELECT id_user, password
        FROM users
        WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $pass_hash);
    $stmt->fetch();


    if(password_verify($password, $pass_hash)) {
        /* Storing id in SESSION variable */
        $_SESSION['id_user'] = $id;
    }
    else if($id > 0) {
        throw new Exception("Wrong password");
    }
    else {
        throw new Exception("Unknown email.");
    }


    $stmt->free_result();


    /* Fetch id of a logged user */
    $query =
        "SELECT name, surname, color_mode 
        FROM users 
        WHERE id_user = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($firstname, $surname, $color_mode);
    $stmt->fetch();

    $_SESSION['name'] = $firstname;
    $_SESSION['surname'] = $surname;
    $_SESSION['color_mode'] = $color_mode;

    $stmt->free_result();
    $stmt->close();
    $db->close();

    /* Redirecting user to his profile page */
    header("Location: ../profile.php?user=me");
    exit();

}
catch (Exception $ex) {

    echo $ex->getMessage();

    exit();
}


?>
