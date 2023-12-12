<?php
  include('include/header/header.php')
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
    include('include/Nav/nav.php')
  ?>

  <!-- Page Content -->
  <div class="about-container w3-text-black">
    <div class="w3-padding-large" id="main">
      <!-- Header/Home -->
      <header class="w3-container w3-padding-32 w3-center" id="home">
        <h1 class="w3-jumbo"><span class="w3-hide-small">Welcome to PolyRestaurant</span></h1>
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
        <a href="display_achat.php" class="w3-button w3-black w3-margin-top">Order Now</a>
      </div>
    </div>
  </div>
</body>
</html>
