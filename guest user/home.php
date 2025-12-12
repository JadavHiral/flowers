<?php
ob_start();
?>

<head>

  <style>
    /* Hero Section */
    .hero {
      background: url('images/wp15.jpg') center/cover no-repeat;
      height: 400px;
      padding: 100px 20px;
      text-align: center;
      color: #030005ff;
    }

    .hero h2 {
      font-size: 2.8em;
      margin-bottom: 15px;
      font-weight: bold;
    }

    .hero p {
      font-size: 1.2em;
      margin-bottom: 25px;
    }

    @media (max-width: 768px) {
      .hero {
        padding: 60px 15px;
        height: auto;
      }

      .hero h2 {
        font-size: 2em;
      }

      .hero p {
        font-size: 1em;
      }
    }

    .card-title {
      font-size: 1.1em;
    }

    .card img {
      max-height: 250px;
      object-fit: cover;
    }

    .card {
      height: 100%;
    }

    .card-body {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    /* Offers Section Container */
    .offers-section {
      background: #fff0f5;
      /* soft pink background */
      padding: 60px 20px;
      border-radius: 12px;
      margin-bottom: 40px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    /* Heading */
    .offers-section h2 {
      text-align: center;
      font-size: 2.8em;
      font-weight: bold;
      color: #d63384;
      margin-bottom: 40px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    /* Offer Cards */
    .offer-card {
      background: #fff;
      border: 2px solid #d63384;
      border-radius: 16px;
      padding: 30px;
      text-align: center;
      margin: 20px auto;
      max-width: 800px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .offer-card:hover {
      transform: scale(1.03);
      box-shadow: 0 12px 25px rgba(214, 51, 132, 0.3);
    }

    .offer-card h5 {
      font-size: 1.8em;
      font-weight: bold;
      color: #d63384;
      margin-bottom: 15px;
    }

    .offer-card p {
      font-size: 1.2em;
      color: #333;
      margin-bottom: 10px;
    }

    .offer-card b {
      font-size: 1.1em;
      background: #d63384;
      color: #fff;
      padding: 6px 15px;
      border-radius: 8px;
    }

    /* View All Offers Button */
    .btn-offers {

      background-color: #ff6f91;
      color: black;
      padding: 10px 50px;
      border: none;
      border-radius: 150px;
      font-size: 1em;
      cursor: pointer;
      text-decoration: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: background-color 0.0s;
    }

    .btn-offers:hover {
      background-color: #ed6386ff;
    }
  </style>
</head>
</style>
</head>

<body>

  <!--banner image-->
  <section class="hero">

    <h2>Fresh Blooms Delivered With Love</h2>
    <p>Discover our handpicked collection of flowers for every occasion.</p>
    <p> Fresh Flowers, Fresh Smiles.😊</p>
    <a href="category.php" class="btn">Shop Now</a>
  </section>


  <!-- Offers Section -->
  <div class="offers-section">
    <h2>🌟 Special Offers & Discounts 🌟</h2>

    <!-- Offer card -->

    <a href="offers.php" style="text-decoration:none; color:inherit;">
      <div class="offer-card">
        <h5>🎄 Christmas Sale</h5>
        <p>Flat Up to 20% off on Products</p>
        <p><b>Valid till 31st December</b></p>
      </div>
    </a>

    <div class="container my-5">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">

        <!-- Card 1 -->
        <div class="col">
          <div class="card h-100">
            <img src="images/plants/flowerplant2.jpg" class="card-img-top img-fluid" alt="Flower 1">
            <div class="card-body text-center">
              <h5 class="card-title"><b>Flower Plant</b></h5>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="col">
          <div class="card h-100">
            <img src="images/tulipbasket.jpg" class="card-img-top img-fluid" alt="Flower 2">
            <div class="card-body text-center">
              <h5 class="card-title"><b>Tulip Bouquet</b></h5>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="col">
          <div class="card h-100">
            <img src="images/rose.jpg" class="card-img-top img-fluid" alt="Flower 3">
            <div class="card-body text-center">
              <h5 class="card-title"><b>Pink Rose</b></h5>
            </div>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="col">
          <div class="card h-100">
            <img src="images/flowerpot.jpg" class="card-img-top img-fluid" alt="Flower 4">
            <div class="card-body text-center">
              <h5 class="card-title"><b>Flower Pot</b></h5>
            </div>
          </div>
        </div>

        <!-- Card 5 -->
        <div class="col">
          <div class="card h-100">
            <img src="images/redtulip.jpg" class="card-img-top img-fluid" alt="Flower 5">
            <div class="card-body text-center">
              <h5 class="card-title"><b>Red Tulip</b></h5>
            </div>
          </div>
        </div>

        <!-- Card 6 -->
        <div class="col">
          <div class="card h-100">
            <img src="images/plants/plantimg2.jpg" class="card-img-top img-fluid" alt="Flower 6">
            <div class="card-body text-center">
              <h5 class="card-title"><b>Indoor Plants</b></h5>
            </div>
          </div>
        </div>

      </div>
    </div>


    <?php
    $content1 = ob_get_clean();
    include_once("layout.php");
    ?>
