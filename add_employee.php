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

$idEmployeErr = $NomErr = $RoleErr = $EmailErr = $PasswordErr = "";
$idEmploye = $Nom = $Role = $Email = $Password = "";
$errors = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["Idemploye"])) {
        $idEmployeErr = "Le numéro doit être saisi";
        $errors++;
    } else {
        $idEmploye = test_input($_POST["Idemploye"]);
        $Nom = test_input($_POST["Nom"]);
        $Role = test_input($_POST["Role"]);
        $Email = test_input($_POST["Email"]);
        $Password = test_input($_POST["Password"]);
    }

    // Ajoutez des vérifications similaires pour les autres champs

    if ($errors == 0) {
        // Assuming your table name is 'employe', adjust it if needed
        $query = "INSERT INTO employe (Idemploye, Nom, Email, Password, Role) VALUES ('$idEmploye', '$Nom', '$Email', '$Password', '$Role')";

        $conn = connect_to_database();

        if ($conn->query($query) === TRUE) {
            $_SESSION['success_message'] = "Employee added successfully!";
            // Redirect to display_employees.php
            header("Location: display_employees.php");
            exit(); // Ensure that the script stops here
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }

        $conn->close();
    }
}
?>

<?php include('include/header/header.php') ?>
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

    /* Set the width of the sidebar to 120px */
    .w3-sidebar {
        width: 120px;
        background: #222;
    }

    /* Add a left margin to the "page content" that matches the width of the sidebar (120px) */
    #main {
        margin-left: 120px
    }

    /* Remove margins from "page content" on small screens */
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

    <!-- Page Content -->
    <div class="w3-padding-large" id="main">
        <!-- Header/Home -->
        <header class="w3-container w3-padding-32 w3-center w3-black" id="home">
            <h1 class="w3-jumbo"><span class="w3-hide-small">Add Employees</span> </h1>
        </header>

        <!-- About Section -->
        <div class="w3-content w3-justify w3-text-grey w3-padding-64" id="about">

            <h2 class="txtWhite">Formulaire d'inscription d'un employe</h2>
            <p><span class="txtWhite"><span class="error">* <?php echo $idEmployeErr; ?></span> champs requis.</span></p>
            <form method="post" class="txtGold" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                Employe ID: <input type="text" name="Idemploye" value="<?php echo $idEmploye; ?>">
                <span class="error">* <?php echo $idEmployeErr; ?></span>
                <br><br>
                <h8 style="margin-right: 50px;">Nom:</h8> <input type="text" name="Nom" value="<?php echo $Nom; ?>">
                <span class="error">* <?php echo $NomErr; ?></span>
                <br><br>
                <h8 style="margin-right: 55px;">Role: </h8><input type="text" name="Role" value="<?php echo $Role; ?>">
                <span class="error">* <?php echo $RoleErr; ?></span>
                <br><br>
                <h8 style="margin-right: 45px;">Email: </h8><input type="text" name="Email" value="<?php echo $Email; ?>">
                <span class="error">* <?php echo $EmailErr; ?></span>
                <br><br>
                <h8 style="margin-right: 15px;">Password: </h8><input type="text" name="Password" value="<?php echo $Password; ?>">
                <span class="error">* <?php echo $PasswordErr; ?></span>
                <br><br>
                <input type="submit" name="submit" value="S'inscrire">
            </form>
        </div>
    </div>
</body>

</html>
