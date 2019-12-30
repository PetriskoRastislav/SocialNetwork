<?php

require_once('scripts.php');

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];

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

    // Checks if the passwords are same.
    if($password1 != $password2){
        throw new Exception("pswd_same");
    }

    // Checks the password length.
    if(strlen($password1) > 10){
        throw new Exception("pswd_len");
    }

    // Connection to database.
    $db = db_connect();

    // Checks whether user with same email has already been registered.
    $result = $db->query("SELECT * FROM users WHERE email = ' . $email . '");
    if (!$result) {
        throw new Exception("Failed to execute query.");
    }
    if (!$result->num_rows > 0) {
        throw new Exception("User with same email address already registered.");
    }

    unset($result);

    $stmt = $db->prepare("INSERT INTO users (email, firstname, surname, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $email, $name, $surname, $password);
    $stmt->execute();

    if(!$stmt->affected_rows > 0){
        throw new Exception("Failed to register new user.");
    }

    $stmt = $db->query("SELECT id_users FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $id = $stmt->fetch_row();

    $_SESSION['id_user'] = $id;
    header("Location: user.php");
    exit();
}
catch (Exception $ex) {


    exit();
}

?>