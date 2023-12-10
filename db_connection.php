<?php
function connect_to_database() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $conn = new mysqli("localhost:3306", "root", "BA52si6401", "mydb");

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    return $conn;
}


?>
