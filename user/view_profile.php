<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['logged_in_user'];

$name = htmlspecialchars($user['name'] ?? '');
$username = htmlspecialchars($user['username'] ?? '');
$email = htmlspecialchars($user['email'] ?? '');
$phone = htmlspecialchars($user['phone'] ?? '');
$city = htmlspecialchars($user['city'] ?? '');
$state = htmlspecialchars($user['state'] ?? '');
$country = htmlspecialchars($user['country'] ?? '');
$address = htmlspecialchars($user['address'] ?? '');
$profile_photo = $user['profile_photo'] ?? 'default.png';

ob_start();
?>

<div class="profile-page">

  <div class="profile-card shadow rounded">
    <div class="profile-header text-center">

      <!-- FIXED: Prevent image jump by adding width & height -->
      <img src="profile_photos/<?= htmlspecialchars($profile_photo) ?>"
           alt="Profile Photo"
           width="120" height="120"
           class="profile-avatar rounded-circle">

      <h2 class="profile-name mt-2"><?= $name ?: $username ?></h2>
      <p class="profile-username-pill"><?= $username ?></p>
    </div>

    <div class="profile-details mt-4">
      <div class="detail-item"><i class="fa-solid fa-envelope"></i> <span><?= $email ?></span></div>
      <div class="detail-item"><i class="fa-solid fa-phone"></i> <span><?= $phone ?></span></div>
      <div class="detail-item"><i class="fa-solid fa-city"></i> <span><?= $city ?></span></div>
      <div class="detail-item"><i class="fa-solid fa-location-dot"></i> <span><?= $state ?>, <?= $country ?></span></div>
      <div class="detail-item"><i class="fa-solid fa-house"></i> <span><?= nl2br($address) ?></span></div>
    </div>

    <div class="profile-buttons mt-4 text-center">
      <a href="edit_profile.php" class="btn btn-gradient">
        <i class="fa-solid fa-pen"></i> Edit Profile
      </a>

      <a href="profile_main.php" class="btn btn-outline-pink">
        <i class="fa-solid fa-arrow-left"></i> Back
      </a>
    </div>

  </div>

</div>

<!-- FAST Font Awesome (no jump, no delay) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body { background:  #fadee9ff; font-family: 'Segoe UI', sans-serif; }

.profile-page {
  display: flex;
  justify-content: center;
  padding: 50px 15px;
}

.profile-card {
  background: #fff;
  max-width: 500px;
  width: 100%;
  border-radius: 20px;
  padding: 30px;
  box-shadow: 0 15px 30px rgba(214, 51, 108, 0.2);
  transition: transform 0.3s, box-shadow 0.3s;
}

.profile-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 25px 40px rgba(214, 51, 108, 0.3);
}

.profile-avatar {
  width: 120px;
  height: 120px;
  object-fit: cover;
  border: 4px solid #d6336c;
  border-radius: 50%;
}

.profile-name { color: #d6336c; font-size: 1.8rem; margin: 5px 0; }

.profile-username-pill {
    display: inline-block;
    background-color: #f8d7e3;
    color: #d6336c;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.95rem;
    font-weight: 600;
    margin-top: 8px;
}

.profile-details { margin-top: 20px; }
.detail-item {
  display: flex;
  align-items: center;
  margin-bottom: 12px;
  font-size: 1.05rem;
  color: #4b2a4d;
}
.detail-item i {
  color: #d6336c;
  width: 25px;
  margin-right: 12px;
  font-size: 1.2rem;
}

/* FIXED BUTTON RESIZE */
.btn {
    min-width: 180px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn i {
    width: 20px; 
    text-align: center;
}

.profile-buttons a {
  display: inline-block;
  margin: 10px 10px;
  padding: 12px 25px;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-gradient {
  background: linear-gradient(135deg, #d6336c, #ff7ca1);
  color: #fff;
}
.btn-gradient:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(214, 51, 108, 0.4); }

.btn-outline-pink {
  border: 2px solid #d6336c;
  color: #d6336c;
}
.btn-outline-pink:hover { background-color: #d6336c; color: #fff; }

@media(max-width:576px) {
  .profile-card { padding: 20px; }
  .profile-avatar { width: 100px; height: 100px; }
  .profile-buttons a { width: 100%; margin: 8px 0; }
}
</style>

<?php
$Content1 = ob_get_clean();
$title_page = "<title>View Profile - Unique Flower Shop</title>";
include 'layout.php';
?>
