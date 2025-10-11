<?php
$title_page;
ob_start();
?>

<style>
  body {
    margin: 0;
    padding: 0;
    background: #fdf2f8;

  }

  h2 {
    text-align: center;
    margin: 20px 0;
    color: #444;
  }

  .card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 20px;
    margin: 15px auto;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 500px;
    width: 400px;
  }


  .card img {
    width: 350px;
    height: 350px;
    object-fit: cover;
    border-radius: 8px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card img:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
  }

  h5 {
    margin: 10px;
    color: #222;
  }


  .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 40px;
  }

  main {
    flex: 1;
  }
</style>



<div class="col-12">


    <div class="row g-4 justify-content-center">
<h2> 🎁 Gift Hampers </h2>
      <!-- Product Item 1 -->
      <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card">
          <img src="images/hamper1.png" alt="White Rose Bouquet">
          <h5> Flowers With Gift </h5>
          <a href="p_description.php?id=11" class="btn">Buy Now</a>
        </div>
      </div>

      <!-- Product Item 2 -->
      <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card">
          <img src="images/hamper2.png" alt="Red & White Roses">
          <h5>Flowers & Chocolate Hamper </h5>
          <a href="p_description.php?id=12" class="btn">Buy Now</a>
        </div>
      </div>

      <!-- Product Item 3 -->
      <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card">
          <img src="images/hamper3.png" alt="Mixed Rose Bouquet">
          <h5>Beautiful Chocolate Bouquet</h5>
          <a href="p_description.php?id=13" class="btn">Buy Now</a>
        </div>
      </div>
     

    </div>
    </div>

<!-- Hidden form to submit Add to Cart -->
<form id="addToCartForm" method="GET" action="add_to_cart.php" style="display:none;">
  <input type="hidden" name="product" id="formProductId">
  <input type="hidden" name="name" id="formProductName">
  <input type="hidden" name="price" id="formProductPrice">
  <input type="hidden" name="quantity" id="formProductQuantity" value="1">
</form>

<script>
  // Add to Cart
  document.querySelectorAll('.btn-add-to-cart').forEach(button => {
    button.addEventListener('click', () => {
      if (confirm('Add this item to your cart?')) {
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const price = button.getAttribute('data-price');

        document.getElementById('formProductId').value = id;
        document.getElementById('formProductName').value = name;
        document.getElementById('formProductPrice').value = price;
        document.getElementById('formProductQuantity').value = 1;

        document.getElementById('addToCartForm').submit();
      }
    });
  });

  // Wishlist button (optional future feature)
  document.querySelectorAll('.btn-add-to-wishlist').forEach(button => {
    button.addEventListener('click', () => {
      const name = button.getAttribute('data-name');
      alert(`"${name}" added to wishlist 💌`);
    });
  });
</script>

<?php
$content1 = ob_get_clean();
include_once("layout.php");
?>