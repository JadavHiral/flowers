<?php
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit;
}

// Get user data from session
$user = $_SESSION['logged_in_user'];
$name = htmlspecialchars($user['name'] ?? '');
$username = htmlspecialchars($user['username'] ?? '');
$profile_photo = $user['profile_photo'] ?? 'default.png'; // fallback photo

ob_start();
?>

<div class="dashboard-header d-flex align-items-center mb-4">
    <div class="profile-photo me-3">
        <img src="profile_photos/<?= htmlspecialchars($profile_photo) ?>" alt="Profile Photo" class="rounded-circle" width="70" height="70">
    </div>
    <div class="welcome-text">
        <h1 class="mb-0">Welcome, <?= $name ?: $username ?>!</h1>
        <p class="text-muted mb-0">Manage your account and orders</p>
    </div>
</div>

<div class="row gy-4">

  <div class="col-sm-6 col-md-3">
    <a href="profile_main.php" class="text-decoration-none">
      <div class="card border-pink shadow-sm h-100 text-center p-4">
        <h3 class="text-pink mb-2">👤 Profile</h3>
        <p class="text-pink fw-semibold">Manage your profile details</p>
      </div>
    </a>
  </div>

  <div class="col-sm-6 col-md-3">
    <a href="order_history.php" class="text-decoration-none">
      <div class="card border-pink shadow-sm h-100 text-center p-4">
        <h3 class="text-pink mb-2">📦 Orders</h3>
        <p class="text-pink fw-semibold">View your orders</p>
      </div>
    </a>
  </div>

  <div class="col-sm-6 col-md-3">
    <a href="cart_main.php" class="text-decoration-none">
      <div class="card border-pink shadow-sm h-100 text-center p-4">
        <h3 class="text-pink mb-2">🛒 Cart</h3>
        <p class="text-pink fw-semibold">View cart & wishlist</p>
      </div>
    </a>
  </div>

  <div class="col-sm-6 col-md-3">
    <a href="feedback.php" class="text-decoration-none">
      <div class="card border-pink shadow-sm h-100 text-center p-4">
        <h3 class="text-pink mb-2">💬 Feedback</h3>
        <p class="text-pink fw-semibold">Give us your feedback</p>
      </div>
    </a>
  </div>

</div>

<style>
  body{background-color: #fadee9ff;}
.text-pink { color: #d6336c !important; }
.border-pink { border: 2px solid #d6336c !important; }
.card:hover {
    box-shadow: 0 8px 20px rgba(214, 51, 108, 0.4);
    cursor: pointer;
    transform: translateY(-5px);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.profile-photo img {
    object-fit: cover;
    border: 2px solid #d6336c;
}
</style>

<?php
$Content1 = ob_get_clean();
$title_page = "<title>User Dashboard - Unique Flower Shop</title>";
include 'layout.php';
?>
