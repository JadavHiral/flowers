


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['logged_in_user']);
$username = $isLoggedIn ? ($_SESSION['logged_in_user']['username'] ?? '') : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>🌸 Unique Flower Shop 🌸</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" />

  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      font-family: 'Open Sans', sans-serif;
     /* background: linear-gradient(to right, #ffeff7, #fff0f6);*/
      color: #5a2a4d;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    body {
      flex: 1 0 auto;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    main {
      flex: 1 0 auto;
      padding: 1rem 1rem 3rem 1rem;
      max-width: 1200px;
      margin: 0 auto;
      width: 90%;
    }

    .navbar {
      background-color: #d6336c; /* pink */
      box-shadow: 0 3px 8px rgba(214, 51, 108, 0.6);
      font-weight: 600;
    }

    .navbar:hover {
      background-color: #c42d61;
    }

    .navbar-brand {
      font-family: 'Pacifico', cursive;
      font-size: 1.9rem;
      color: #fff !important;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
    }

    .navbar-nav .nav-link {
      color: #fff !important;
      font-weight: 600;
      transition: color 0.3s ease;
      position: relative;
    }

    .navbar-nav .nav-link:hover {
      color: #ffcce5 !important;
    }

    .footer {
      background-color: #f8bbd0;
      padding: 1rem 0;
      color: #880e4f;
      font-weight: 600;
      text-align: center;
      margin-top: auto;
      box-shadow: inset 0 1px 2px rgba(255,255,255,0.3);
    }

    .navbar-toggler {
      border: none;
      color: white;
      font-size: 1.4rem;
    }

    .navbar-toggler:focus {
      box-shadow: none;
    }

    .dropdown-menu {
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(214, 51, 108, 0.4);
      border: 1px solid #d6336c;
    }

    .dropdown-item {
      font-weight: 600;
      color: #5a2a4d;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .dropdown-item:hover {
      background-color: #ffcce5;
      color: #d6336c;
    }

    .nav-icons .nav-link i {
      color: #fff;
      font-size: 1.3rem;
      transition: transform 0.2s ease, color 0.3s ease;
    }

    .nav-icons .nav-link:hover i {
      transform: scale(1.25);
      color: #ffcce5;
    }

    .dropdown-toggle::after {
      filter: brightness(0) invert(1);
      margin-left: 0.3rem;
    }

    @media (max-width: 575.98px) {
      .nav-icons {
        flex-direction: column;      /* stack icons vertically */
        align-items: flex-start;     /* align to left */
        gap: 0.5rem;
        margin-top: 1rem;
        padding-left: 1rem;          /* small left padding */
      }

      .nav-icons .nav-item {
        margin-left: 0 !important;   /* remove default left margin */
      }

      .dropdown-menu {
        position: static !important; /* dropdown below button */
        float: none !important;
        left: 0 !important;          /* align left */
        right: auto !important;
      }
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">🌸 Unique Flower Shop 🌸</a>

      <!-- Mobile toggle -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navMenu"
        aria-controls="navMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <i class="fas fa-bars"></i>
      </button>

      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="products.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
        </ul>

<!-- Right side icons and user -->
<ul class="navbar-nav ms-auto mb-2 mb-lg-0 nav-icons align-items-center">
  <li class="nav-item dropdown">
    <a
      class="nav-link dropdown-toggle d-flex align-items-center"
      href="#"
      id="userDropdown"
      role="button"
      data-bs-toggle="dropdown"
      aria-expanded="false"
    >
      <?php if ($isLoggedIn && !empty($_SESSION['logged_in_user']['profile_photo'])) : ?>
          <img src="profile_photos/<?= htmlspecialchars($_SESSION['logged_in_user']['profile_photo']) ?>" 
               alt="Profile" 
               style="width:35px; height:35px; object-fit:cover; border-radius:50%; border:2px solid #fff;">
      <?php else : ?>
          <i class="fas fa-user"></i>
      <?php endif; ?>
      <span class="ms-2 text-white fw-semibold">
          <?= $isLoggedIn ? htmlspecialchars($username) : 'Account' ?>
      </span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
      <?php if ($isLoggedIn) : ?>
        <li><a class="dropdown-item" href="dashboard.php">📊 Dashboard</a></li>
        <li><a class="dropdown-item" href="view_profile.php">👤 Profile</a></li>
        <li><a class="dropdown-item" href="logout.php">🚪 Logout</a></li>
      <?php else : ?>
        <li><a class="dropdown-item" href="register.php">Register</a></li>
        <li><a class="dropdown-item" href="login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </li>

  <li class="nav-item ms-3">
    <a href="whishlist.php" class="nav-link" title="Wishlist">
      <i class="fas fa-heart"></i>
    </a>
  </li>

  <li class="nav-item ms-3">
    <a href="cart_show.php" class="nav-link" title="Cart">
      <i class="fas fa-shopping-cart"></i>
    </a>
  </li>
</ul>



      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main>
    <?php
    if (isset($title_page)) echo $title_page;
    if (isset($Content1)) echo $Content1;
    ?>
  </main>

  <!-- Footer -->
  <footer class="footer">
    &copy; 2025 Unique Flower Shop. All rights reserved.
  </footer>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
