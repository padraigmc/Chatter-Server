<?php

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        require_once('Database.php');

        $username = $_POST["username"];
        $password = $_POST["password"];

        $database = new Database();
        $res = $database->log_in($username, $password);

        echo $res;
    } else {
        print_r($_POST);
        echo "fail";
    }



?>