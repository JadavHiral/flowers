<?php
session_start();
include_once("db_config.php"); // DB connection

// Check if user is logged in
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['logged_in_user']['username'];

// Delete all items for this user from the cart table
$stmt = $con->prepare("DELETE FROM add_to_cart WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();

// Clear session cart array
unset($_SESSION['cart']);

// Set a flash message to show on order.php
$_SESSION['order_error'] = "Your cart has been cleared successfully.";

// Redirect back to order.php
header("Location: order.php");
exit;
?>
