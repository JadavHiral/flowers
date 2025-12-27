<?php
ob_start();
session_start();
require 'db_config.php';

// Redirect if not logged in
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['logged_in_user'];
$username = $user['username'];

// Get selected products from POST
$selected_ids = isset($_POST['selected_products']) ? $_POST['selected_products'] : [];

if (empty($selected_ids)) {
    $_SESSION['order_error'] = "Please select at least one product to place an order.";
    header("Location: cart_show.php");
    exit;
}

// Ensure IDs are integers
$selected_ids = array_map('intval', $selected_ids);

// Prepare placeholders for SQL
$placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
$types = str_repeat('i', count($selected_ids)) . 's'; // integers + username
$params = array_merge($selected_ids, [$username]);

$sql = "SELECT * FROM add_to_cart WHERE cart_id IN ($placeholders) AND username=?";
$stmt = $con->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$cartItems = $result->fetch_all(MYSQLI_ASSOC);

if (empty($cartItems)) {
    $_SESSION['order_error'] = "Selected products are not available in your cart.";
    header("Location: cart_show.php");
    exit;
}

// Calculate grand total for selected items
$grandTotal = 0;
foreach ($cartItems as $item) {
    $grandTotal += $item['price'] * $item['qty'];
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

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
    max-width: 700px;
    margin: 3rem auto;
}

.box-container h4 {
    color: #d6336c;
    text-align: center;
    margin-bottom: 2rem;
}

.input-container {
    position: relative;
    margin-bottom: 1.5rem;
}

label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
}

input.form-control,
textarea.form-control,
select.form-select {
    width: 100%;
    border-radius: 8px;
    border: 1px solid #d6336c;
    padding: 0.5rem 2.5rem 0.5rem 0.75rem;
    font-size: 1rem;
    background-color: #fff0f6;
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.cart-table th,
.cart-table td {
    border: 1px solid #d6336c;
    padding: 8px;
    text-align: center;
}

.cart-table img {
    max-width: 70px;
    border-radius: 6px;
}

.grand-total {
    font-weight: bold;
    font-size: 1.2rem;
    text-align: right;
    margin-bottom: 20px;
    color: #880e4f;
}

/* Buttons styling */
.text-center .btn {
    padding: 0.75rem 2rem;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    width: 150px;
    margin: 5px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.text-center .btn-success {
    background-color: #d6336c;
    color: #fff;
}

.text-center .btn-success:hover {
    background-color: #ad1457;
    transform: scale(1.03);
}

.text-center .btn-danger {
    background-color: #aaa;
    color: white;
}

.text-center .btn-danger:hover {
    background-color: #888;
    transform: scale(1.03);
}
</style>

<div class="container">

<?php if (!empty($_SESSION['order_success'])): ?>
    <script>
        alert("<?= addslashes($_SESSION['order_success']) ?>"); // Show JS alert
        setTimeout(() => { window.location.href = 'product.php'; }, 2000);
    </script>
    <?php unset($_SESSION['order_success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['order_error'])): ?>
    <div style="padding: 15px; margin-bottom: 20px; background: #f8d7da; color: #721c24; border-radius: 8px; border: 1px solid #f5c6cb; text-align: center;">
      <?= htmlspecialchars($_SESSION['order_error']) ?>
    </div>
    <?php unset($_SESSION['order_error']); ?>
<?php endif; ?>

<?php if (!empty($cartItems)): ?>
<div class="box-container">
    <h4>🛒 Cart Review</h4>
    <table class="cart-table">
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Price (₹)</th>
            <th>Qty</th>
            <th>Total (₹)</th>
        </tr>
        <?php foreach ($cartItems as $item):
            $itemTotal = $item['price'] * $item['qty'];
        ?>
        <tr>
            <td><img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['pnm']) ?>"></td>
            <td><?= htmlspecialchars($item['pnm']) ?></td>
            <td><?= number_format($item['price'], 2) ?></td>
            <td><?= (int) $item['qty'] ?></td>
            <td><?= number_format($itemTotal, 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="grand-total">Grand Total: ₹<?= number_format($grandTotal, 2) ?></div>

    <form id="orderForm" action="order_process.php" method="post" novalidate>
        <input type="hidden" name="selected_products" value="<?= implode(',', $selected_ids) ?>">
        
        <div class="input-container">
          <label for="name">Full Name *</label>
          <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" readonly/>
        </div>

        <div class="input-container">
          <label for="email">Email *</label>
          <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly />
        </div>

        <div class="input-container">
          <label for="mobile">Mobile *</label>
          <input type="text" name="mobile" id="mobile" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" />
        </div>

        <div class="input-container">
          <label for="address">Shipping Address *</label>
          <textarea name="address" id="address" rows="3" class="form-control"><?= htmlspecialchars($user['address']) ?></textarea>
        </div>

        <div class="input-container">
          <label for="city">City *</label>
          <input type="text" name="city" id="city" class="form-control" value="<?= htmlspecialchars($user['city']) ?>" />
        </div>

        <div class="input-container">
          <label for="state">State *</label>
          <input type="text" name="state" id="state" class="form-control" value="<?= htmlspecialchars($user['state']) ?>" />
        </div>

        <div class="input-container">
          <label for="country">Country *</label>
          <input type="text" name="country" id="country" class="form-control" value="<?= htmlspecialchars($user['country']) ?>" />
        </div>

        <div class="input-container">
          <label for="payment">Payment Method *</label>
          <select name="payment" id="payment" class="form-select">
            <option value="">-- Select --</option>
            <option value="cod">Cash on Delivery</option>
            <option value="online">Online Payment</option>
          </select>
        </div>

        <div class="input-container">
          <label for="total">Total Amount (₹)</label>
          <input type="text" name="total" id="total" class="form-control" value="<?= number_format($grandTotal, 2) ?>" readonly />
        </div>

        <div class="text-center mt-4">
          <button type="submit" class="btn btn-success">📦 Place Order</button>
          <a href="cart_show.php" class="btn btn-danger">❌ Cancel Order</a>
        </div>
    </form>
</div>

<?php else: ?>
<div class="box-container text-center">
    <h4>Your selected cart items are empty 😞</h4>
    <a href="cart_show.php" class="btn btn-success" style="margin-top:15px;">🛍 Back to Cart</a>
</div>
<?php endif; ?>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
$(document).ready(function () {
    $("#orderForm").validate({
        rules: {
            name: { required: true, minlength: 3 },
            email: { required: true, email: true },
            mobile: { required: true, digits: true, minlength: 10, maxlength: 10 },
            address: { required: true, minlength: 10 },
            city: { required: true },
            state: { required: true },
            country: { required: true },
            payment: { required: true }
        },
        highlight: function (element) {
            $(element).addClass('invalid').removeClass('valid');
        },
        unhighlight: function (element) {
            $(element).addClass('valid').removeClass('invalid');
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        }
    });
});
</script>

<?php
$Content1 = ob_get_clean();
include_once("layout.php");
?>
