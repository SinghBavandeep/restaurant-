<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('include/ConnectionBD/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order'])) {
    if (!isset($_SESSION['role'])) {
        echo "Error: User role is not set!";
        exit;
    }

    $role = $_SESSION['role'];
    $userId = null;
    $userEmail = null;
    $currentDate = date("Y-m-d");

    if (isset($_SESSION[$role])) {
        $userId = $_SESSION[$role];
    }

    if (isset($_SESSION[$role . '_email'])) {
        $userEmail = $_SESSION[$role . '_email'];
    }

    $conn = connect_to_database();

    $insertCommandeQuery = "";

    switch ($role) {
        case 'admin':
            $insertCommandeQuery = "INSERT INTO commande (userEmail, dateCommande) VALUES (?, ?)";
            break;

        case 'client':
            $insertCommandeQuery = "INSERT INTO commande (userEmail, dateCommande) VALUES (?, ?)";
            break;

        case 'employe':
            $insertCommandeQuery = "INSERT INTO commande (userEmail, dateCommande) VALUES (?, ?)";
            break;

        default:
            echo "Error: Unknown user role!";
            exit;
    }

    $stmt = $conn->prepare($insertCommandeQuery);
    $stmt->bind_param("ss", $userEmail, $currentDate);

    if ($stmt->execute()) {
        // Order successfully added, now clear the cart and redirect
        unset($_SESSION['cart']);  // Assuming 'cart' is the session variable storing the cart data

        // Redirect to index.php
        header("Location: index.php");
        exit();
    } else {
        echo "Error adding the order: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
