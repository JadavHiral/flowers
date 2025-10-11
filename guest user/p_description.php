<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Sanitize and get product ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Define products array
$products = [
  1 => [
    'id' => 1,
    'name' => 'Rose',
    'price' => 599,
    'image' => 'images/roseport.jpg',
    'description' => 'A rose is delicate flower known for its vibrant color and fragrant petals symbolizes love & beauty.'
  ],
  2 => [
    'id' => 2,
    'name' => 'Lotus',
    'price' => 499,
    'image' => 'images/lotus2.jpg',
    'description' => 'The lotus is a graceful aquatic flower that symbolizes purity & Enlightement, often blooming beautifully above muddy waters.'
  ],
  3 => [
    'id' => 3,
    'name' => 'Pink Rose',
    'price' => 599,
    'image' => 'images/pinkrose.jpg',
    'description' => 'A beautiful bouquet of fresh white roses perfect for any occasion.'
  ],
  4 => [
    'id' => 4,
    'name' => 'SunFlowers',
    'price' => 599,
    'image' => 'images/wp7.jpg',
    'description' => 'The sunflower is a bright & cheerful flower known for turning it face toward the sun, symbolizes warm & positivity.'
  ],
  5 => [
    'id' => 5,
    'name' => 'Tulip',
    'price' => 599,
    'image' => 'images/tulip2.jpg',
    'description' => 'Tulip is a vibrant & Cup-shape flower that symbolizes elegence and perfect love, blooming in a wide range of colors.'
  ],
  6 => [
    'id' => 6,
    'name' => 'Rose Bouquet',
    'price' => 599,
    'image' => 'images/rosebouquet.jpg',
    'description' => 'A beautiful bouquet of fresh  roses perfect for any occasion.'
  ],
  7 => [
    'id' => 7,
    'name' => 'Small Hand Bookey',
    'price' => 599,
    'image' => 'images/skyblueflower.jpg',
    'description' => 'A beautiful small handy bokeh.its perfect for any birthday wishes and any other small event to giving.'
  ],
  8 => [
    'id' => 8,
    'name' => 'White Rose',
    'price' => 599,
    'image' => 'images/whitebookey.jpg',
    'description' => 'A white rose with green leaves symbolizes purity,innocence and new begginings.'
  ],
  9 => [
    'id' => 9,
    'name' => 'Jasmin',
    'price' => 599,
    'image' => 'images/jasmin.jpg',
    'description' => 'A jasmin Bouquet is a fregrant arrengement of delicate white blossom, symbolizing purity,love and grace.'
  ],
  10 => [
    'id' => 10,
    'name' => 'Red Rosbookey',
    'price' => 599,
    'image' => 'images/bookey.png',
    'description' => 'A red rose bouquet is a classic symbol of deep love and passion, expressing heartfelt emotions with elegance.'
  ],
  11 => [
    'id' => 11,
    'name' => 'Flowers With Gift',
    'price' => 999,
    'image' => 'images/hamper1.png',
    'description' => 'A beautiful arrangement of flowers paired with a thoughtful gifts..'
  ],
  12 => [
    'id' => 12,
    'name' => 'Flowers & Chocolate Hamper',
    'price' => 1500,
    'image' => 'images/hamper2.png',
    'description' => 'A delightful hamper combining fresh flowers with a selection of premium chocolates.'
  ],
  13 => [
    'id' => 13,
    'name' => 'Beautiful Chocolate Bouquet',
    'price' => 899,
    'image' => 'images/hamper3.png',
    'description' => 'An elegant bouquet crafted from various chocolates,perfect for any occasion.'
  ],

  14 => [
    'id' => 14,
    'name' => 'Moneyplant',
    'price' => 499,
    'image' => 'images/plants/moneyplant2.jpg',
    'description' => 'A popular hanging plants known of its heart-shaped leaves and its Symbol of prosperity,good luck and wealth,easy to grow and maintain with minimal care.'
  ],
  15 => [
    'id' => 15,
    'name' => 'Cactus',
    'price' => 200,
    'image' => 'images/plants/cactus.jpg',
    'description' => 'Cactus is known for its thick,spiky stems that store water, symbolizes endurance,strength and resilience.'
  ],
  16 => [
    'id' => 16,
    'name' => 'Aloevera',
    'price' => 150,
    'image' => 'images/plants/aloevera.jpg',
    'description' => 'A succulent with thick,fleshy leaves,prizes for its madicinal properties and its symbolizes health,healing and natureal remedy.'
  ],
  17 => [
    'id' => 17,
    'name' => 'Aglaonema',
    'price' => 500,
    'image' => 'images/plants/aglaonema.jpg',
    'description' => 'Tropical plant with striking variegated leaves. its known for its air-purifying qualities and easy care.'
  ],
  18 => [
    'id' => 18,
    'name' => 'Birdofparadise',
    'price' => 1300,
    'image' => 'images/plants/birdofparadise.jpg',
    'description' => 'Tropical plant known for its striking,bird-like flowers.'
  ],
  19 => [
    'id' => 19,
    'name' => 'Flower Plant',
    'price' => 499,
    'image' => 'images/plants/fplant.png',
    'description' => 'Produce colorful bloomes that enhance garden beauty.'
  ],
];

