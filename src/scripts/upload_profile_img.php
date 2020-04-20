<?php

/* will change profile picture of user */

require_once('db_connect.php');
session_start();

try {

    /* Connection to database. */
    $db = db_connect();
    mysqli_set_charset($db, "utf8");


    /* checks if file was uploaded without error */
    if ($_FILES['profile_pic']['error'] > 0) die ("0|Error occurred while uploading.");

    /* check if a file is a image */
    $valid_extensions = array("jpeg", "jpg", "png", "gif", "bmp");
    $ext = "." . strtolower(explode(".", $_FILES['profile_pic']['name'])[1]);


    if (in_array($ext, $valid_extensions)) die ("0|Forbidden file type. Only allowed .jpeg, .jpg, .png, .gif, .bmp");


    /* renames file to secure that there won't be two files with same name */
    $name = $_FILES['profile_pic']['name'];
    $name = hash("md5", $name);
    $name = $name . $ext;


    $uploaded_file = "C:/xampp/htdocs/SocialNetwork/src/user_pictures/" . $name;


    /* tries to move file to a permanent directory */
    if (is_uploaded_file($_FILES['profile_pic']['tmp_name'])) {

        if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploaded_file)) {
            die ("0|Failed to save file on server.");
        }
    } else {
        die ("0|File wasn't uploaded via POST.");
    }


    /* saves file name to a database */
    $query =
        "UPDATE users
        SET profile_picture = ?
        WHERE id_user = ?";
    $statement = $db->prepare($query);
    $statement->bind_param("si", $name, $_SESSION['id_user']);
    $result = $statement->execute();

    $stmt->free_result();
    $stmt->close();
    $db->close();

    if (!$result) die ("0|Something went wrong.");

    exit ("user_pictures/" . $name);

}
catch (Exception $ex) {
    $ex->getMessage();
}


?>