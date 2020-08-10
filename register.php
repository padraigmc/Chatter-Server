<?php

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        require_once('Database.php');

        $username = $_POST["username"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $database = new Database();
        $res = $database->insert_new_user($username, $password);

        echo $res;
    } else {
        print_r($_POST);
        echo "fail";
    }

    

?>