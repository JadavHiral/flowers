<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'db_config.php';

if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['logged_in_user'];
$username = $user['username'];

$message = '';
$continueBtn = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $card_no = $_POST['card_no'] ?? '';
    $card_type = $_POST['card_type'] ?? '';
    $exp_date = $_POST['exp_date'] ?? '';
    $total = $_POST['total'] ?? 0;
    $products = $_POST['selected_products'] ?? '';

    if (empty($products)) {
        $_SESSION['order_error'] = "No products selected for payment!";
        header("Location: cart_show.php");
        exit;
    }

    $selected_ids = array_map('intval', explode(',', $products));

    // Insert payment
    $stmt = $con->prepare("INSERT INTO payment (card_no, card_type, exp_date, username, amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $card_no, $card_type, $exp_date, $username, $total);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Delete purchased items from cart
        $placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
        $types = str_repeat('i', count($selected_ids));
        $sql = "DELETE FROM add_to_cart WHERE cart_id IN ($placeholders) AND username=?";
        $stmt_del = $con->prepare($sql);
        $params = array_merge($selected_ids, [$username]);
        $refs = [];
        foreach ($params as $key => $value) { $refs[$key] = &$params[$key]; }
        array_unshift($refs, $types . 's');
        call_user_func_array([$stmt_del, 'bind_param'], $refs);
        $stmt_del->execute();

        $message = "✅ Payment Successful! ₹$total has been paid successfully using $card_type.";
        $continueBtn = '<a href="product.php" class="btn btn-success" style="padding:12px 25px; border-radius:8px; text-decoration:none; font-weight:600;">Continue Shopping</a>';
    } else {
        $message = "❌ Payment Failed! Please try again.";
        $continueBtn = '<a href="card_payment.php?total='.htmlspecialchars($total).'&products='.htmlspecialchars($products).'" class="btn btn-danger" style="padding:12px 25px; border-radius:8px; text-decoration:none; font-weight:600;">Try Again</a>';
    }
}
?>

<div class="container" style="text-align:center; margin-top:100px; font-family:Open Sans;">
    <h2 style="color:#6a1b9a;"><?= $message ?></h2>
    <div style="margin-top:20px;"><?= $continueBtn ?></div>
</div>

<?php
$content1 = ob_get_clean(); // capture everything in $content1
$title_page = "<title>Card Payment - Unique Flower Shop</title>";
include 'layout.php';
?>
