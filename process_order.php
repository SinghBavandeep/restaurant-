<?php
// process_order.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('include/ConnectionBD/db_connection.php');

function query_database($q) {
    $conn = connect_to_database();
    $query = $q;
    $result = $conn->query($query);

    if (!$result) {
        die("Query execution failed: " . $conn->error);
    }

    $tableData = array();

    while ($row = $result->fetch_assoc()) {
        $tableData[] = $row;
    }

    $result->close();
    $conn->close();

    return $tableData;
}

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

    // Insertion de la commande
    $insertCommandeQuery = "";

    switch ($role) {
        case 'admin':
        case 'client':
        case 'employe':
            $insertCommandeQuery = "INSERT INTO commande (userEmail, dateCommande, produit) VALUES (?, ?, ?)";
            break;

        default:
            echo "Error: Unknown user role!";
            exit;
    }

    $stmt = $conn->prepare($insertCommandeQuery);

    // Obtenez le contenu du panier
    $queryCartItems = "SELECT nom, quantite, totalprice FROM panier";
    $cartItems = query_database($queryCartItems);

    // Construisez une chaîne avec le contenu du panier
    $produit = "";
    foreach ($cartItems as $item) {
        $produit .= $item['nom'] . " (Quantité: " . $item['quantite'] . ", Prix: " . $item['totalprice'] . "), ";
    }

    // Supprimez la virgule et l'espace à la fin de la chaîne
    $produit = rtrim($produit, ', ');

    $stmt->bind_param("sss", $userEmail, $currentDate, $produit);

    if ($stmt->execute()) {
        // Commande ajoutée avec succès

        // Suppression du contenu du panier avec TRUNCATE TABLE
        $truncateQuery = "TRUNCATE TABLE panier";
        $conn->query($truncateQuery);

        // Redirection vers index.php
        header("Location: index.php");
        exit();
    } else {
        echo "Error adding the order: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
