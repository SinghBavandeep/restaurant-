<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
?>

<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
    <?php
    // Dynamic HOME link based on user role
    if ($role === "admin") {
        echo '<a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-black">
                <i class="fa fa-home w3-xxlarge"></i>
                <p>HOME</p>
            </a>';
        echo '<a href="cart.php" class="w3-bar-item w3-button w3-padding-large w3-black">
            <i class="fa fa-shopping-cart w3-xxlarge"></i>
            <p>Panier</p>
        </a>';
    } elseif ($role === "employe") {
        echo '<a href="employe_home.php" class="w3-bar-item w3-button w3-padding-large w3-black">
                <i class="fa fa-home w3-xxlarge"></i>
                <p>HOME</p>
            </a>';
        echo '<a href="cart.php" class="w3-bar-item w3-button w3-padding-large w3-black">
            <i class="fa fa-shopping-cart w3-xxlarge"></i>
            <p>Panier</p>
        </a>';
    } else {
        echo '<a href="index.php.php" class="w3-bar-item w3-button w3-padding-large w3-black">
                <i class="fa fa-home w3-xxlarge"></i>
                <p>HOME</p>
            </a>';
        echo '<a href="cart.php" class="w3-bar-item w3-button w3-padding-large w3-black">
            <i class="fa fa-shopping-cart w3-xxlarge"></i>
            <p>Panier</p>
        </a>';
    }
    ?>

    <?php
    // Common options for both admin, client, and employe
    echo '<a href="display_achat.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
            <i class="fa fa-plus-circle w3-xxlarge"></i>
            <p>Plat</p>
        </a>';

    // Admin-specific options
    if ($role === "admin") {
        echo '<a href="display_employees.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
                <i class="fa fa-user w3-xxlarge"></i>
                <p>Employee</p>
            </a>';
        echo '<a href="display_plat.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
                <i class="fa fa-plus-circle w3-xxlarge"></i>
                <p>Plat</p>
            </a>';
        // Add other admin-specific options here
    }

    // Employe-specific options
    if ($role === "employe") {
        echo '<a href="display_plat.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
                <i class="fa fa-plus-circle w3-xxlarge"></i>
                <p>Plat</p>
            </a>';
        // Add other employe-specific options here
    }
    ?>

    <a href="logout.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
        <i class="fa fa-sign-out w3-xxlarge"></i>
        <p>Log Out</p>
    </a>
</nav>

<?php
} else {
?>
<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
    <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-black">
        <i class="fa fa-home w3-xxlarge"></i>
        <p>HOME</p>
    </a>

    <a href="display_achat.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
        <i class="fa fa-plus-circle w3-xxlarge"></i>
        <p>Plat</p>
    </a>

    <a href="login.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
        <i class="fa fa-sign-in w3-xxlarge"></i>
        <p>Login</p>
    </a>

    <a href="add_client.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
        <i class="fa fa-user-plus w3-xxlarge"></i>
        <p>Create Account</p>
    </a>
</nav>
<?php
}
?>
