<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in'])) {
    header("Location: Login.php");
    exit();
}

// Clear the order details session
unset($_SESSION['order_id']);

// Redirect to index.php with an alert message
header("Location: index.php?message=Order placed successfully");
exit;
?>
