<?php

require_once('scripts_min.php');
session_start();

try {

    /* Checks if all form line has been filled. */
    if (!filled_out($_POST)) {
        die ("reg|0|Some of inputs are missing.");
    }


    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_again = $_POST['password_confirm'];


    /* checks length of name */
    if (!string_isn_t_longer($name, 40)) {
        die ("reg|0|Name is longer than it's allowed. Max allowed length is 40 characters.");
    }


    /* checks length of surname */
    if (!string_isn_t_longer($surname, 40)) {
        die ("reg|0|Surname is longer than it's allowed. Max allowed length is 40 characters.");
    }


    /* Checks if email has a proper format. */
    if (!valid_email($email)) {
        die ("reg|0|Email has invalid format.");
    }


    /* checks length of email */
    if (!string_isn_t_longer($email, 100)) {
        die ("reg|0|Email is longer than it's allowed. Max allowed length is 100 characters.");
    }


    /* Checks if the passwords are same. */
    if ($password != $password_again) {
        die ("reg|0|Confirming password doesn't match Password.");
    }


    /* checks if password contain required characters */
    if (!valid_password($password)) {
        die ("reg|0|Password has invalid format.");
    }


    /* Checks the password length. */
    if (!string_has_length($password, 10)) {
        die ("reg|0|Password doesn't meet minimum length. Minimal length is 10 characters.");
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
        die ("reg|0|User with same email address has already registered.");
    }


    $statement->free_result();


    /* Registration of new user */

    $password_hash = password_hash($password, PASSWORD_ARGON2ID);
    $time_now = date("Y-m-d H:i:s");

    $query =
        "INSERT INTO users (email, name, surname, password, registered, last_active)
        VALUES (?, ?, ?, ?, ?, ?)";
    $statement = $db->prepare($query);
    $statement->bind_param("ssssss", $email, $name, $surname, $password_hash, $time_now, $time_now);
    $statement->execute();

    if(!$statement->affected_rows > 0){
        die ("reg|0|Failed to register new user.");
    }


    /* Fetching id of a newly registered user */
    $query =
        "SELECT id_user, color_mode
        FROM users
        WHERE email = ?";
    $statement = $db->prepare($query);
    $statement->bind_param("s",$email);
    $statement->execute();
    $statement->bind_result($id, $color_mode);
    $statement->fetch();

    $statement->free_result();
    $statement->close();
    $db->close();

    /* Storing id in SESSION variable */
    $_SESSION['id_user'] = $id;
    $_SESSION['name'] = $name;
    $_SESSION['surname'] = $surname;
    $_SESSION['color_mode'] = $color_mode;

    /* Redirecting user to his profile page */
    print $_SESSION['id_user'];
    exit();

}
catch (Exception $ex) {
    echo $ex->getMessage();

    exit();
}

?>
