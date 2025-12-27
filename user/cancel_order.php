<?php
session_start();
require 'db_config.php';

// Check login
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['logged_in_user']['username'];

// Validate order_id
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    header("Location: order_history.php");
    exit;
}

$order_id = (int) $_GET['order_id'];

// Update order status (only if it belongs to user and is pending)
$stmt = $con->prepare("
    UPDATE orders 
    SET order_status = 'cancelled' 
    WHERE o_id = ? AND username = ? AND order_status = 'pending'
");
$stmt->bind_param("is", $order_id, $username);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $_SESSION['order_success'] = "Order #$order_id has been cancelled successfully.";
} else {
    $_SESSION['order_error'] = "Order cannot be cancelled or already processed.";
}

header("Location: order_history.php");
exit;
?>
