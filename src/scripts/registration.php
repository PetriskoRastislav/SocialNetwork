<?php

require_once('scripts.php');

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];

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

    /* Checks if the passwords are same. */
    if($password1 != $password2){
        throw new Exception("pswd_same");
    }

    /* Checks the password length. */
    if(strlen($password1) < 10){
        throw new Exception("pswd_len");
    }

    /* Connection to database. */
    $db = db_connect();
    mysqli_set_charset($db,"utf8");


    /* Checks whether user with same email has already been registered. */
    $query =
        "SELECT id_user
        FROM users
        WHERE email = ?";
    $statement = $db->prepare($query);
    $statement->bind_param("s", $email);
    $statement->execute();
    $statement->bind_result($id_user);
    $statement->fetch();


    if ($id_user > 0) {
        throw new Exception("User with same email address already registered.");
    }

    unset($result);


    /* Registration of new user */
    $query =
        "INSERT INTO users (email, name, surname, password, registered, last_active)
        VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $password_hash = password_hash($password1, PASSWORD_ARGON2ID);
    $time_now = date("Y-m-d H:i:s");
    $stmt->bind_param("ssssss", $email, $name, $surname, $password_hash, $time_now, $time_now);
    $stmt->execute();

    if(!$stmt->affected_rows > 0){
        throw new Exception("Failed to register new user.");
    }

    /* Fetching id of a newly registered user */
    $query =
        "SELECT id_user, color_mode
        FROM users
        WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->bind_result($id, $color_mode);
    $stmt->fetch();

    $stmt->free_result();
    $stmt->close();
    $db->close();

    /* Storing id in SESSION variable */
    $_SESSION['id_user'] = $id;
    $_SESSION['name'] = $name;
    $_SESSION['surname'] = $surname;
    $_SESSION['color_mode'] = $color_mode;

    /* Redirecting user to his profile page */
    header("Location: ../profile.php?user=me");

    exit();
}
catch (Exception $ex) {
    echo $ex->getMessage();

    exit();
}

?>