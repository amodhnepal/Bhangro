<?php
session_start();

if(!isset($_SESSION['logged_in'])){
  header('location: Login.php');
  exit;
}
include('server/connection.php');

if (isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Retrieve order details from the order_items table based on the provided order_id
    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $order_details = $stmt->get_result();

    // Retrieve order status from the orders table
    $order_status_query = mysqli_query($conn, "SELECT order_status FROM orders WHERE order_id = '$order_id'");
    $order_status_row = mysqli_fetch_assoc($order_status_query);
    $order_status = $order_status_row['order_status'];

    // Calculate total order price  
    $order_total_price = calculateTotalOrderPrice($order_details);
} else {
    header('location:order_details.php');
}

function calculateTotalOrderPrice($order_details) {
    $total = 0;
    while ($row = mysqli_fetch_assoc($order_details)) {
        $total += $row['product_price'] * $row['product_quantity'];
    }
    return $total;
}

?>



<?php include('layouts/header.php'); ?>

<section id="order-details" class="container my-5 py-3">
    <div class="container mt-5">
        <h2 class="font-weight-bold text-center mb-4">Order Details</h2>
        <hr class="mx-auto" style="border-top: 2px solid #5cb85c;">
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-4 mx-auto">
            <thead class="thead-dark">
                <tr>
                    <th>Product</th>
                    <th>Price (Rs.)</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_details as $row) : ?>
                    <tr>
                        <td>
                            <div class="product-info d-flex align-items-center gap-5">
                                <img src="images/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>" class="product-image">
                                <div>
                                    <p class="mt-3" style="color:black"><?php echo $row['product_name']; ?></p>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $row['product_price']; ?></td>
                        <td><?php echo $row['product_quantity']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($order_status == "not paid") : ?>
        <div class="text-center mt-3">
            <form method="POST" action="payment.php">
                <input type="hidden" name="order_total_price" value="<?php echo $order_total_price; ?>" />
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                <input type="hidden" name="order_status" value="<?php echo $order_status; ?>">
                <button type="submit" name="order_pay_btn" class="btn btn-success">Pay Now</button>
            </form>
        </div>
    <?php endif; ?>
</section>

<?php include('layouts/footer.php'); ?>
