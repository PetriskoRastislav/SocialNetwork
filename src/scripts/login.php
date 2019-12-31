<?php

require_once('scripts.php');

$email = $_POST['email'];
$password = $_POST['password'];

session_start();

try {

    // Checks if all form line has been filled.
    if(!filled_out($_POST)){
        throw new Exception("form");
    }

    // Checks if email has a proper format.
    if(!valid_email($email)){
        throw new Exception("email");
    }

    $db = db_connect();
    mysqli_set_charset($db,"utf8");

    $stmt = $db->prepare("SELECT id_users FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $id2 = intval($stmt->fetch());

    $stmt->close();

    $stmt = $db->prepare("SELECT id_users FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $id = intval($stmt->fetch());

    $stmt->close();

    $db->close();

    if (!is_int($id)){
        throw new Exception("Login failed.");
    }

    if (!$id > 0 && $id2 > 0){
        throw new Exception("Wrong password");
    }

    if (!$id > 0){
        throw new Exception("Wrong email.");
    }

    // Storing id in SESSION variable
    $_SESSION['id_user'] = $id;

    // Redirecting user to his profile page
    header("Location: ../user.php");
    exit();

}
catch (Exception $ex) {


    echo $ex->getMessage();

    exit();
}


?>
