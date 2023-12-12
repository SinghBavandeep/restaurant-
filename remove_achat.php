<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('include/ConnectionBD/db_connection.php');

function remove_item_from_cart($item_id) {
    $conn = connect_to_database();

    $item_id = $conn->real_escape_string($item_id);

    $removeItemQuery = "DELETE FROM panier WHERE idCart = '$item_id'";
    
    if ($conn->query($removeItemQuery) === TRUE) {
        header("Location: cart.php");
    } else {
        header("Location: cart.php");
    }

    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove'])) {
    $item_id = $_POST['item_id'];
    remove_item_from_cart($item_id);
}
?>
