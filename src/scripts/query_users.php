<?php

require_once('db_connect.php');
require_once('data_valid.php');

session_start();

try {

    /* Connection to database. */
    $db = db_connect();
    mysqli_set_charset($db, "utf8");


    /* will determine the mode in which will proceed script */
    $mode = $_POST["mode"];


    /* fetch all users with whom had logged user communication with all data */
    if ($mode == "all") {

        $query =
            "SELECT DISTINCT id_user, name, surname, profile_picture, last_active
            FROM users
            JOIN messages ON 
            (users.id_user = messages.id_user_sender AND messages.id_user_receiver = ?)
            OR (users.id_user = messages.id_user_receiver AND messages.id_user_sender = ?)";

        $statement = $db->prepare($query);
        $statement->bind_param("ii", $_SESSION['id_user'], $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($id_user, $name, $surname, $profile_picture, $last_active);

        $output = "";

        while ($statement->fetch()) {

            /* will determine whether particular user is still active or not */
            $time_now = strtotime(date('Y-m-d H:i:s') . '-6 seconds');
            $time_now = date('Y-m-d H:i:s', $time_now);

            /* profile picture */
            if ($profile_picture != null) {
                $img = "user_pictures/" . $profile_picture;
            }
            else {
                $img = "src_pictures/blank-profile-picture-png-8.png";
            }

            $profile_pic = "background-image: url('" . $img . "');";
            $profile_pic = '<div class="avatar avatar-list" style="' . $profile_pic . '"></div>';

            /* last active */
            if ($last_active > $time_now) {
                $status = " <span class='active_mark' id='active_mark_" . $id_user . "'></span>";
            } else {
                $status = " <span class='' id='active_mark_" . $id_user . "'></span>";
            }

            /* count of unseen messages */
            $mes_count = get_unseen_messages_notification($id_user, $_SESSION['id_user']);
            if ($mes_count > 0 ) {
                $mes_notification = " <span class='mes_not_chat' id='mes_not_" . $id_user . "' ></span>";
            }
            else {
                $mes_notification = " <span class='' id='mes_not_" . $id_user . "' ></span>";
            }

            /* will create list item of the list of users */
            $output .=
                "<div class='list_users_item' id_user_to='" . $id_user . "'>" .
                    $profile_pic .
                    "<span class='user'>" .
                        $name . " " . $surname . $status . $mes_notification .
                    "</span>
                </div>
            ";
        }

        $statement->free_result();
        $statement->close();
        $db->close();

        print $output;

        exit();

    }


    /* will fetch only a list of conversations and will pass them to js script, which will refresh list */
    else if ($mode == "refresh_list") {


        $query =
            "SELECT DISTINCT id_user, name, surname, last_active, profile_picture
            FROM users
            JOIN messages ON 
            (users.id_user = messages.id_user_sender AND messages.id_user_receiver = ?)
            OR (users.id_user = messages.id_user_receiver AND messages.id_user_sender = ?)";

        $statement = $db->prepare($query);
        $statement->bind_param("ii", $_SESSION['id_user'], $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($id_user, $name, $surname, $last_active, $profile_picture);

        $output = "";

        while ($statement->fetch()) {

            $output .= $id_user . "|";

            /* profile picture */
            if ($profile_picture != null) {
                $img = "user_pictures/" . $profile_picture;
            }
            else {
                $img = "src_pictures/blank-profile-picture-png-8.png";
            }

            $profile_pic = "background-image: url('" . $img . "');";
            $profile_pic = '<div class="avatar avatar-list" style="' . $profile_pic . '"></div>';

            $status = " <span class='' id='active_mark_" . $id_user . "'></span>";
            $mes_notification = " <span class='' id='mes_not_" . $id_user . "' ></span>";

            $output .= "
                <div class='list_users_item' id_user_to='" . $id_user . "'>".
                    $profile_pic .
                    "<span class='user'>" .
                        $name . " " . $surname . $status . $mes_notification .
                    "</span>
                </div>
            ";

            $output .= "|";
        }

        $statement->free_result();
        $statement->close();
        $db->close();

        print $output;

        exit();

    }


    /* will only fetch last_active data, will create marker of active user and notification when user has new message */
    else if ($mode == "refresh_marks") {

        $query =
            "SELECT DISTINCT users.id_user, users.last_active
            FROM users
            JOIN messages ON
            (users.id_user = messages.id_user_sender AND messages.id_user_receiver = ?)
            OR (users.id_user = messages.id_user_receiver AND messages.id_user_sender = ?)";
        $statement = $db->prepare($query);
        $statement->bind_param("ii", $_SESSION['id_user'], $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($id_user, $last_active);

        $output = "";

        while ($statement->fetch()){

            $time_now = strtotime(date('Y-m-d H:i:s') . '-6 seconds');
            $time_now = date('Y-m-d H:i:s', $time_now);

            if ($last_active > $time_now) {
                $status = "online";
            } else {
                $status = "offline";
            }

            $mes_count = get_unseen_messages_notification($id_user, $_SESSION['id_user']);

            $output .= $id_user . "|" . $status . "|" . process_last_active($last_active) . "|" . $mes_count . "|";
        }

        $statement->free_result();
        $statement->close();
        $db->close();

        print $output;

        exit();

    }


    /* will update time of last activity of logged user */
    else if ($mode == "update_active") {

        $time_now = date("Y-m-d H:i:s");

        $query =
            "UPDATE users
            SET last_active = ?
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("si", $time_now, $_SESSION['id_user']);
        $statement->execute();

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will return id, username, and last_active of a user with given id */
    else if ($mode == "get_username") {

        $id = $_POST['id_user'];
        if ($id == "me") $id = $_SESSION['id_user'];

        $query =
            "SELECT id_user, name, surname, last_active, profile_picture
            FROM users
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->bind_result($id_user, $name, $surname, $last_active, $profile_picture);
        $statement->fetch();

        $result = $id_user . "|" . $name . " " . $surname . "|" . process_last_active($last_active) . "|" . $profile_picture;

        print $result;

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will return result of searching for a user */
    else if ($mode == "find_user") {

        $value = $_POST['value'];

        $query =
            "SELECT id_user, email, name, surname, profile_picture, last_active
            FROM users
            WHERE name LIKE ? 
            OR surname LIKE ?";
        $statement = $db->prepare($query);
        $val = "%" . $value . "%";
        $statement->bind_param("ss", $val, $val);
        $statement->execute();
        $statement->bind_result($id, $email, $name, $surname, $profile_picture, $last_active);

        $output = "";

        while ($statement->fetch()){

            if ($profile_picture != null) {
                $img = "user_pictures/" . $profile_picture;
            }
            else {
                $img = "src_pictures/blank-profile-picture-png-8.png";
            }

            $profile_pic = "background-image: url('" . $img . "');";
            $profile_pic = '<div class="avatar avatar-list" style="' . $profile_pic . '"></div>';

            $output .= "
                <div id='search_result_" . $id . "' class='search_result_item'>".
                    $profile_pic .
                    "<p>" . $name . " " . $surname . "</p>
                </div>";
        }

        print $output;

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will return data to fill some of user's settings */
    else if ($mode == "settings_fill") {

        $query =
            "SELECT name, surname, email, profile_picture, location, gender, day_of_birth, month_of_birth, year_of_birth, color_mode, bio
            FROM users
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($name,$surname, $email, $profile_picture, $location, $gender,
            $day_of_birth, $month_of_birth, $year_of_birth, $color_mode, $bio);
        $statement->fetch();

        $output =
            "input[name='name']|value|" . $name .
            "|input[name='surname']|value|" . $surname .
            "|input[name='email']|value|" . $email .
            "|select[name='gender']|value|" . $gender;

        if ($profile_picture != null) $output .= "|#preview img|src|user_pictures/" . $profile_picture;
        if ($location != null) $output .= "|input[name='location']|value|" . $location;
        if ($gender != null) $output .= "|select[name='gender'] option[value='" . $gender . "']|selected|";
        if ($day_of_birth != null) $output .= "|select[name='day_of_birth'] option[value='" . $day_of_birth . "']|selected|";
        if ($month_of_birth != null) $output .= "|select[name='month_of_birth'] option[value='" . $month_of_birth . "']|selected|";
        if ($year_of_birth != null) $output .= "|input[name='year_of_birth']|value|" . $year_of_birth;
        if ($color_mode == "dark") $output .= "|input[name='change_theme']|checked|true";
        if ($bio != null) $output .= "|textarea[name='biography']||" . $bio;

        print $output;

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will change password of user */
    else if ($mode == "change_password") {

        $password_old = $_POST['password_old'];
        $password_new = $_POST['password_new'];
        $password_new_again = $_POST['password_new_again'];


        /* Checks if the passwords are same. */
        if ($password_new != $password_new_again) {
            die ("pass|0|Confirming password doesn't match Password.");
        }


        /* checks if password contain required characters */
        if (!valid_password($password_new)) {
            die ("pass|0|Password has invalid format.");
        }


        /* Checks the password length. */
        if (!string_has_length($password_new, 10)) {
            die ("pass|0|Password doesn't meet minimum length. Minimal length is 10 characters.");
        }

        $query =
            "SELECT password
            FROM users
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($password);
        $statement->fetch();

        if ( !(password_verify($password_old, $password)) ){
            die ("pass|0|Old password is wrong.");
        }

        $statement->free_result();

        $password_new_hash = password_hash($password_new, PASSWORD_ARGON2ID);

        $query =
            "UPDATE users
            SET password = ?
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("si", $password_new_hash, $_SESSION['id_user']);
        $result = $statement->execute();

        if (!$result) die ("pass|0|Something went wrong.");

        print "pass|1";

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will change name of user */
    else if ($mode == "change_name") {

        $name = $_POST['name'];
        $surname = $_POST['surname'];


        /* checks length of name */
        if (!string_isn_t_longer($name, 40)) {
            die ("name|0|Name is longer than it's allowed. Max allowed length is 40 characters.");
        }


        /* checks length of surname */
        if (!string_isn_t_longer($surname, 40)) {
            die ("name|0|Surname is longer than it's allowed. Max allowed length is 40 characters.");
        }

        $query =
            "UPDATE users
            SET name = ?, surname = ?
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("ssi", $name, $surname, $_SESSION['id_user']);
        $result = $statement->execute();

        if (!$result) die ("name|0|Something went wrong.");

        print "name|1";

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will change email of user */
    else if ($mode == "change_email") {

        $email = $_POST['email'];

        /* Checks if email has a proper format. */
        if (!valid_email($email)) {
            die ("mail|0|Email has invalid format.");
        }


        /* checks length of email */
        if (!string_isn_t_longer($email, 100)) {
            die ("mail|0|Email is longer than it's allowed. Max allowed length is 100 characters.");
        }


        $query =
            "UPDATE users
            SET email = ?
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("si", $email, $_SESSION['id_user']);
        $result = $statement->execute();

        if (!$result) die ("mail|0|Something went wrong.");

        print "mail|1";

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will change other information about user */
    else if ($mode == "change_profile_det") {

        $location = $_POST['location'];
        $gender = $_POST['gender'];
        $day_of_birth = $_POST['day_of_birth'];
        $month_of_birth = $_POST['month_of_birth'];
        $year_of_birth = $_POST['year_of_birth'];


        /* checks length of location */
        if (!string_isn_t_longer($location, 100)) {
            die ("info|0|Location is longer than it's allowed. Max allowed length is 100 characters.");
        }


        /* checks value of gender */
        if (!($gender == "male" || $gender == "female" || $gender == "other")){
            die ("info|0|Gender has forbidden value. Allowed values are male, female, and other.");
        }


        /* checks value of: day of birth */
        if ($day_of_birth != "--") {
            $day = intval($day_of_birth, 10);
            if(!($day >= 1 && $day <= 31)) {
               die ("info|0|Day of birth is in forbidden range.");
            }
        }
        else {
            $day_of_birth = null;
        }


        /* checks value of: month of birth */
        if ($month_of_birth != "--") {
            $month = intval($month_of_birth, 10);
            if(!($month >= 1 && $month <= 12)) if(!($day >= 1 && $day <= 31)) {
                die ("info|0|Month of birth is in forbidden range.");
            }
        }
        else {
            $month_of_birth = null;
        }


        /* checks value: of day of birth */
        if ($year_of_birth != null || $year_of_birth != ""){
            $year = intval($year_of_birth, 10);
            if(!($year >= 1900 && $year <= intval(date("Y"), 10))){
                die ("info|0|Year of birth is in forbidden range.");
            }
        }
        else {
            $year_of_birth = null;
        }


        $query =
            "UPDATE users
            SET location = ?, gender = ?, day_of_birth = ?, month_of_birth = ?, year_of_birth = ?
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("sssssi", $location, $gender, $day_of_birth, $month_of_birth, $year_of_birth, $_SESSION['id_user']);
        $result = $statement->execute();

        if (!$result) die ("info|0|Something went wrong.");

        print "info|1";

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will change user's theme */
    else if ($mode == "change_theme") {

        $theme = $_POST['theme'];


        /* checks value of theme */
        if (!($theme == "dark" || $theme == "light")){
            die ("theme|0|Theme has forbidden value. Allowed values are dark and light.");
        }


        $query =
            "UPDATE users
            SET color_mode = ?
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("si", $theme, $_SESSION['id_user']);
        $result = $statement->execute();

        if (!$result) die ("theme|0|Something went wrong.");

        print "theme|1";

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will change biography of user */
    else if ($mode == "change_bio") {

        $bio = $_POST['bio'];

        $query =
            "UPDATE users
            SET bio = ?
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("si", $bio, $_SESSION['id_user']);
        $result = $statement->execute();

        if (!$result) die ("bio|0|Something went wrong.");

        print "bio|1";

        $statement->free_result();
        $statement->close();
        $db->close();

        exit();

    }


    /* will update theme in $_SESSION */
    else if ($mode == "update_session") {

        $query =
            "SELECT color_mode, name, surname
            FROM users
            WHERE id_user = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $_SESSION['id_user']);
        $statement->execute();
        $statement->bind_result($color_mode, $name, $surname);
        $statement->fetch();

        $_SESSION['color_mode'] = $color_mode;
        $_SESSION['name'] = $name;
        $_SESSION['surname'] = $surname;

        $stmt->free_result();
        $stmt->close();
        $db->close();

        exit();

    }


    /* will write friendship request into a database */
    else if ($mode == "request_friendship") {

        $id_user_to = $_SESSION['id_user_to'];
        $time_now = date("Y-m-d H:i:s");



    }


}
catch (Exception $ex){
    $ex->getMessage();
    exit();
}

?>