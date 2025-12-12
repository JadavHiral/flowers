<?php
ob_start();
include_once("db_connect.php"); // connect to DB

// Fetch offers from the offers table
$query = "SELECT * FROM offers WHERE valid_until >= CURDATE()";
$result = mysqli_query($conn, $query);
?>

<head>
  <style>
    body {
      background: #fae8f4ff;
    }

    /* Page Header */
    .offers-header {
      text-align: center;
      padding: 50px 20px;
      background: linear-gradient(135deg, #ffdde1, #ee9ca7);
      color: #020202ff;
      border-radius: 12px;
      margin-bottom: 40px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .offers-header h2 {
      font-size: 2.8em;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .offers-header p {
      font-size: 1.2em;
      margin-top: 10px;
    }

    /* Offer Product Cards */
    .offer-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      text-align: center;
      padding: 20px;
      margin: 15px auto;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 550px;
      width: 400px;
    }


    .offer-card img {
      width: 350px;
      height: 350px;
      object-fit: cover;
      border-radius: 8px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .offer-card img:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }

    .offer-card h5 {
      font-size: 1.4em;
      font-weight: bold;
      color: #d63384;
      margin-bottom: 10px;
    }

    .offer-card p {
      font-size: 1.1em;
      color: #333;
      margin-bottom: 8px;
    }

    .offer-card .price {
      font-size: 1.2em;
      color: #d63384;
      font-weight: bold;
    }

    /* Button Styling */
    .btn-shop {

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

    .btn-shop:hover {
      background-color: #ed6386ff;
    }


    /* Grid Layout */
    .offers-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
    }

    @media (max-width: 768px) {
      .offers-header h2 {
        font-size: 2em;
      }

      .offer-card {
        padding: 20px;
      }

      .offer-card h5 {
        font-size: 1.2em;
      }

      .offer-card p {
        font-size: 1em;
      }
    }
  </style>
</head>

<body>

  <!-- Page Header -->
  <div class="offers-header">
    <h2>🌟 Special Offers & Discounts 🌟</h2>
    <p>Exclusive deals available only here — shop your favorite flowers at special prices!</p>
  </div>

  <!-- Offers Grid -->
  <div class="offers-grid">
    <?php
    if (mysqli_num_rows($result) > 0) {
      while ($offer = mysqli_fetch_assoc($result)) { ?>
        <div class="offer-card">
          <img src="<?php echo $offer['image']; ?>" alt="<?php echo $offer['product_name']; ?>">
          <h5><?php echo $offer['product_name']; ?></h5>
          <p><?php echo $offer['description']; ?></p>
          <p class="price">
            ₹<?php echo $offer['discount_price']; ?>
            <del>₹<?php echo $offer['original_price']; ?></del>
          </p><br>
          <a href="add_to_cart.php?product=<?php echo $offer['offer_id']; ?>
            &name=<?php echo urlencode($offer['product_name']); ?>
            &price=<?php echo $offer['discount_price']; ?>
            &quantity=1" class="btn-shop">Buy Now</a>

        </div>
    <?php
      }
    } else {
      echo "<p style='text-align:center;'>No offers available right now.</p>";
    }
    ?>
  </div>

  <?php
  $content1 = ob_get_clean();
  include_once("layout.php"); // uses your header/footer layout
  ?>