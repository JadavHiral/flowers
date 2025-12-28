<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("db_config.php"); // DB connection for categories

$isLoggedIn = isset($_SESSION['logged_in_user']);
$username   = $isLoggedIn ? ($_SESSION['logged_in_user']['username'] ?? '') : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flower Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
    <script src="js/validate.js"></script>

    <style>
        html, body { height: 100%; margin: 0; }
        body { display: flex; flex-direction: column; }
        .container-fluid { flex: 1; display: flex; flex-direction: column; }
        .main-content { flex: 1; }
        footer { width: 100%; background: #222; color: white; text-align: center; padding: 15px 0; margin: 0; }
        .navbar .nav-link { color: white !important; }
        .navbar .nav-link:hover { color: #ff6f91 !important; text-decoration: underline; transition: color 0.3s ease; }
        .navbar-toggler { border-color: white; }
        .search-form input, .search-form select { margin-right: 5px; }
        .btn-pink { background-color: #ff6f91; color: white; }
        .btn-pink:hover { background-color: #ed6386; color: white; }
        .row { display:flex; flex-wrap:wrap; justify-content:center; gap:30px; }
        .card { background:white; border-radius:10px; box-shadow:0 4px 6px rgba(0,0,0,0.1); text-align:center; padding:20px; width:400px; }
        .card img { width:350px; height:350px; object-fit:cover; border-radius:8px; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card img:hover { transform:scale(1.05); box-shadow:0 6px 12px rgba(0,0,0,0.3); }
        h5 { margin:10px; color:#222; }
        .no-results { margin-top:50px; text-align:center; }
        .no-results p { font-size:18px; margin-bottom:20px; }
    </style>
</head>

<body>
<div class="container-fluid p-0">

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg bg-black px-3">
    <a class="navbar-brand fw-bold" href="home.php" style="color:pink;">🌷 Flower Shop</a>

    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="category.php">Categories</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="aboutus.php">About Us</a></li>
        </ul>

        <!-- ===== Search Form ===== -->
        <form class="d-flex search-form me-3" method="GET" action="">
            <input class="form-control" type="text" name="search" placeholder="Search products..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <select class="form-select" name="category">
                <option value="">All Categories</option>
                <?php
                $cats = mysqli_query($con, "SELECT cat_id, cat_nm FROM category ORDER BY cat_nm ASC");
                while ($cat = mysqli_fetch_assoc($cats)) {
                    $selected = (isset($_GET['category']) && $_GET['category'] == $cat['cat_id']) ? 'selected' : '';
                    echo '<option value="'. (int)$cat['cat_id'] .'" '.$selected.'>'. htmlspecialchars($cat['cat_nm']) .'</option>';
                }
                ?>
            </select>
            <button type="submit" class="btn btn-pink"><i class="fas fa-search"></i></button>
        </form>

        <!-- ===== Right Icons ===== -->
        <ul class="navbar-nav align-items-center">
            <!-- User Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                    <?php if ($isLoggedIn && !empty($_SESSION['logged_in_user']['profile_photo'])) : ?>
                        <img src="profile_photos/<?= htmlspecialchars($_SESSION['logged_in_user']['profile_photo']) ?>" style="width:35px;height:35px;border-radius:50%;object-fit:cover;">
                    <?php else : ?>
                        <i class="fas fa-user"></i>
                    <?php endif; ?>
                    <span class="ms-2"><?= $isLoggedIn ? htmlspecialchars($username) : 'Account' ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <?php if ($isLoggedIn) : ?>
                        <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                        <li><a class="dropdown-item" href="view_profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    <?php else : ?>
                        <li><a class="dropdown-item" href="login.php">Login</a></li>
                        <li><a class="dropdown-item" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </li>

            <!-- Cart -->
            <li class="nav-item me-3">
                <a class="nav-link" href="<?= $isLoggedIn ? 'cart_show.php' : 'login.php' ?>" 
                   onclick="<?= !$isLoggedIn ? "alert('Please login to view cart');" : '' ?>" title="Cart">
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </li>

            <!-- Wishlist -->
            <li class="nav-item me-3">
                <a class="nav-link" href="<?= $isLoggedIn ? 'whishlist.php' : 'login.php' ?>" 
                   onclick="<?= !$isLoggedIn ? "alert('Please login to view wishlist');" : '' ?>" title="Wishlist">
                    <i class="fas fa-heart"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- ================= CONTENT ================= -->
<div class="main-content p-3">
<?php
// Display dynamic search results
if (isset($_GET['search']) || isset($_GET['category'])) {
    $searchTerm = trim($_GET['search'] ?? '');
    $categoryId = intval($_GET['category'] ?? 0);

    $sql = "SELECT p.pid, p.pnm, p.img, s.sub_cat_nm 
            FROM product p 
            LEFT JOIN sub_category s ON p.sub_cat_id = s.sub_cat_id
            WHERE 1";

    $params = [];
    $types = "";

    if ($searchTerm !== '') {
        $sql .= " AND p.pnm LIKE ?";
        $types .= "s";
        $params[] = "%$searchTerm%";
    }

    if ($categoryId > 0) {
        $sql .= " AND p.sub_cat_id IN (SELECT sub_cat_id FROM sub_category WHERE cat_id=?)";
        $types .= "i";
        $params[] = $categoryId;
    }

    $stmt = $con->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $res = $stmt->get_result();

    echo '<h2 class="text-center mb-4">Search Results</h2>';

    if ($res && $res->num_rows > 0) {
        echo '<div class="row">';
        while ($row = $res->fetch_assoc()) {
            echo '<div class="card">';
            echo '<img src="'.htmlspecialchars($row['img']).'" alt="'.htmlspecialchars($row['pnm']).'">';
            echo '<h5>'.htmlspecialchars($row['pnm']).'</h5>';
            echo '<p>'.htmlspecialchars($row['sub_cat_nm']).'</p>';
            echo '<a href="p_description.php?id='.$row['pid'].'" class="btn btn-pink">View Details</a>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="no-results">';
        echo '<p>No matching products found.</p>';
        echo '<a href="home.php" class="btn btn-pink">Back to Products</a>';
        echo '</div>';
    }
} else {
    // Show normal content if no search
    if (isset($title_page)) echo $title_page;
    if (isset($content1)) echo $content1;
}
?>
</div>

<!-- ================= FOOTER ================= -->
<footer>
    © 2025 Flower Shop | Designed by
    Jagruti Sagathiya · Hiral Jadav · Diya Apte
</footer>

</div>
</body>
</html>
