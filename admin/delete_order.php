<?php
include('header.php');

if(isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Prepare and execute the SQL query to delete the order
    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    
    if($stmt->execute()) {
        // Order deleted successfully
        header('location: index.php?order_deleted=Order deleted successfully');
        exit();
    } else {
        // Failed to delete order
        header('location: orders.php?order_delete_failed=Failed to delete order');
        exit();
    }
} else {
    // Redirect to orders page if order ID is not provided
    header('location: ./index.php');
    exit();
}
?>