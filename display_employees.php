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

// Fetch and display all employees
$query = "SELECT * FROM employe";
$employeeData = query_database($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Display Employees</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
<style>
body, h1, h2, h3, h4, h5, h6 {font-family: "Montserrat", sans-serif}
/* Add a background image */
body {
      background-image: url('image/fond.png');
      background-size: cover;
      background-repeat: no-repeat;
    }
/* Style for the "section */
.container-white {
      background-color: rgba(255, 255, 255, 0.7);
      border-radius: 15px;
      padding: 20px;
      margin-top: 20px;
    }
.w3-row-padding img {margin-bottom: 12px}
/* Set the width of the sidebar to 120px */
.w3-sidebar {width: 120px;background: #222;}
/* Add a left margin to the "page content" that matches the width of the sidebar (120px) */
#main {margin-left: 120px}
/* Remove margins from "page content" on small screens */
@media only screen and (max-width: 600px) {#main {margin-left: 0}}
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
    <a href="add_employee.php" class="w3-bar-item w3-button" style="width:25% !important">Add</a>
    <a href="add_employee2.php" class="w3-bar-item w3-button" style="width:25% !important">Add2</a>
  </div>
</div>

<!-- Page Content -->
<div class="w3-padding-large container-white" id="main">
  <!-- Header/Home -->
  <header class="w3-container w3-padding-32 w3-center w3-text-black" id="home">
    <h1 class="w3-jumbo"><span class="w3-hide-small">Display Employees</span> </h1>
  </header>

  <!-- About Section -->
  <div class="w3-content w3-justify w3-text-grey w3-padding-64" id="about">
    <!-- Add button to redirect to "add.php" -->
    <a href="add_employee.php" class="w3-button w3-black w3-margin-bottom">Add Employee</a>

    <table class="employee-table">
      <tr>
        <th>idEmploye</th>
        <th>Nom</th>
        <th>Role</th>
        <!-- Add more columns as needed -->
      </tr>
      <?php
      foreach ($employeeData as $row) {
          echo "<tr>";
          echo "<td>" . $row['idEmploye'] . "</td>";
          echo "<td>" . $row['Nom'] . "</td>";
          echo "<td>" . $row['Role'] . "</td>";
          // Add more table cells for additional columns
          echo "</tr>";
      }
      ?>
    </table>
  </div>
</div>

</body>
</html>
