<?php
session_start();
include_once("db_config.php");

// ✅ FIX IS HERE
$username = isset($_SESSION['logged_in_user'])
    ? $_SESSION['logged_in_user']['username']
    : 'guest';

$pid = isset($_GET['product']) ? intval($_GET['product']) : 0;
$qty = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;
if ($qty < 1) $qty = 1;

// Validate product
$stmt = $con->prepare("SELECT pid, pnm, price, img FROM product WHERE pid=? LIMIT 1");
$stmt->bind_param("i", $pid);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    exit("Product not found");
}

// Check cart
$stmt = $con->prepare("SELECT cart_id, qty FROM add_to_cart WHERE pid=? AND username=?");
$stmt->bind_param("is", $pid, $username);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {

    $row = $res->fetch_assoc();
    $newQty = $row['qty'] + $qty;

    $update = $con->prepare(
        "UPDATE add_to_cart SET qty=?, cart_date=CURDATE() WHERE cart_id=?"
    );
    $update->bind_param("ii", $newQty, $row['cart_id']);
    $update->execute();

} else {

    $insert = $con->prepare(
        "INSERT INTO add_to_cart 
        (username, pid, pnm, price, img, qty, cart_date)
        VALUES (?, ?, ?, ?, ?, ?, CURDATE())"
    );

    $insert->bind_param(
        "sisdsd",
        $username,
        $product['pid'],
        $product['pnm'],
        $product['price'],
        $product['img'],
        $qty
    );
    $insert->execute();
}

header("Location: cart_show.php");
exit;
?>
