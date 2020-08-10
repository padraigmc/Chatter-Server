<?php

    class Verify {

        public static function verify_register($databaseConnection, $username, $password)
        {
            $success = 1;
    
            if (!self::verify_username_form($username)) {
                $success = 0;
            } 
            
            if (self::username_exists($databaseConnection, $username)) {
                $success = 0;
            }
    
            return $success;
        }



        public static function verify_login($databaseConnection, $username, $password)
        {
            $verifySuccess = 1;
    
            if (!self::verify_username_form($username)) {
                $verifySuccess = 0;
            }

            if (!self::username_exists($databaseConnection, $username)) {
                $verifySuccess = 0;
            }

            if (!self::verify_password_hash($databaseConnection, $username, $password)) {
                $verifySuccess = 0;
            }

            return $verifySuccess;
        }

        private static function verify_username_form($username) {
            if (preg_match("/^[a-zA-Z0-9_\-]{4,30}$/", $username)) {
                return 1;
            } else {
                return 0;
            }
        }

        private static function username_exists($databaseConnection, $username) 
        {
            $sql = "SELECT `username` FROM `User` WHERE `username` = ?;";
            $usernameExists = 0;

            if ($stmt = $databaseConnection->prepare($sql)) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) { 
                    $usernameExists = 1; 
                } else { 
                    $usernameExists = 0;
                }
            }

            return $usernameExists;
        }
    
        private static function verify_password_hash($databaseConnection, $username, $password) {
            $password_hash = self::get_password_hash($databaseConnection, $username);
    
            if ($password_hash != null && password_verify($password, $password_hash)) {
                return 1;
            } else {
                return 0;
            }
        }
    
        private static function get_password_hash($databaseConnection, $username) 
        {
            $hash = null;
            $sql = "SELECT `password` FROM `User` 
                    WHERE `username` = ?;";

            if ($stmt = $databaseConnection->prepare($sql)) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->bind_result($hash);
                $stmt->fetch();
            }
            return $hash;
        }
    }

?>