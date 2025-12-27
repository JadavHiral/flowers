<?php
session_start();

// ✅ Ensure user is logged in
if (!isset($_SESSION['logged_in_user']['email'])) {
    header("Location: login.php");
    exit;
}

// ------------------------
// Include database config
// ------------------------
include 'db_config.php'; // $con is the database connection
$email = $_SESSION['logged_in_user']['email'];

// ------------------------
// Get latest user data from DB
// ------------------------
$stmt = $con->prepare("SELECT id, username, name, email, phone, city, state, country, address, profile_photo FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// ------------------------
// Handle form submission
// ------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $address = $_POST['address'];

    // Handle profile photo upload
    $profile_photo = $user['profile_photo'] ?? 'default.png';
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === 0) {
        $upload_dir = "profile_photos/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        $ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
        $profile_photo = uniqid("user_", true) . "." . $ext;

        move_uploaded_file($_FILES['profile_photo']['tmp_name'], $upload_dir . $profile_photo);
    }

    // Update database (email cannot be changed)
    $stmt = $con->prepare("UPDATE users SET name=?, username=?, phone=?, city=?, state=?, country=?, address=?, profile_photo=? WHERE email=?");
    $stmt->bind_param("sssssssss", $name, $username, $phone, $city, $state, $country, $address, $profile_photo, $email);
    $stmt->execute();
    $stmt->close();

    // Update session
    $_SESSION['logged_in_user'] = [
        'id' => $user['id'],
        'username' => $username,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'city' => $city,
        'state' => $state,
        'country' => $country,
        'address' => $address,
        'profile_photo' => $profile_photo
    ];

    $_SESSION['profile_updated'] = "Profile successfully updated.";
    header("Location: view_profile.php");
    exit;
}

// ------------------------
// Pre-fill form values
// ------------------------
$name          = htmlspecialchars($user['name'] ?? '');
$username      = htmlspecialchars($user['username'] ?? '');
$email         = htmlspecialchars($user['email'] ?? '');
$phone         = htmlspecialchars($user['phone'] ?? '');
$city          = htmlspecialchars($user['city'] ?? '');
$state         = htmlspecialchars($user['state'] ?? '');
$country       = htmlspecialchars($user['country'] ?? '');
$address       = htmlspecialchars($user['address'] ?? '');
$profile_photo = $user['profile_photo'] ?? 'default.png';

ob_start();
?>

<div class="profile-page">
  <div class="profile-card shadow rounded">
    <div class="profile-header text-center">
      <img id="profilePreview" src="profile_photos/<?= htmlspecialchars($profile_photo) ?>" 
           alt="Profile Photo" class="profile-avatar rounded-circle" 
           width="120" height="120" style="object-fit:cover;border:4px solid #d6336c;">
      <h2 class="profile-name mt-2"><?= $name ?: $username ?></h2>
    </div>

    <form method="post" enctype="multipart/form-data" class="profile-details mt-4">
      <div class="detail-item">
        <label>Update Profile Photo</label>
        <input type="file" name="profile_photo" id="profile_photo" accept=".jpg,.jpeg,.png,.gif" class="form-control">
      </div>

      <div class="detail-item">
        <label>Full Name</label>
        <input type="text" name="name" value="<?= $name ?>" class="form-control" required>
      </div>

      <div class="detail-item">
        <label>Username</label>
        <input type="text" name="username" value="<?= $username ?>" class="form-control" required>
      </div>

      <div class="detail-item">
        <label>Email (cannot be changed)</label>
        <input type="email" name="email" value="<?= $email ?>" class="form-control" readonly>
      </div>

      <div class="detail-item">
        <label>Phone</label>
        <input type="text" name="phone" value="<?= $phone ?>" class="form-control">
      </div>

      <div class="detail-item">
        <label>City</label>
        <input type="text" name="city" value="<?= $city ?>" class="form-control">
      </div>

      <div class="detail-item">
        <label>State</label>
        <input type="text" name="state" value="<?= $state ?>" class="form-control">
      </div>

      <div class="detail-item">
        <label>Country</label>
        <input type="text" name="country" value="<?= $country ?>" class="form-control">
      </div>

      <div class="detail-item">
        <label>Address</label>
        <textarea name="address" rows="3" class="form-control"><?= $address ?></textarea>
      </div>

      <div class="profile-buttons mt-4 text-center">
        <button type="submit" class="btn btn-pink">💾 Save Changes</button>
        <a href="profile_main.php" class="btn btn-outline-pink">← Back to Profile</a>
      </div>
    </form>
  </div>
</div>

<style>
body { background: #fadee9; font-family: 'Segoe UI', sans-serif; }

.profile-page { display: flex; justify-content: center; padding: 50px 15px; }

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
}

.profile-name { color: #d6336c; font-size: 1.8rem; margin: 5px 0; }

.profile-details {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.detail-item {
  display: flex;
  flex-direction: column;
}
.detail-item label {
  font-weight: 600;
  color: #4b2a4d;
  margin-bottom: 4px;
}
.detail-item input,
.detail-item textarea {
  padding: 10px 12px;
  border-radius: 8px;
  border: 1px solid #d6336c;
  background: #fff0f6;
  font-size: 1rem;
  color: #5a2a4d;
}
.detail-item input:focus,
.detail-item textarea:focus {
  outline: none;
  border-color: #ad1457;
  box-shadow: 0 0 0 0.2rem rgba(214, 51, 108, 0.25);
}

.profile-buttons { margin-top: 20px; }
.profile-buttons .btn {
  display: inline-block;
  margin: 10px 10px;
  padding: 12px 25px;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-pink {
  background-color: #d6336c;
  color: #fff;
  border: none;
}
.btn-pink:hover {
  background-color: #ad1457;
}

.btn-outline-pink {
  border: 2px solid #d6336c;
  color: #d6336c;
}
.btn-outline-pink:hover { background-color: #d6336c; color: #fff; }

@media(max-width:576px) {
  .profile-card { padding: 20px; }
  .profile-avatar { width: 100px; height: 100px; }
  .profile-buttons .btn { width: 100%; margin: 8px 0; }
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Profile photo preview
$('#profile_photo').on('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#profilePreview').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    }
});
</script>

<?php
$Content1 = ob_get_clean();
$title_page = "<title>Edit Profile - Unique Flower Shop</title>";
include 'layout.php';
?>
