<?php
    const DBNAME = "computer_inventory";
    const DBHOST = "localhost";
    const DBUSER = "computer_inventory_manager";
    const DBPASS = "b(79yKo8Ei";

    /**
     * Connect to the database.
     */
    function connectDB() {
        $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
?>
