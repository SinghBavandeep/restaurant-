<?php
session_start();

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

function query_database_prepared($query, $types, ...$params) {
    $conn = connect_to_database();
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error in prepared statement: " . $conn->error);
    }

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $result = $stmt->execute();

    if ($result === false) {
        die("Error executing prepared statement: " . $stmt->error);
    }

    if ($stmt->field_count > 0) {
        $resultSet = $stmt->get_result();

        if ($resultSet === false) {
            die("Error getting result set: " . $stmt->error);
        }

        $data = [];
        while ($row = $resultSet->fetch_assoc()) {
            $data[] = $row;
        }

        $resultSet->close();
    } else {
        $data = true;
    }

    $stmt->close();
    $conn->close();

    return $data;
}

// Check if the user is logged in
if (!isset($_SESSION['role'])) {
    // User is not logged in, redirect to login page or display a message
    echo "DEBUG: User is not logged in"; // Add this line for debugging
    header("Location: login.php"); // Change 'login.php' to your actual login page
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plat_id = $_POST['plat_id'];
    $quantity = $_POST['quantity'];

    $queryPlatInfo = "SELECT * FROM plat WHERE idPlat = ?";
    $platInfo = query_database_prepared($queryPlatInfo, 'i', $plat_id)[0];

    // Calculate the total price without rounding
    $totalPrice = $quantity * $platInfo['prix'];

    // Round the total price to two decimal places
    $totalPrice = round($totalPrice, 2);

    // Convert the rounded total price to a decimal value
    $totalPrice = floatval($totalPrice);

    // Use prepared statement to insert into the cart
    $queryInsertCart = "INSERT INTO panier (nom, quantite, totalprice) VALUES (?, ?, ?)";
    query_database_prepared($queryInsertCart, 'sii', $platInfo['Nom'], $quantity, $totalPrice);

    // Redirect to the cart display page
    header("Location: display_achat.php");
    exit();
}
?>
