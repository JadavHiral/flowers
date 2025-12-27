<?php
session_start();
include_once("db_config.php"); // Your DB connection

// ✅ Correct session variable for logged-in user
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['logged_in_user']['username'];

// Delete all items for this user from the cart
$stmt = $con->prepare("DELETE FROM add_to_cart WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();

// Redirect back to cart page
header("Location: cart_show.php");
exit;
?>
