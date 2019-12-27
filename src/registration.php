<?php

if((empty($_POST['name']) && empty($_POST['surname']) && empty($_POST['email']) &&
    empty($_POST['email']) && empty($_POST['password']) && empty($_POST['password_again'])) ||
    !($_POST['password'] == $_POST['password_again']))
        header('Location: logreg.php');



@$db = new mysqli('localhost', 'WebUser', 'SN13wEb19-20', 'SocialNetwork');

password_hash()



?>