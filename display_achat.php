<?php
include('db_connection.php');

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

// Fetch all categories
$queryCategories = "SELECT * FROM categorie";
$categories = query_database($queryCategories);

// Fetch all plats based on the selected category
$nomCategorieFilter = isset($_GET['nomCategorie']) ? $_GET['nomCategorie'] : null;
$whereClause = $nomCategorieFilter ? "WHERE Categorie.Nom = '$nomCategorieFilter'" : "";
$queryPlats = "SELECT * FROM plat JOIN categorie ON plat.idCategorie = categorie.idCategorie $whereClause";
$plats = query_database($queryPlats);

$idPlatErr = $NomErr = $PrixErr = $CategorieErr = "";
$idPlat = $Nom = $Prix = $idCategorie = "";
$errors = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (Votre validation de formulaire ici)
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
    body, h1, h2, h3, h4, h5, h6 {
        font-family: "Montserrat", sans-serif;
    }

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

    .about-container {
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 15px;
        padding: 20px;
        margin-top: 20px;
    }

    .w3-row-padding {
        margin: 0 -16px;
    }

    .w3-quarter {
        width: 30%;
        padding: 0 16px;
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 10px;
        box-sizing: border-box;
        display: inline-block;
        text-align: center;
    }

    .w3-quarter img {
        width: 100%;
        height: 150px; /* Hauteur fixe pour toutes les images */
        object-fit: cover; /* Éviter la déformation, mais certaines parties de l'image peuvent être coupées */
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .product-details {
        margin-top: 10px;
    }

    @media only screen and (max-width: 600px) {
        .w3-quarter {
            width: 100%;
        }
    }
    </style>

</head>
<body class="w3-black">

<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
    <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-black">
        <i class="fa fa-home w3-xxlarge"></i>
        <p>HOME</p>
    </a>
    <a href="display_employees.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
        <i class="fa fa-user w3-xxlarge"></i>
        <p>Employee</p>
    </a>
    <a href="display_plat.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
        <i class="fa fa-plus-circle w3-xxlarge"></i>
        <p>Plat</p>
    </a>
    <a href="display_achat.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
        <i class="fa fa-plus-circle w3-xxlarge"></i>
        <p>Add2</p>
    </a>
</nav>

<div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
    <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
        <a href="index.php" class="w3-bar-item w3-button" style="width:25% !important">HOME</a>
        <a href="display_employees.php" class="w3-bar-item w3-button" style="width:25% !important">Employee</a>
        <a href="add_employee.php" class="w3-bar-item w3-button" style="width:25% !important">Plat</a>
        <a href="add_plat.php" class="w3-bar-item w3-button" style="width:25% !important">Add2</a>
    </div>
</div>

<div class="about-container w3-text-black">
    <div class="w3-padding-large" id="main">
        <header class="w3-container w3-padding-32 w3-center" id="home">
            <h1 class="w3-jumbo"><span class="w3-hide-small"> Buy</span></h1>
        </header>

        <!-- Filtre par catégorie -->
        <form method="get" action="display_achat.php">
            <label for="nomCategorie">Filter by category:</label>
            <select id="nomCategorie" name="nomCategorie" onchange="this.form.submit();">
                <option value="" <?php echo (!$nomCategorieFilter) ? 'selected' : ''; ?>>All Categories</option>
                <?php
                foreach ($categories as $categorie) {
                    $selected = ($nomCategorieFilter == $categorie['Nom']) ? 'selected' : '';
                    echo "<option value='{$categorie['Nom']}' $selected>{$categorie['Nom']}</option>";
                }
                ?>
            </select>
        </form>

        <!-- Photo Grid -->
        <div class="w3-row-padding w3-padding-16" id="food">
            <?php 
            $count = 0;
            foreach ($plats as $plat) { 
                if ($count % 3 == 0) {
                    echo '<div class="w3-row-padding">';
                }
            ?>
            <div class="w3-quarter">
                <img src="image/<?php echo $plat['image']; ?>" alt="<?php echo $plat['Nom']; ?>">
                <div class="product-details">
                    <h3><?php echo $plat['Nom']; ?></h3>
                    <p><?php echo $plat['description']; ?></p>

                    <form method="post" action="process_achat.php">
                        <input type="hidden" name="plat_id" value="<?php echo $plat['idPlat']; ?>">

                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1" onchange="updateTotal(this.value, <?php echo $plat['prix']; ?>, 'total_<?php echo $plat['idPlat']; ?>')">

                        <input type="hidden" name="totalprice" id="total_<?php echo $plat['idPlat']; ?>" value="<?php echo $plat['prix']; ?>">

                        <div name="totalprice">Total: $<?php echo number_format($plat['prix'], 2); ?></div>

                        <input type="submit" value="Add to Cart">
                    </form>
                </div>
            </div>
            <?php 
                $count++;
                if ($count % 3 == 0) {
                    echo '</div>';
                }
            } ?>
        </div>

        <!-- ... (Le reste de votre contenu ici) ... -->

    </div>
</div>

<!-- Ajout du script JavaScript pour la mise à jour dynamique du total -->
<script>
function updateTotal(quantity, unitPrice, totalId) {
    var total = quantity * unitPrice;
    document.getElementById(totalId).innerHTML = "Total: $" + total.toFixed(2);
    document.getElementById('total_' + totalId).value = total; // Mise à jour de la valeur cachée pour le totalprice
}
</script>

</body>
</html>
