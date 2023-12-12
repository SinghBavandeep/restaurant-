<?php
session_start();

include('include/ConnectionBD/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = connect_to_database();

    $userRoles = ['admin', 'employe', 'client'];

    foreach ($userRoles as $role) {
        $query = "SELECT * FROM $role WHERE Email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['Password']) || $password == $row['Password']) {
                $_SESSION['role'] = $role;
                $_SESSION[$role] = $row[$role . 'Id'];
                $_SESSION[$role . '_email'] = $row['Email'];
                header("Location: index.php");
                exit();
            }
        }
    }

    $error_message = "Identifiants incorrects. Veuillez réessayer.";
}

include('include/header/header.php');
?>
