<?php
session_start();
unset($_SESSION['cart']);
header("Location: cart_show.php");
exit;
?>
