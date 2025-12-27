<?php
session_start();
include 'db_config.php'; // your database connection

if (!isset($_SESSION['logged_in_user']['email'])) {
    header("Location: login.php");
    exit;
}

$errors = [];
$success = "";

$email = $_SESSION['logged_in_user']['email'];

// Get current password hash from DB
$stmt = $con->prepare("SELECT password_hash FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$currentHash = $user['password_hash'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validate current password
    if (!$currentPassword) {
        $errors['current_password'] = "Please enter your current password.";
    } elseif (!password_verify($currentPassword, $currentHash)) {
        $errors['current_password'] = "Current password is incorrect.";
    }

    // Validate new password
    if (!$newPassword) {
        $errors['new_password'] = "Please enter a new password.";
    } elseif (strlen($newPassword) < 6) {
        $errors['new_password'] = "New password must be at least 6 characters.";
    }

    // Validate confirm password
    if (!$confirmPassword) {
        $errors['confirm_password'] = "Please confirm your new password.";
    } elseif ($confirmPassword !== $newPassword) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    // If no errors, update password
    if (empty($errors)) {
        $newHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $con->prepare("UPDATE users SET password_hash=? WHERE email=?");
        $stmt->bind_param("ss", $newHash, $email);
        $stmt->execute();
        $stmt->close();

        $_SESSION['logged_in_user']['password_hash'] = $newHash;
        $success = "Password successfully changed!";
    }
}

ob_start();
?>

