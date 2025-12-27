<?php
session_start();
include_once("db_config.php");

// Make sure user is logged in
if (!isset($_SESSION['logged_in_user'])) {
    http_response_code(401);
    echo "Unauthorized";
    exit;
}

$username = $_SESSION['logged_in_user']['username'];

// Get cart_id from request
$cart_id = isset($_GET['cart_id']) ? intval($_GET['cart_id']) : 0;

if ($cart_id > 0) {
    // Delete only if the cart item belongs to this user
    $stmt = $con->prepare("DELETE FROM add_to_cart WHERE cart_id=? AND username=?");
    $stmt->bind_param("is", $cart_id, $username);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Success";
    } else {
        http_response_code(400);
        echo "Item not found or not yours";
    }
} else {
    http_response_code(400);
    echo "Invalid cart ID";
}
?>
