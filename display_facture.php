<!-- display_facture.php -->
<?php
include('db_connection.php');

function get_invoice_data($invoice_id)
{
    $query = "SELECT * FROM facture WHERE idFacture = $invoice_id";
    return query_database($query);
}

function display_invoice($invoice_id)
{
    $invoice_data = get_invoice_data($invoice_id);

    if (empty($invoice_data)) {
        echo "Invoice not found.";
        return;
    }

    $montant = $invoice_data[0]['Montant'];
    $idTable = $invoice_data[0]['idTable'];

    echo "<h2>Invoice #$invoice_id</h2>";
    echo "<p>Montant: $montant</p>";
    echo "<p>Table ID: $idTable</p>";

    // You can add more details from your database as needed.

    // Add styling or additional formatting as required.
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>PolyRestaurant</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    /* Add your existing styles here */
  </style>
</head>
<body class="w3-black">

  <!-- Add your existing navigation and header here -->

  <!-- Page Content -->
  <div class="about-container w3-text-black">
    <div class="w3-padding-large" id="main">
      <!-- Display Invoice Section -->
      <section>
        <?php
        // Replace 1 with the actual idFacture you want to display
        display_invoice(1);
        ?>
      </section>
    </div>
  </div>
</body>
</html>
