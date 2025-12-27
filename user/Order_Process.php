<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['logged_in_user'];
$username = $user['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect POST data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $country = $_POST['country'] ?? '';
    $payment = $_POST['payment'] ?? '';
    $total = $_POST['total'] ?? 0;
    $selected_ids = $_POST['selected_products'] ?? [];

    if (empty($selected_ids)) {
        $_SESSION['order_error'] = "No products selected for order!";
        header("Location: cart_show.php");
        exit;
    }

    // Fetch selected cart items
    $placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
    $types = str_repeat('i', count($selected_ids));
    $sql = "SELECT * FROM add_to_cart WHERE cart_id IN ($placeholders) AND username=?";
    $stmt = $con->prepare($sql);

    // Bind parameters dynamically
    $params = array_merge($selected_ids, [$username]);
    $refs = [];
    foreach ($params as $key => $value) {
        $refs[$key] = &$params[$key]; // bind_param needs references
    }
    array_unshift($refs, $types . 's'); // types string + 's' for username
    call_user_func_array([$stmt, 'bind_param'], $refs);

    $stmt->execute();
    $result = $stmt->get_result();
    $cartItems = $result->fetch_all(MYSQLI_ASSOC);

    if (empty($cartItems)) {
        $_SESSION['order_error'] = "Selected products not found in cart!";
        header("Location: cart_show.php");
        exit;
    }

    // Insert shipping info
    $stmt = $con->prepare("INSERT INTO shipping (name, address, city, state, country, phno, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssis", $name, $address, $city, $state, $country, $mobile, $email);
    $stmt->execute();
    $shipping_id = $stmt->insert_id;

    // Insert order
    $stmt = $con->prepare("INSERT INTO orders (username, shipping_id, total_amount, payment_method) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sids", $username, $shipping_id, $total, $payment);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Delete only selected items from cart
    $placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
    $sql = "DELETE FROM add_to_cart WHERE cart_id IN ($placeholders) AND username=?";
    $stmt = $con->prepare($sql);

    $params = array_merge($selected_ids, [$username]);
    $refs = [];
    foreach ($params as $key => $value) {
        $refs[$key] = &$params[$key];
    }
    array_unshift($refs, str_repeat('i', count($selected_ids)) . 's');
    call_user_func_array([$stmt, 'bind_param'], $refs);
    $stmt->execute();

    $_SESSION['order_success'] = "Your order has been placed successfully! 🎉";
    header("Location: order.php");
    exit;
}
?>
