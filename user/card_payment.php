<?php
ob_start();
session_start();
require 'db_config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit;
}

// Get total and products from query string
$total = $_GET['total'] ?? 0;
$products = $_GET['products'] ?? '';
?>

<div class="container">
  <div class="payment-container">
    <h2 class="text-center">💳 Card Payment</h2>

    <form id="cardForm" method="post" action="card_process.php">
      <input type="hidden" name="selected_products" value="<?= htmlspecialchars($products) ?>">
      <input type="hidden" name="total" value="<?= htmlspecialchars($total) ?>">

      <div class="form-group">
        <label for="card_no">Card Number *</label>
        <input type="text" class="form-control" id="card_no" name="card_no" maxlength="16">
      </div>

      <div class="form-group">
        <label for="card_type">Card Type *</label>
        <select class="form-control" id="card_type" name="card_type">
          <option value="">-- Select --</option>
          <option value="Visa">Visa</option>
          <option value="MasterCard">MasterCard</option>
          <option value="RuPay">RuPay</option>
        </select>
      </div>

      <div class="form-group">
        <label for="exp_date">Expiry Date *</label>
        <input type="month" class="form-control" id="exp_date" name="exp_date">
      </div>

      <button type="submit" class="btn btn-success">Pay ₹<?= htmlspecialchars($total) ?></button>
    </form>
  </div>
</div>

<style>
body { background: #fae8f4; font-family: 'Open Sans', sans-serif; }
.payment-container { padding: 40px; margin: 80px auto; background: #fff; border-radius: 15px; border: 1px solid #f66797; max-width: 600px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
h2.text-center { text-align: center; color: #6a1b9a; margin-bottom: 30px; }
.form-group { margin-bottom: 20px; }
label { font-weight: 600; color: #6a1b9a; margin-bottom: 8px; display: block; }
.form-control, select.form-control { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ced4da; }
button.btn { width: 100%; padding: 12px; border-radius: 8px; background: #d6336c; color: #fff; font-weight: 600; border: none; cursor: pointer; }
button.btn:hover { background: #ad1457; }
.error { color: red; font-size: 0.85rem; margin-top: 5px; }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
  $("#cardForm").validate({
    rules: {
      card_no: { required: true, digits: true, minlength: 16, maxlength: 16 },
      card_type: { required: true },
      exp_date: { required: true }
    },
    messages: {
      card_no: { required: "Enter card number", digits: "Only digits allowed", minlength: "16 digits required", maxlength: "16 digits required" },
      card_type: { required: "Select card type" },
      exp_date: { required: "Enter expiry date" }
    },
    errorPlacement: function (error, element) { error.insertAfter(element); }
  });
});
</script>
<?php
$content1 = ob_get_clean();
include_once("layout.php");
?>
