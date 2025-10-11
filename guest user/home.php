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


  <!--Welcome-->
  <marquee behavior="alternate" direction="left">
    <h1 style="text-align: center;  padding: 15px 10px; display:inline-block;"> Welcome To Unique Flower Shop </h1>
  </marquee>


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
