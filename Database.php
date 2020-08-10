<?php
require_once("Verify.php");

    class Database {
        public $database_connection = NULL;

        public function __construct()
        {
            $this->database_connection = $this->connect();
        }


        public function connect() 
        {
            // set db connection variables
            $dbServerName = "127.0.0.1";
            $dbUsername = "root";
            $dbPassword = "";
            $dbName = "chatter"; 

            // Create connection
            $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

            // Check connection
            if ($conn->connect_error) {
                return 0;
            } else {
                return $conn;
            }
        }

        public function insert_new_user($username, $password) 
        {
            $verified = Verify::verify_register($this->database_connection, $username, $password);

            $sql = "INSERT INTO `User` (`username`, `password`) VALUES (?, ?);";
            
            if ($verified && $stmt = $this->database_connection->prepare($sql)) {
                $stmt->bind_param("ss", $username, $password);
                $stmt->execute();

                if ($stmt->affected_rows == 1) {
                    $success = 1;
                } else {
                    $success = 0;
                }

                $stmt->close();
            } else {
                $success = 0;
            }
            return $success;
        }

        public function log_in($username, $password) {
            return Verify::verify_login($this->database_connection, $username, $password);
        }


    }

?>