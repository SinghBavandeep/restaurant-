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

$NomErr = $EmailErr = $PasswordErr = "";
$Nom = $Email = $Password = "";
$errors = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input fields
    if (empty($_POST["Nom"])) {
        $NomErr = "Le nom est requis";
        $errors++;
    } else {
        $Nom = test_input($_POST["Nom"]);
    }

    if (empty($_POST["Email"])) {
        $EmailErr = "L'email est requis";
        $errors++;
    } else {
        $Email = test_input($_POST["Email"]);
    }

    if (empty($_POST["Password"])) {
        $PasswordErr = "Le mot de passe est requis";
        $errors++;
    } else {
        $Password = test_input($_POST["Password"]);
    }

    if ($errors == 0) {
        // Hash the password before storing in the database for security
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

        // Assuming your table name is 'client', adjust it if needed
        $query = "INSERT INTO client (Nom, Email, Password) VALUES ('$Nom', '$Email', '$hashedPassword')";

        $conn = connect_to_database();

        if ($conn->query($query) === TRUE) {
            // Log in the client
            $_SESSION['role'] = 'client';
            $_SESSION['username'] = $Nom;

            // Redirect to the appropriate page
            header("Location: index.php");
            exit();
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
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
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
    <?php
    include('include/Nav/nav.php')
    ?>

    <!-- Page Content -->
    <div class="about-container w3-text-black">
        <div class="w3-padding-large" id="main">
            <!-- Header/Home -->
            <header class="w3-container w3-padding-32 w3-center" id="home">
                <h1 class="w3-jumbo"><span class="w3-hide-small">Create your account</span></h1>
            </header>

            <!-- About Section -->
            <div class="w3-content w3-justify" id="about">
                <hr style="width:200px" class="w3-opacity">

                <!-- Add your content here -->

                <h2>Add your information</h2>
                <p><span class="error">* champs requis.</span></p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="Nom" style="margin-right: 35px;">Nom:</label> 
                    <input type="text" name="Nom" value="<?php echo $Nom; ?>">
                    <span class="error">* <?php echo $NomErr; ?></span>
                    <br><br>
                    <label for="Nom" style="margin-right: 30px;">Email: </label>
                    <input type="text" name="Email" value="<?php echo $Email; ?>">
                    <span class="error">* <?php echo $EmailErr; ?></span>
                    <br><br>
                    Password: <input type="password" name="Password" value="<?php echo $Password; ?>">
                    <span class="error">* <?php echo $PasswordErr; ?></span>
                    <br><br>
                    <input type="submit" name="submit" value="Ajouter">
                </form>

            </div>
        </div>
    </div>
</body>
</html>
