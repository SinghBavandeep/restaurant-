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

$idPlatErr = $NomErr = $PrixErr = $CategorieErr = "";
$idPlat = $Nom = $Prix = $idCategorie = "";
$errors = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["idPlat"])) {
        $idPlatErr = "The dish ID is required";
        $errors++;
    } else {
        $idPlat = test_input($_POST["idPlat"]);
    }

    if (empty($_POST["Nom"])) {
        $NomErr = "The dish name is required";
        $errors++;
    } else {
        $Nom = test_input($_POST["Nom"]);
    }

    if (empty($_POST["Prix"])) {
        $PrixErr = "The price is required";
        $errors++;
    } else {
        $Prix = test_input($_POST["Prix"]);
    }

    if (empty($_POST["Categorie"])) {
        $CategorieErr = "The category is required";
        $errors++;
    } else {
        $Categorie = test_input($_POST["Categorie"]);

        // Find the category ID based on the category name
        $categoryData = array_filter($categories, function ($category) use ($Categorie) {
            return $category['Nom'] == $Categorie;
        });

        if (empty($categoryData)) {
            // Category not found, handle the error as needed
            $CategorieErr = "Invalid category";
            $errors++;
        } else {
            $idCategorie = reset($categoryData)['idCategorie'];
        }
    }

    if ($errors == 0) {
        // Assuming your table name is 'plat', adjust it if needed
        $query = "INSERT INTO plat (idPlat, Nom, prix, idCategorie) VALUES ('$idPlat', '$Nom', '$Prix', '$idCategorie')";

        if (query_database($query)) {
            echo "Dish added successfully!";
        } else {
            echo "Error adding dish: " . $conn->error;
        }
    }
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
    <a href="add_plat.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
      <i class="fa fa-plus-circle w3-xxlarge"></i>
      <p>Add2</p>
    </a>
  </nav>

  <!-- Navbar on small screens (Hidden on medium and large screens) -->
  <div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
    <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
      <a href="index.php" class="w3-bar-item w3-button" style="width:25% !important">HOME</a>
      <a href="display_employees.php" class="w3-bar-item w3-button" style="width:25% !important">Employee</a>
      <a href="add_employee.php" class="w3-bar-item w3-button" style="width:25% !important">Plat</a>
      <a href="add_plat.php" class="w3-bar-item w3-button" style="width:25% !important">Add2</a>
    </div>
  </div>

  <!-- Page Content -->
  <div class="about-container w3-text-black">
    <div class="w3-padding-large" id="main">
      <!-- Header/Home -->
      <header class="w3-container w3-padding-32 w3-center" id="home">
        <h1 class="w3-jumbo"><span class="w3-hide-small">Welcome to PolyRestaurant</span></h1>
        <p>Your Culinary Oasis</p>
      </header>

      <!-- About Section -->
      <div class="w3-content w3-justify" id="about">
        <h2 class="w3-text-light-black">About Us</h2>
        <hr style="width:200px" class="w3-opacity">
        <p>At PolyRestaurant, we strive to create a dining experience that goes beyond the ordinary. Our chefs meticulously craft each dish with passion and creativity, offering a menu that celebrates the finest ingredients and flavors from around the world.</p>
        <p>Step into our elegant ambiance, where modern aesthetics blend seamlessly with warm hospitality. Whether you're here for a casual meal, a romantic dinner, or a special celebration, PolyRestaurant sets the stage for unforgettable moments.</p>
        <p>Indulge in our diverse menu featuring culinary masterpieces, handpicked wines, and decadent desserts. Our commitment to quality, freshness, and innovation ensures that every visit is a journey for your senses.</p>
        <p>Join us at PolyRestaurant, where culinary excellence meets a welcoming atmosphere. We look forward to serving you and making your dining experience truly exceptional.</p>
        <!-- Button to Order Now page -->
        <a href="order_now.php" class="w3-button w3-black w3-margin-top">Order Now</a>
      </div>
    </div>
  </div>
</body>
</html>
