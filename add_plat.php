<?php
session_start();

include('include/ConnectionBD/db_connection.php');

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

function test_input($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$idPlatErr = $NomErr = $prixErr=$idCategorieErr="";
$idPlat = $Nom = $prix=$idCategorie="";
$errors=0;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (empty($_POST["idPlat"])) 
    {
        $idPlatErr = "Le numéro doit être saisi";
        $errors++;
    } else 
    {
    $idPlat = test_input($_POST["idPlat"]);
		$Nom = test_input($_POST["Nom"]);
		$prix = test_input($_POST["prix"]);
    $idCategorie = test_input($_POST["idCategorie"]);
    }
    
    // Add similar checks for other fields

    if ($errors==0)
    {
        // Assuming your table name is 'employe', adjust it if needed
        $query = "INSERT INTO plat (idPlat, Nom, prix,idCategorie) VALUES ('$idPlat', '$Nom', '$prix','$idCategorie')";
        
        $conn = connect_to_database();

        if ($conn->query($query) === TRUE) {
            $_SESSION['success_message'] = "Employee added successfully!";
            // Redirect to display_plat.php
            header("Location: display_plat.php");
            exit(); // Ensure that the script stops here
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }

        $conn->close();
    }
}
?>

<?php
  include('include/header/header.php')
?>
<style>
body, h1,h2,h3,h4,h5,h6 {font-family: "Montserrat", sans-serif}
.w3-row-padding img {margin-bottom: 12px}
/* Set the width of the sidebar to 120px */
.w3-sidebar {width: 120px;background: #222;}
/* Add a left margin to the "page content" that matches the width of the sidebar (120px) */
#main {margin-left: 120px}
/* Remove margins from "page content" on small screens */
@media only screen and (max-width: 600px) {#main {margin-left: 0}}
.error {color: #FF0000;}
</style>
</head>
<body class="w3-black">

  <?php
    include('include/Nav/nav.php')
  ?>

<!-- Page Content -->
<div class="w3-padding-large" id="main">
  <!-- Header/Home -->
  <header class="w3-container w3-padding-32 w3-center w3-black" id="home">
    <h1 class="w3-jumbo"><span class="w3-hide-small">Add Employees</span> </h1>
  </header>

  <!-- About Section -->
  <div class="w3-content w3-justify w3-text-grey w3-padding-64" id="about">
<h2 class="txtWhite">Formulaire d'inscription d'un employee</h2>
<p><span class="txtWhite"><span class="error">* <?php echo $idPlatErr;?></span> champs requis.</span></p>
<form method="post" class="txtGold" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    idPlat: <input type="text" name="idPlat" value="<?php echo $idPlat; ?>">
  	<span class="error">* <?php echo $idPlatErr;?></span>
	<br><br>
	<h8 style="margin-right: 43px;">Nom:</h8> <input type="text" name="Nom" value="<?php echo $Nom; ?>">
  	<span class="error">* <?php echo $NomErr;?></span>
	<br><br>
  <h8 style="margin-right: 47px;">prix: </h8><input type="text" name="prix" value="<?php echo $prix; ?>">
  	<span class="error">* <?php echo $prixErr;?></span>
	<br><br>
  <h8 style="margin-right: 1px;">idCategorie: </h8><input type="text" name="idCategorie" value="<?php echo $idCategorie; ?>">
  	<span class="error">* <?php echo $idCategorieErr;?></span>
	<br><br>
  	<input type="submit" name="submit" value="S'inscrire">    
</form>
  </div>
</body>
</html>
