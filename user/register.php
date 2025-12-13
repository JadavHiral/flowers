<?php
session_start();
ob_start();
require 'db_config.php';  // database connection
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username         = trim($_POST['username']);
    $name             = trim($_POST['name']);
    $email            = trim($_POST['email']);
    $phone            = trim($_POST['phone']);
    $city             = trim($_POST['city']);
    $state            = trim($_POST['state']);
    $country          = trim($_POST['country']);
    $address          = trim($_POST['address']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $profile_photo    = $_FILES['profile_photo'];

    // Validation
    if (empty($username) || empty($name) || empty($email) || empty($phone) || empty($city) ||
        empty($state) || empty($country) || empty($address) || empty($password)) {
      //  $error = "Please fill all required fields.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error = "Phone must be 10 digits.";
    } else {

        // Photo upload
        $profile_photo_name = null;
        if ($profile_photo && $profile_photo['error'] === 0) {
            $upload_dir = "profile_photos/";
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

            $ext = pathinfo($profile_photo['name'], PATHINFO_EXTENSION);
            $profile_photo_name = uniqid("user_", true) . "." . $ext;
            move_uploaded_file($profile_photo["tmp_name"], $upload_dir . $profile_photo_name);
        }

        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Generate verification token
        $token = bin2hex(random_bytes(16));

        // Insert into DB
        $verified = 0; // must be a variable

$sql = "INSERT INTO users (username, name, email, phone, city, state, country, address, password_hash, profile_photo, verified, verification_token)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $con->prepare($sql);

$stmt->bind_param(
    "ssssssssssis",
    $username,
    $name,
    $email,
    $phone,
    $city,
    $state,
    $country,
    $address,
    $password_hash,
    $profile_photo_name,
    $verified,  // <-- use variable, not literal
    $token
);


        if ($stmt->execute()) {

            // Send verification email
            $verify_link = "http://localhost/flowerdemo/verify.php?token=$token";

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'er.jagrutisagathiya@gmail.com';       // Replace with your Gmail
                $mail->Password   = 'adcq yjvn yple mbgw';  // Replace with App Password
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('your_email@gmail.com', 'Flower Shop');
                $mail->addAddress($email, $name);

                $mail->isHTML(true);
                $mail->Subject = 'Verify Your Email';
                /*$mail->Body    = "Hello $name,<br><br>Click the link below to verify your account:<br>
                                  <a href='$verify_link'>$verify_link</a><br><br>Thank you!";*/

                $mail->isHTML(true);
$mail->Subject = 'Verify Your Email';
$mail->Body = '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify Your Email</title>
</head>
<body style="margin:0; padding:0; background-color:#fdf6e3; font-family:Arial, sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fdf6e3; padding:40px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff; border-radius:12px; box-shadow:0 4px 8px rgba(0,0,0,0.1); overflow:hidden;">
          <tr>
            <td align="center" style="background-color:#0d9488; padding:20px;">
              <h2 style="color:#ffffff; margin:0;">Verify Your Email</h2>
            </td>
          </tr>
          <tr>
            <td align="center" style="padding:40px 20px;">
              <p style="font-size:16px; color:#333; margin-bottom:30px;">
                Hello ' . htmlspecialchars($name) . ',<br>
                Please verify your email address by clicking the button below.
              </p>
              <a href="' . $verify_link . '" 
                 style="display:inline-block; background-color:#facc15; color:#0d9488; text-decoration:none; 
                        font-size:16px; font-weight:bold; padding:14px 30px; border-radius:8px;">
                 Verify Email
              </a>
              <p style="font-size:14px; color:#555; margin-top:20px;">
                If the button does not work, copy and paste the following link into your browser:<br>
                <a href="' . $verify_link . '" style="color:#0d9488;">' . $verify_link . '</a>
              </p>
            </td>
          </tr>
          <tr>
            <td align="center" style="background-color:#f9fafb; padding:15px; font-size:12px; color:#666;">
              © 2025 Flower Shop. All rights reserved.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

</body>
</html>
';


                $mail->send();
                $_SESSION['success'] = "Registration successful! Check your email to verify.";
                header("Location: login.php");
                exit;

            } catch (Exception $e) {
                $error = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        } else {
            $error = "Email or Username already exists.";
        }







    }
}
?>

