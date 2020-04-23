<?php

require_once('scripts_min.php');

$email = $_POST['email'];
$password = $_POST['password'];

session_start();

try {

    /* Checks if all form line has been filled. */
    if(!filled_out($_POST)){
        die ("log|0|Some of inputs are missing.");
    }

    /* Checks if email has a proper format. */
    if(!valid_email($email)){
        die ("log|0|Email has invalid format.");
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
        die ("log|0|Incorrect password.");
    }
    else {
        die ("log|0|Unknown email.");
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
    print $_SESSION['id_user'];
    exit ();

}
catch (Exception $ex) {
    print $ex->getMessage();
    exit ();
}

?>
