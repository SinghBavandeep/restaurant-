<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('include/ConnectionBD/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order'])) {
    // Assuming you have user information in the session, replace this with your actual session data
    $userEmail = $_SESSION['role'];
    $currentDate = date("Y-m-d");

    $conn = connect_to_database();

    // Initialize variables
    $userId = null;
    $role = $_SESSION['role'];

    // Set userId based on the role
    switch ($role) {
        case 'admin':
            $userId = isset($_SESSION['admin']) ? $_SESSION['admin'] : null;
            $query = "INSERT INTO commande (adminId, userEmail, dateCommande) VALUES (?, ?, ?)";
            break;

        case 'client':
            $userId = isset($_SESSION['IdClient']) ? $_SESSION['IdClient'] : null;
            $query = "INSERT INTO commande (clientId, userEmail, dateCommande) VALUES (?, ?, ?)";
            break;

        case 'employe':
            $userId = isset($_SESSION['Idemploye']) ? $_SESSION['Idemploye'] : null;
            $query = "INSERT INTO commande (employeId, userEmail, dateCommande) VALUES (?, ?, ?)";
            break;
    }

    if ($userId !== null) {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $userId, $userEmail, $currentDate);

        if ($stmt->execute()) {
            // Order successfully added
            // You can redirect the user or display a success message
        } else {
            // Error adding the order
            // Handle the error (e.g., display an error message)
        }

        $stmt->close();
    } else {
        // Handle the case where userId is not set
    }

    $conn->close();
}
?>
