<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['logged_in_user'];

$name = htmlspecialchars($user['name'] ?? '');
$username = htmlspecialchars($user['username'] ?? '');
$email = htmlspecialchars($user['email'] ?? '');
$profile_photo = $user['profile_photo'] ?? 'default.png';

ob_start();
?>

<div class="profile-page">

  <div class="profile-card shadow rounded">

    <!-- Avatar -->
    <div class="profile-header text-center">
      <img src="profile_photos/<?= htmlspecialchars($profile_photo) ?>"
           alt="Profile Photo"
           width="120" height="120"
           class="profile-avatar rounded-circle">

      <h2 class="profile-name mt-2"><?= $name ?></h2>
      <p class="profile-username-pill"><?= $username ?></p>
      <p class="profile-email"><?= $email ?></p>
    </div>

    <!-- Options -->
    <ul class="options-list mt-4 mx-auto">
      <li class="option-item">
        <a href="view_profile.php" class="menu-link">
          <i class="fa-solid fa-eye"></i>
          View Profile
        </a>
      </li>

      <li class="option-item">
        <a href="edit_profile.php" class="menu-link">
          <i class="fa-solid fa-pen"></i>
          Edit Profile
        </a>
      </li>

      <li class="option-item">
        <a href="change_password.php" class="menu-link">
          <i class="fa-solid fa-lock"></i>
          Change Password
        </a>
      </li>
    </ul>

  </div>

</div>

<!-- FA CSS (Instant load, no jump) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body { background: #fadee9ff; font-family: 'Segoe UI', sans-serif; }

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
  border: 2px solid #d6336c;
  box-shadow: 0 15px 30px rgba(214, 51, 108, 0.15);
  transition: 0.3s ease;
}

.profile-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 25px 40px rgba(214, 51, 108, 0.25);
}

/* Avatar */
.profile-avatar {
  width: 120px;
  height: 120px;
  object-fit: cover;
  border: 4px solid #d6336c;
  border-radius: 50%;
}

/* Name */
.profile-name {
  color: #d6336c;
  font-size: 1.8rem;
  font-weight: bold;
}

/* Username pill */
.profile-username-pill {
  display: inline-block;
  background: #f8d7e3;
  color: #d6336c;
  padding: 5px 14px;
  border-radius: 20px;
  font-size: 0.95rem;
  font-weight: 600;
  margin-top: 4px;
}

/* Email */
.profile-email {
  color: #a86189;
  margin-top: 6px;
  font-size: 1rem;
}

/* Options List */
.options-list {
  list-style: none;
  padding: 0;
  max-width: 350px;
}

/* Option Item */
.option-item {
  background: #ffffff;
  border: 1px solid #f8d7e3;
  padding: 15px 20px;
  margin-bottom: 12px;
  border-radius: 12px;
  transition: 0.25s ease;
}

.option-item:hover {
  background: #ffe4f0;
  transform: translateY(-3px);
  box-shadow: 0 4px 10px rgba(214, 51, 108, 0.3);
}

/* Menu Link */
.menu-link {
  color: #d6336c;
  font-weight: 600;
  text-decoration: none;
  font-size: 1.15rem;

  display: flex;
  align-items: center;
  gap: 10px;
}

/* Icon reserved space (no jump) */
.menu-link i {
  width: 22px;
  text-align: center;
  font-size: 1.2rem;
}

.menu-link:hover {
  text-decoration: none;
  color: #b5295a;
}

/* Responsive */
@media(max-width:576px) {
  .profile-card { padding: 22px; }
  .profile-avatar { width: 100px; height: 100px; }
  .profile-name { font-size: 1.6rem; }
}
</style>

<?php
$Content1 = ob_get_clean();
$title_page = "<title>Profile - Unique Flower Shop</title>";
include 'layout.php';
?>
