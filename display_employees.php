<?php
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

// Fetch and display all employees
$query = "SELECT * FROM employe";
$employeeData = query_database($query);
?>

<?php include('include/header/header.php') ?>
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



/* Style for the table */
.employee-table {
    border-collapse: collapse;
    width: 100%;
}

.employee-table th, .employee-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.employee-table th {
    background-color: #f2f2f2;
}

/* Set the width of the sidebar to 120px */
.w3-sidebar {width: 120px;background: #222;}
/* Add a left margin to the "page content" that matches the width of the sidebar (120px) */
#main {margin-left: 120px}
/* Remove margins from "page content" on small screens */
@media only screen and (max-width: 600px) {#main {margin-left: 0}}
</style>
</head>
<body class="w3-black">
  <?php include('include/Nav/nav.php') ?>

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
        <th>Email</th>
        <!-- Add more columns as needed -->
      </tr>
      <?php
      foreach ($employeeData as $row) {
          echo "<tr>";
          echo "<td>" . $row['Idemploye'] . "</td>";
          echo "<td>" . $row['Nom'] . "</td>";
          echo "<td>" . $row['Role'] . "</td>";
          echo "<td>" . $row['Email'] . "</td>";
          // Add more table cells for additional columns
          echo "</tr>";
      }
      ?>
    </table>
  </div>
</div>

</body>
</html>
