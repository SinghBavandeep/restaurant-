<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
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

// Define the query_database function
function query_database($q)
{
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

// Récupérer les éléments du panier
$queryCartItems = "SELECT * FROM panier";
$cartItems = query_database($queryCartItems);
?>

<?php
  include('include/header/header.php')
?>
<style>
    body, h1, h2, h3, h4, h5, h6 {
      font-family: "Montserrat", sans-serif;
    }

    /* Add a background image */
    body {
      background-image: url('image/fond.png');
      background-size: cover;
      background-repeat: no-repeat;
    }

    .w3-row-padding img {
      margin-bottom: 12px;
    }

    .w3-sidebar {
      width: 120px;
      background: #222;
    }

    #main {
      margin-left: 120px;
    }

    /* Style for the "About" section */
    .about-container {
      background-color: rgba(255, 255, 255, 0.7);
      border-radius: 15px;
      padding: 20px;
      margin-top: 20px;
    }

    @media only screen and (max-width: 600px) {
      #main {
        margin-left: 0;
      }
    }

    /* Style for the table */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2; /* Add background color for header row */
    }
</style>
</head>
<body class="w3-black">
    <?php
        include('include/Nav/nav.php')
    ?>
    <!-- Page Content -->
    <div class="about-container w3-text-black">
        <div class="w3-padding-large" id="main">
        <!-- Header/Home -->
        <header class="w3-container w3-padding-32 w3-center" id="home">
            <h1 class="w3-jumbo"><span class="w3-hide-small">Shopping Cart</span></h1>
        </header>
        <!-- About Section -->
        <div class="w3-content w3-justify w3-text-black" id="about">
            <hr style="width:200px" class="w3-opacity w3-text-black">
            <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Quantité</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td><?php echo $item['nom']; ?></td>
                                <td><?php echo $item['quantite']; ?></td>
                                <td><?php echo $item['totalprice']; ?></td>
                                <td>
                                    <form action="remove_achat.php" method="post">
                                        <input type="hidden" name="item_id" value="<?php echo $item['idCart']; ?>">
                                        <button type="submit" name="remove">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <form action="process_order.php" method="post">
                    <button type="submit" name="order">Commander</button>
                </form>
        </div>
    </div>
  </div>
</body>
</html>
