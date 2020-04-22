<?php

/* fetches and process users' avatars */

$query =
    "SELECT id_user, profile_picture
            FROM users
            WHERE (id_user = ? OR id_user = ?)";
$statement = $db->prepare($query);
$statement->bind_param("ii", $id_user_to, $_SESSION['id_user']);
$statement->execute();
$statement->bind_result($id_user, $profile_picture);

$profile_pic_me = "";
$profile_pic_theirs = "";

while ($statement->fetch()){
    if($id_user == $_SESSION['id_user']){

        if ($profile_picture != null) {
            $img = "user_pictures/" . $profile_picture;
        }
        else {
            $img = "src_pictures/blank-profile-picture-png-8.png";
        }

        $img = "background-image: url('" . $img . "');";
        $profile_pic_me .= '<div class="avatar" style="' . $img . '"></div>';
    }
    else {
        if ($profile_picture != null) {
            $img = "user_pictures/" . $profile_picture;
        }
        else {
            $img = "src_pictures/blank-profile-picture-png-8.png";
        }

        $img = "background-image: url('" . $img . "');";
        $profile_pic_theirs .= '<div class="avatar" style="' . $img . '"></div>';
    }
}
$statement->free_result();
$statement->close();