<?php
session_start();

include('include/ConnectionBD/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = connect_to_database();

    // Check admin table
    $queryAdmin = "SELECT * FROM admin WHERE Email = '$email'";
    $resultAdmin = $conn->query($queryAdmin);

    // Check employe table
    $queryEmploye = "SELECT * FROM employe WHERE Email = '$email'";
    $resultEmploye = $conn->query($queryEmploye);

    // Check client table
    $queryClient = "SELECT * FROM client WHERE Email = '$email'";
    $resultClient = $conn->query($queryClient);

    if ($resultAdmin->num_rows > 0) {
        $row = $resultAdmin->fetch_assoc();
        if (password_verify($password, $row['Password']) || $password == $row['Password']) {
            $_SESSION['role'] = 'admin';
            header("Location: index.php");
            exit();
        }
    } elseif ($resultEmploye->num_rows > 0) {
        $row = $resultEmploye->fetch_assoc();
        if (password_verify($password, $row['Password']) || $password == $row['Password']) {
            $_SESSION['role'] = 'employe';
            header("Location: index.php");
            exit();
        }
    } elseif ($resultClient->num_rows > 0) {
        $row = $resultClient->fetch_assoc();
        if (password_verify($password, $row['Password']) || $password == $row['Password']) {
            $_SESSION['role'] = 'client';
            header("Location: index.php");
            exit();
        }
    }

    $error_message = "Incorrect credentials. Please try again.";
}

include('include/header/header.php');
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
    </style>
</head>
<body class="w3-black">
    <?php
    include('include/Nav/nav.php');
    ?>

    <!-- Page Content -->
    <div class="about-container w3-text-black">
        <div class="w3-padding-large" id="main">
            <header class="w3-container w3-padding-32 w3-center" id="home">
                <h1 class="w3-jumbo"><span class="w3-hide-small">Login page </span></h1>
            </header>

            <div class="w3-content w3-justify" id="about">
                <h2 class="w3-text-light-black">Login information</h2>
                <hr style="width:200px" class="w3-opacity">

                <?php
                if (isset($error_message)) {
                    echo '<p style="color: red;">' . $error_message . '</p>';
                }
                ?>

                <form method="post" action="">
                    <label for="email" style="margin-right: 29px;">Email:</label>
                    <input type="email" name="email" required ><br>

                    <label for="password">Password:</label>
                    <input type="password" name="password" required><br>

                    <input type="submit" value="Login">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