$product = $products[$id] ?? null;

if (!$product) {
  echo "<p>Product not found.</p>";
  exit;
}
?>

<style>
  .product-container {
    max-width: 900px;
    margin: 50px auto;
    display: flex;
    gap: 40px;

  }

  .product-image {
    flex: 1;
  }

  @media(max-width:768px) {
    .product-image {
      width: 100%;
      height: auto;
    }
  }

  .product-image img {
    width: 550px;
    height: 550px;
    border-radius: 10px;
    object-fit: cover;
    padding: 20px;
    margin: 30px;
    box-shadow: 0px 2px 6px rgb(0, 0, 0, 0.2);
  }

  .product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .product-info h2 {
    margin-bottom: 15px;
    color: #000000ff;
    ;
    font-size: 2rem;
  }

  .product-info p.description {
    font-size: 1.1rem;
    margin-bottom: 25px;
    color: #555;
  }

  .product-info .price {
    font-weight: 700;
    font-size: 1.5rem;
    color: black;
    margin-bottom: 25px;
  }

  .product-info label {
    font-weight: 700;
    margin-bottom: 10px;
  }

  .product-info input[type="number"] {
    width: 80px;
    padding: 8px;
    font-size: 1rem;
    border: 1.5px solid #ccc;
    border-radius: 8px;
    margin-bottom: 25px;
  }

  .product-info .actions {
    display: flex;
    gap: 15px;
  }

  .product-info button {
    flex: 1;
    padding: 12px 0;

    border-radius: 8px;
    cursor: pointer;
    width: 200px;
    transition: background-color 0.3s ease;
  }
</style>

<div class="product-container">
  <div class="product-image">
    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
  </div>
  <div class="product-info">
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <p class="description"><?= htmlspecialchars($product['description']) ?></p>
    <p class="price">₹<?= number_format($product['price'], 2) ?></p>

    <form method="GET" action="add_to_cart.php">
      <label for="quantity">Quantity:</label>
      <input type="number" id="quantity" name="quantity" value="1" min="1" max="100" required>

      <input type="hidden" name="product" value="<?= $product['id'] ?>">
      <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
      <input type="hidden" name="price" value="<?= $product['price'] ?>">

      <div class="actions">
        <button type="submit" class="btn">🛒 Add to Cart</button>
    </form>

    <form method="POST" action="whishlist.php" style="flex:1;">
      <input type="hidden" name="product" value="<?= $product['id'] ?>">
      <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
      <button type="submit" class="btn">💌Add to Wishlist</button>

<!--online-->
     <!-- <form method="POST" action="wishlist_action.php">
  <input type="hidden" name="id" value="<?= $product['id'] ?>">
  <input type="hidden" name="name" value="<?= $product['name'] ?>">
  <input type="hidden" name="image" value="<?= $product['image'] ?>">
  <button type="submit" name="add_to_wishlist">💖 Add to Wishlist</button>
</form>-->

    </form>

  </div>
</div>
</div>

<?php
$content1 = ob_get_clean();
include_once("layout.php");
?>