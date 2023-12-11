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

// Fetch all distinct categories from the database
$queryCategories = "SELECT DISTINCT Nom FROM categorie";
$categories = query_database($queryCategories);

// Fetch dishes based on the selected idCategorie
$nomCategorieFilter = isset($_GET['nomCategorie']) ? $_GET['nomCategorie'] : null;
$whereClause = $nomCategorieFilter ? "WHERE Categorie.Nom = '$nomCategorieFilter'" : "";
$queryDishes = "SELECT plat.Nom as PlatNom, Categorie.Nom as CategorieNom, prix FROM plat JOIN categorie ON plat.idCategorie = categorie.idCategorie $whereClause";
$dishData = query_database($queryDishes);
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
  </style>
</head>
<body class="w3-black">

  <!-- Icon Bar (Sidebar - hidden on small screens) -->
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
    <a href="add_employee2.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
      <i class="fa fa-plus-circle w3-xxlarge"></i>
      <p>Add2</p>
    </a>
  </nav>

  <!-- Navbar on small screens (Hidden on medium and large screens) -->
  <div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
    <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
      <a href="index.php" class="w3-bar-item w3-button" style="width:25% !important">HOME</a>
      <a href="display_employees.php" class="w3-bar-item w3-button" style="width:25% !important">Employee</a>
      <a href="display_plat.php" class="w3-bar-item w3-button" style="width:25% !important">Plat</a>
      <a href="add_employee2.php" class="w3-bar-item w3-button" style="width:25% !important">Add2</a>
    </div>
  </div>

  <!-- Page Content -->
  <div class="about-container w3-text-black">
    <div class="w3-padding-large" id="main">
      <!-- Header/Home -->
      <header class="w3-container w3-padding-32 w3-center" id="home">
        <h1 class="w3-jumbo"><span class="w3-hide-small">Plat</span></h1>
      </header>

      <!-- nomCategorie Filter -->
      <div>
        <label for="nomCategorie">Select a category:</label>
        <select id="nomCategorie" name="nomCategorie" onchange="location = this.value;">
          <option value="display_plat.php" <?php echo $nomCategorieFilter ? '' : 'selected'; ?>>All Categories</option>
          <?php
          foreach ($categories as $categorie) {
              $selected = ($nomCategorieFilter == $categorie['Nom']) ? 'selected' : '';
              echo "<option value='display_plat.php?nomCategorie={$categorie['Nom']}' $selected>{$categorie['Nom']}</option>";
          }
          ?>
        </select>
      </div>
      <!-- Add Plat Button -->
      <div class="w3-padding-large w3-center">
        <a href="add_plat.php" class="w3-button w3-black w3-round-large">Add Plat</a>
      </div>
      <!-- Display Dishes -->
      <div class="w3-content w3-justify" id="about">
        <table class="w3-table w3-bordered">
          <tr>
            <th>Name</th>
            <th>Categorie</th>
            <th>Price</th>
          </tr>
          <?php
          foreach ($dishData as $row) {
              echo "<tr>";
              echo "<td>" . $row['PlatNom'] . "</td>";
              echo "<td>" . $row['CategorieNom'] . "</td>";
              echo "<td>" . $row['prix'] . "</td>";
              echo "</tr>";
          }
          ?>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
