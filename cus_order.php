<?php
include('server/connection.php');
session_start();

// Check if the user is logged in
if(!isset($_SESSION['logged_in'])){
  header('location: Login.php');
  exit;
}

// Fetch orders for the logged-in user
if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];

  $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? AND order_status IN ('paid', 'cash on delivery', 'delivered')");
  $stmt->bind_param('i', $user_id);
  $stmt->execute();

  $orders = $stmt->get_result();
}
?>

<?php include('layouts/header.php'); ?>

<section id="customer-orders" class="container my-5 py-3">
  <div class="container mt-2">
    <h2 class="font-weight-bold text-center">Your Orders</h2>
    <hr class="mx-auto">
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-bordered mt-5">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Order ID</th>
          <th scope="col">Order Cost</th>
          <th scope="col">Order Status</th>
          <th scope="col">Order Date</th>
          <th scope="col">Order Details</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $orders->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['order_id']; ?></td>
          <td><?php echo $row['order_cost']; ?></td>
          <td><?php echo $row['order_status']; ?></td>
          <td><?php echo $row['order_date']; ?></td>
          <td>
            <form method="POST" action="order_details.php">
              <input type="hidden" value="<?php echo $row["order_status"] ?> " name="order_status">
              <input type="hidden" name="order_id" value="<?php echo $row["order_id"] ?>">
            <input type="submit" name="order_details_btn" value="details" class="btn order-details-btn"/>
          </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</section>

<?php include('layouts/footer.php'); ?>
