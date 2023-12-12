<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function connect_to_database() {
    $servername = "localhost";
    $username = "root";
    $password = "BA52si6401";
    $dbname = "mydb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
