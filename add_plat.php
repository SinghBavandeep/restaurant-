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

$idPlatErr = $NomErr = $prixErr = $idCategorieErr = $imageErr = $descriptionErr = "";
$idPlat = $Nom = $prix = $idCategorie = $image = $description = "";
$errors = 0;

// Récupérer les catégories depuis la base de données
$queryCategories = "SELECT * FROM categorie";
$categories = query_database($queryCategories);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPlat = test_input($_POST["idPlat"]);

    if (empty($idPlat)) {
        $idPlatErr = "Le numéro doit être saisi";
        $errors++;
    } else {
        $Nom = test_input($_POST["Nom"]);
        $prix = test_input($_POST["prix"]);
        $image = test_input($_FILES["image"]["name"]);
        $description = test_input($_POST["description"]);

        // Vérifiez les autres champs
        if (empty($Nom)) {
            $NomErr = "Le nom doit être saisi";
            $errors++;
        }

        if (empty($prix)) {
            $prixErr = "Le prix doit être saisi";
            $errors++;
        }

        if (empty($_POST["idCategorie"])) {
            $idCategorieErr = "L'id catégorie doit être sélectionné";
            $errors++;
        } else {
            $idCategorie = test_input($_POST["idCategorie"]);
        }

        if (empty($image)) {
            $imageErr = "L'image doit être téléchargée";
            $errors++;
        }

        if (empty($description)) {
            $descriptionErr = "La description doit être saisie";
            $errors++;
        }
    }

    if ($errors == 0) {
        $targetFile = $_FILES["image"]["name"];

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $query = "INSERT INTO plat (idPlat, Nom, prix, idCategorie, image, description) VALUES ('$idPlat', '$Nom', '$prix', '$idCategorie', '$targetFile', '$description')";

            $conn = connect_to_database();

            if ($conn->query($query) === TRUE) {
                $_SESSION['success_message'] = "Plat added successfully!";
                header("Location: display_plat.php");
                exit();
            } else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }

            $conn->close();
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    }
}
?>

<?php
include('include/header/header.php')
?>
<style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: "Montserrat", sans-serif
    }

    .w3-row-padding img {
        margin-bottom: 12px
    }

    .w3-sidebar {
        width: 120px;
        background: #222
    }

    #main {
        margin-left: 120px
    }

    @media only screen and (max-width: 600px) {
        #main {
            margin-left: 0
        }
    }

    .error {
        color: #FF0000;
    }
</style>
</head>

<body class="w3-black">

    <?php
    include('include/Nav/nav.php')
    ?>

    <div class="w3-padding-large" id="main">
        <header class="w3-container w3-padding-32 w3-center w3-black" id="home">
            <h1 class="w3-jumbo"><span class="w3-hide-small">Add Plat</span></h1>
        </header>

        <div class="w3-content w3-justify w3-text-grey w3-padding-64" id="about">
            <h2 class="txtWhite">Formulaire pour ajouter des plats</h2>
            <p><span class="txtWhite"><span class="error">* <?php echo $idPlatErr;?></span> champs requis.</span></p>
            <form method="post" class="txtGold" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                <label for="email" style="margin-right: 45px;">idPlat:</label>
                <input type="text" name="idPlat" value="<?php echo $idPlat; ?>">
                <span class="error">* <?php echo $idPlatErr;?></span>
                <br><br>
                <h8 style="margin-right: 50px;">Nom:</h8> <input type="text" name="Nom" value="<?php echo $Nom; ?>">
                <span class="error">* <?php echo $NomErr;?></span>
                <br><br>
                <h8 style="margin-right: 60px;">prix: </h8><input type="text" name="prix" value="<?php echo $prix; ?>">
                <span class="error">* <?php echo $prixErr;?></span>
                <br><br>
                <h8 style="margin-right: 15px;">Categorie: </h8>
                <select name="idCategorie">
                    <option value="" selected disabled>Sélectionnez une catégorie</option>
                    <?php
                    foreach ($categories as $categorie) {
                        echo "<option value='{$categorie['idCategorie']}'>{$categorie['Nom']}</option>";
                    }
                    ?>
                </select>
                <span class="error">* <?php echo $idCategorieErr;?></span>
                <br><br>
                <label for="email" style="margin-right: 40px;">Image: </label>
                <input type="file" name="image">
                <span class="error">* <?php echo $imageErr;?></span>
                <br><br>
                Description: <textarea name="description"><?php echo $description; ?></textarea>
                <span class="error">* <?php echo $descriptionErr;?></span>
                <br><br>
                <input type="submit" name="submit" value="S'inscrire">
            </form>
        </div>
    </div>
</body>

</html>
