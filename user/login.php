<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
  ob_start();
}

require 'db_config.php'; // your database connection

// Handle login form POST submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $remember = $_POST['remember'] ?? '';

  // Fetch user by email
  $stmt = $con->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user) {
    // Check password
    if (password_verify($password, $user['password_hash'])) {
      // Check if email is verified
      if ($user['verified'] == 0) {
        $error = "❌ Please verify your email before logging in.";
      } else {
        $_SESSION['logged_in_user'] = $user;

        // Remember Me
        if ($remember === 'on') {
          setcookie("remember_email", $email, time() + (7 * 24 * 60 * 60));
        } else {
          setcookie("remember_email", "", time() - 3600);
        }

        header("Location: products.php");
        exit;
      }
    } else {
      $error = "❌ Incorrect password.";
    }
  } else {
    $error = "❌ Email not registered.";
  }
}

$remembered_email = $_COOKIE['remember_email'] ?? '';
?>

<div class="container">
  <div class="box-container">
    <h2 class="text-center mb-4">🔐 Login</h2>

    <?php if (!empty($error))
      echo "<div class='error'>{$error}</div>"; ?>

    <form id="loginForm" action="login.php" method="post" novalidate>
      <div class="input-container">
        <label for="email" class="form-label">Email *</label>
        <input type="email" class="form-control" id="email" name="email"
          value="<?= htmlspecialchars($remembered_email) ?>" />
        <i class="fas fa-times-circle input-icon error-icon"></i>
        <i class="fas fa-check-circle input-icon success-icon"></i>
      </div>

      <div class="input-container">
        <label for="password" class="form-label">Password *</label>
        <input type="password" class="form-control" id="password" name="password" />
        <i class="fas fa-times-circle input-icon error-icon"></i>
        <i class="fas fa-check-circle input-icon success-icon"></i>
      </div>

      <div class="mb-3 form-check d-flex justify-content-between align-items-center">
        <div>
          <input type="checkbox" class="form-check-input" id="remember" name="remember">
          <label class="form-check-label" for="remember">Remember Me</label>
        </div>
        <div>
          <a href="resetPassword.php" class="forgot-link">Forgot Password?</a>
        </div>
      </div>

      <button type="submit">Login</button>

      <p>Don't have an account? <a href="register.php">Register now</a></p>
    </form>
  </div>
</div>

<!-- 🌸 CSS Styles -->
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

  .invalid~.error-icon {
    visibility: visible;
    opacity: 1;
    transition-delay: 0s;
  }

  .valid~.success-icon {
    visibility: visible;
    opacity: 1;
    transition-delay: 0s;
  }

  .valid {
    border-color: #4caf50 !important;
    background-color: #e8f5e9 !important;
  }

  .invalid {
    border-color: #d6336c !important;
    background-color: #fce4ec !important;
  }

  .error {
    color: #d6336c;
    font-size: 0.875rem;
    margin-top: 6px;
    margin-bottom: 10px;
    text-align: left;
  }

  button[type="submit"] {
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

  button[type="submit"]:hover {
    background-color: #ad1457;
    transform: scale(1.03);
  }

  .box-container p {
    font-size: 0.95rem;
    margin-top: 20px;
    text-align: center;
  }

  .box-container a {
    color: #d6336c;
    text-decoration: none;
    font-weight: 500;
  }

  .box-container a:hover {
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

<!-- 🌸 Scripts & Validation -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
  $(document).ready(function () {
    $("#loginForm").validate({
      errorElement: "div",
      errorClass: "error",
      errorPlacement: function (error, element) {
        error.insertAfter(element);
        element.addClass('invalid').removeClass('valid');
      },
      success: function (label, element) {
        $(element).removeClass('invalid').addClass('valid');
      },
      highlight: function (element) {
        $(element).addClass('invalid').removeClass('valid');
      },
      unhighlight: function (element) {
        $(element).removeClass('invalid').addClass('valid');
      },
      rules: {
        email: { required: true, email: true },
        password: { required: true, minlength: 6 }
      },
      messages: {
        email: "Please enter a valid email address.",
        password: "Password must be at least 6 characters long."
      }
    });
  });
</script>

<?php
$Content1 = ob_get_clean();
include 'layout.php';
?>