<style>
/* Your existing CSS unchanged */
body {
  background: linear-gradient(to right, #ffeff7, #fff0f6);
  font-family: 'Open Sans', sans-serif;
  color: #5a2a4d;
}

.box-container {
  border: 1px solid #d6336c;
  background: #fff0f6;
  padding: 35px 30px;
  border-radius: 15px;
  box-shadow: 0 12px 25px rgba(214, 51, 108, 0.15);
  max-width: 500px;
  margin: 60px auto;
  position: relative;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.box-container:hover {
  transform: scale(1.02);
  box-shadow: 0 15px 30px rgba(214, 51, 108, 0.3);
}

h2.text-center {
  color: #d6336c;
  font-weight: 700;
  font-size: 2rem;
  margin-bottom: 25px;
}

.input-container {
  position: relative;
  margin-bottom: 1.5rem;
}

.form-label {
  color: #d6336c;
  font-weight: 600;
  display: block;
  margin-bottom: 0.5rem;
}

.form-control {
  border-radius: 8px;
  border: 1px solid #d6336c;
  padding-right: 2.5rem;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  color: #5a2a4d;
  font-size: 1rem;
  background-color: #fff0f6;
  outline: none;
  width: 100%;
  box-sizing: border-box;
  min-height: 2.5rem;
}

.form-control:focus {
  border-color: #ad1457;
  box-shadow: 0 0 0 0.2rem rgba(214, 51, 108, 0.25);
  background-color: #fff;
}

input.form-control[type="password"] {
  letter-spacing: 0.1em;
}

.input-icon {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 1.3rem;
  pointer-events: none;
  transition: visibility 0s linear 0.3s, opacity 0.3s ease;
  opacity: 0;
  visibility: hidden;
}

.error-icon {
  color: #d6336c;
}

.success-icon {
  color: #4caf50;
}

.invalid ~ .error-icon {
  visibility: visible;
  opacity: 1;
  transition-delay: 0s;
}

.valid ~ .success-icon {
  visibility: visible;
  opacity: 1;
  transition-delay: 0s;
}

.invalid {
  border-color: #d6336c !important;
  background-color: #fce4ec !important;
  color: #d6336c;
}

.valid {
  border-color: #4caf50 !important;
  background-color: #e8f5e9 !important;
  color: #2e7d32;
}

.error {
  color: #d6336c;
  font-size: 0.875rem;
  margin-top: 6px;
  margin-bottom: 10px;
  text-align: center;
}

.success-message {
  color: #4caf50;
  font-weight: 600;
  margin-bottom: 15px;
  text-align: center;
  font-size: 1.2rem;
}

button[type="submit"], .btn-pink {
  background-color: #d6336c;
  color: #fff;
  font-weight: 600;
  font-size: 1rem;
  padding: 12px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  width: 100%;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

button[type="submit"]:hover, .btn-pink:hover {
  background-color: #ad1457;
  transform: scale(1.03);
}

.back-link {
  margin-top: 10px;
  text-align: center;
  display: inline-block;
  width: 100%;
  color: #d6336c;
  font-weight: 600;
  text-decoration: none;
  transition: color 0.3s ease;
}

.back-link:hover {
  color: #ad1457;
  text-decoration: underline;
}

@media (max-width: 576px) {
  .box-container {
    padding: 25px 20px;
  }

  h2.text-center {
    font-size: 1.6rem;
  }
}
</style>

<div class="container">
  <div class="box-container">
    <h2 class="text-center">🔒 Change Password</h2>

    <?php if ($success): ?>
      <div class="success-message"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form id="changePasswordForm" method="post" novalidate>

      <!-- Current Password -->
      <div class="input-container">
        <label for="current_password" class="form-label">Current Password</label>
        <input
          type="password"
          name="current_password"
          id="current_password"
          class="form-control <?= isset($errors['current_password']) ? 'invalid' : (($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($errors['current_password'])) ? 'valid' : '') ?>"
          required
        >
        <i class="fas fa-times-circle input-icon error-icon" title="Invalid"></i>
        <i class="fas fa-check-circle input-icon success-icon" title="Valid"></i>
        <?php if (isset($errors['current_password'])): ?>
          <div class="error"><?= htmlspecialchars($errors['current_password']) ?></div>
        <?php endif; ?>
      </div>

      <!-- New Password -->
      <div class="input-container">
        <label for="new_password" class="form-label">New Password</label>
        <input
          type="password"
          name="new_password"
          id="new_password"
          minlength="6"
          class="form-control <?= isset($errors['new_password']) ? 'invalid' : (($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($errors['new_password'])) ? 'valid' : '') ?>"
          required
        >
        <i class="fas fa-times-circle input-icon error-icon" title="Invalid"></i>
        <i class="fas fa-check-circle input-icon success-icon" title="Valid"></i>
        <?php if (isset($errors['new_password'])): ?>
          <div class="error"><?= htmlspecialchars($errors['new_password']) ?></div>
        <?php endif; ?>
      </div>

      <!-- Confirm Password -->
      <div class="input-container">
        <label for="confirm_password" class="form-label">Confirm New Password</label>
        <input
          type="password"
          name="confirm_password"
          id="confirm_password"
          minlength="6"
          class="form-control <?= isset($errors['confirm_password']) ? 'invalid' : (($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($errors['confirm_password'])) ? 'valid' : '') ?>"
          required
        >
        <i class="fas fa-times-circle input-icon error-icon" title="Invalid"></i>
        <i class="fas fa-check-circle input-icon success-icon" title="Valid"></i>
        <?php if (isset($errors['confirm_password'])): ?>
          <div class="error"><?= htmlspecialchars($errors['confirm_password']) ?></div>
        <?php endif; ?>
      </div>

      <button type="submit">🔄 Change Password</button>
    </form>

    <a href="profile_main.php" class="back-link">← Back to Profile Management</a>
  </div>
</div>

<!-- FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<!-- jQuery & Validation plugin -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
  $("#changePasswordForm").validate({
    errorElement: "div",
    errorClass: "error",
    errorPlacement: function (error, element) {
      error.insertAfter(element);
      $(element).addClass('invalid').removeClass('valid');
    },
    success: function(label, element) {
      $(element).removeClass('invalid').addClass('valid');
    },
    highlight: function (element) {
      $(element).addClass('invalid').removeClass('valid');
    },
    unhighlight: function (element) {
      $(element).removeClass('invalid').addClass('valid');
    },
    rules: {
      current_password: { required: true },
      new_password: { required: true, minlength: 6 },
      confirm_password: { required: true, minlength: 6, equalTo: "#new_password" }
    },
    messages: {
      current_password: { required: "Please enter your current password." },
      new_password: { required: "Please enter a new password.", minlength: "New password must be at least 6 characters." },
      confirm_password: { required: "Please confirm your new password.", minlength: "Confirm password must be at least 6 characters.", equalTo: "Passwords do not match." }
    }
  });
});
</script>

<?php
$Content1 = ob_get_clean();
$title_page = "<title>Change Password - Unique Flower Shop</title>";
include 'layout.php';
?>