<!-- 🌸 CSS Styling -->
<style>
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
textarea.form-control {
  min-height: 100px;
  padding-top: 0.6rem;
  padding-bottom: 0.6rem;
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
.error-icon { color: #d6336c; }
.success-icon { color: #4caf50; }
.invalid ~ .error-icon { visibility: visible; opacity: 1; transition-delay: 0s; }
.valid ~ .success-icon { visibility: visible; opacity: 1; transition-delay: 0s; }
.valid { border-color: #4caf50 !important; background-color: #e8f5e9 !important; }
.invalid { border-color: #d6336c !important; background-color: #fce4ec !important; }
.error { color: #d6336c; font-size: 0.875rem; margin-top: 6px; margin-bottom: 10px; text-align: left; }
button[type="submit"] { background-color: #d6336c; color: #fff; font-weight: 600; font-size: 1rem; padding: 12px; border-radius: 8px; border: none; cursor: pointer; width: 100%; transition: background-color 0.3s ease, transform 0.2s ease; }
button[type="submit"]:hover { background-color: #ad1457; transform: scale(1.03); }
.box-container p { font-size: 0.95rem; margin-top: 20px; text-align: center; }
.box-container a { color: #d6336c; text-decoration: none; font-weight: 500; }
.box-container a:hover { text-decoration: underline; }
@media (max-width: 576px) {
  .box-container { padding: 25px 20px; }
  h2.text-center { font-size: 1.6rem; }
}
</style>

<!-- 🌸 HTML Form -->
<div class="container">
  <div class="box-container">
    <h2 class="text-center mb-4">📝 Register</h2>

    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form id="registerForm" method="post" action="register.php" enctype="multipart/form-data" novalidate>
      <?php
      $fields = [
        'username' => 'Username',
        'name' => 'Full Name',
        'email' => 'Email',
        'phone' => 'Phone Number',
        'city' => 'City',
        'state' => 'State',
        'country' => 'Country',
        'address' => 'Address'
      ];
      foreach ($fields as $field => $label): ?>
        <div class="input-container">
          <label for="<?= $field ?>" class="form-label"><?= $label ?> *</label>
          <?php if ($field === 'address'): ?>
            <textarea class="form-control" id="<?= $field ?>" name="<?= $field ?>" rows="3"><?= htmlspecialchars($_POST[$field] ?? '') ?></textarea>
          <?php else: ?>
            <input type="text" class="form-control" id="<?= $field ?>" name="<?= $field ?>" value="<?= htmlspecialchars($_POST[$field] ?? '') ?>" />
          <?php endif; ?>
          <i class="fas fa-times-circle input-icon error-icon"></i>
          <i class="fas fa-check-circle input-icon success-icon"></i>
        </div>
      <?php endforeach; ?>

      <div class="input-container">
        <label for="profile_photo" class="form-label">Profile Photo</label>
        <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*" />
        <i class="fas fa-times-circle input-icon error-icon"></i>
        <i class="fas fa-check-circle input-icon success-icon"></i>
      </div>

      <div class="input-container">
        <label for="password" class="form-label">Password *</label>
        <input type="password" class="form-control" id="password" name="password" />
        <i class="fas fa-times-circle input-icon error-icon"></i>
        <i class="fas fa-check-circle input-icon success-icon"></i>
      </div>

      <div class="input-container">
        <label for="confirm_password" class="form-label">Confirm Password *</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" />
        <i class="fas fa-times-circle input-icon error-icon"></i>
        <i class="fas fa-check-circle input-icon success-icon"></i>
      </div>

      <button type="submit">Register</button>
      <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>
  </div>
</div>

<!-- 🌸 JS + Validation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<script>
$.validator.addMethod("phoneno", function(phone_number, element) {
  return this.optional(element) || /^\d{10}$/.test(phone_number);
}, "Please enter a 10-digit phone number");

$(document).ready(function () {
  $("#registerForm").validate({
    errorElement: "div",
    errorClass: "error",
    errorPlacement: function (error, element) {
      error.insertAfter(element);
      element.addClass('invalid').removeClass('valid');
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
      username: { required: true, minlength: 3 },
      name: { required: true, minlength: 3 },
      email: { required: true, email: true },
      phone: { required: true, phoneno: true },
      city: { required: true },
      state: { required: true },
      country: { required: true },
      address: { required: true },
      profile_photo: { required: true, extension: "jpg|jpeg|png|gif" }, 
      password: { required: true, minlength: 6 },
      confirm_password: { required: true, equalTo: "#password" }
    },
    messages: {
      username: "Username must be at least 3 characters",
      name: "Name must be at least 3 characters",
      email: "Please enter a valid email address",
      phone: "Enter a valid 10-digit phone number",
      city: "Enter your city",
      state: "Enter your state",
      country: "Enter your country",
      address: "Enter your address",
       profile_photo: "Please upload a profile photo (jpg, jpeg, png, gif)", // ✅ added
      password: { required: "Enter your password", minlength: "Password must be at least 6 characters" },
      confirm_password: { required: "Please confirm your password", equalTo: "Passwords do not match" }
    }
  });
});
// ✅ Trigger validation for file input on change
$('#profile_photo').on('change', function() {
    $(this).valid();  // runs validation immediately
});

</script>
<?php
$Content1 = ob_get_clean();
$title_page = "<title>About Us - Unique Flower Shop</title>";
include 'layout.php';
?>
