<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "BA52si6401";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plat_id = $_POST['plat_id'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['totalprice'];

    // Supposons que vous ayez une table 'Commande' avec les colonnes suivantes :
    // idCommande (auto-incrémenté), dateCommande, idClient, idEmploye, Client_idClient, Employe_idEmploye, Table_IdTable, Table_Facture_idFacture, Table_Employe_idEmploye, price, quantity

    // Créez la commande SQL pour insérer les données dans la table 'Commande'
    $insertCommandeQuery = "INSERT INTO commande (dateCommande, idClient, idEmploye, Client_idClient, Employe_idEmploye, Table_IdTable, Table_Facture_idFacture, Table_Employe_idEmploye, price, quantity) 
                            VALUES (NOW(), 'id_client', 'id_employe', 'id_client', 'id_employe', 'id_table', 'id_facture', 'id_employe', '$total_price', '$quantity')";

    // Exécutez la commande
    if ($conn->query($insertCommandeQuery) === TRUE) {
        echo "La commande a été ajoutée avec succès.";
    } else {
        echo "Erreur lors de l'ajout de la commande : " . $conn->error;
    }
}
?>
