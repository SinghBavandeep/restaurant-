<?php
include('include/ConnectionBD/db_connection.php');

// Vérifie si l'idPlat est défini dans l'URL
if (isset($_GET['idPlat'])) {
    $idPlat = $_GET['idPlat'];

    // Supprime le plat de la base de données
    $query = "DELETE FROM plat WHERE idPlat = '$idPlat'";
    $conn = connect_to_database();

    if ($conn->query($query) === TRUE) {
        // Redirige vers la page display_plat.php après la suppression
        header("Location: display_plat.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
} else {
    // Redirige vers la page display_plat.php si l'idPlat n'est pas défini
    header("Location: display_plat.php");
    exit();
}
?>
