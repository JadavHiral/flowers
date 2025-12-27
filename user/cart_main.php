<?php
session_start();
require 'db_config.php'; // DB connection

// Ensure user is logged in
if (!isset($_SESSION['logged_in_user'])) {
  header("Location: login.php");
  exit;
}

$user = $_SESSION['logged_in_user'];
$username = $user['username'];

// Get cart count
$stmt = $con->prepare("SELECT SUM(qty) as total_qty FROM add_to_cart WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$cart_count = $row['total_qty'] ?? 0;

ob_start();
?>

<div class="center-content">
  <h1 class="mb-4">🛒 Cart & 💖 Wishlist</h1>

  <ul class="list-group border-pink">
    <li class="list-group-item">
      <a href="cart_show.php" class="text-pink fw-semibold text-decoration-none">
        🛒 View Cart (<?= $cart_count ?> items)
      </a>
    </li>
    <li class="list-group-item">
      <a href="whishlist.php" class="text-pink fw-semibold text-decoration-none">
        💖 Wishlist
      </a>
    </li>
  </ul>
</div>

<style>
  .center-content {
    max-width: 320px;
    margin: 2rem auto;
    text-align: center;
  }

  .text-pink {
    color: #d6336c !important;
  }

  .border-pink {
    border: 2px solid #d6336c !important;
    border-radius: 10px;
    background: #fff0f6;
    box-shadow: 0 4px 8px rgba(214, 51, 108, 0.1);
  }

  .list-group {
    padding-left: 0;
    list-style: none;
    margin: 0;
  }

  .list-group-item {
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-weight: 600;
    font-size: 1.1rem;
    border: none;
    padding: 15px 10px;
  }

  .list-group-item:hover {
    background-color: #ffe4f0;
  }

  a.text-pink {
    text-decoration: none;
    display: block;
  }

  a.text-pink:hover {
    text-decoration: underline;
  }

  @media (max-width: 480px) {
    .center-content {
      max-width: 90%;
      margin: 1.5rem auto;
    }

    .list-group-item {
      font-size: 1rem;
      padding: 12px 8px;
    }

    h1 {
      font-size: 1.6rem;
    }
  }
</style>

<?php
$Content1 = ob_get_clean();
$title_page = "<title>Cart & Wishlist - Unique Flower Shop</title>";
include 'layout.php';
?>
