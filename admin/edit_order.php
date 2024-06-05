<?php include('header.php');?>

<style>
    p{margin: 0;}

    .text-cen{
        text-align: center;
    }

    .btn{
        margin-top: 20px;
    }

    .container{
        justify-content: center;
    }
</style>

<?php


if(isset($_GET['order_id'])){
    $order_id = $_GET['order_id'];
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        echo "Order not found.";
        exit;
    }
} elseif(isset($_POST['edit_btn'])) {
    $order_status = $_POST['order_status'];
    $order_id = $_POST['order_id'];

    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $order_status, $order_id);

    if($stmt->execute()){
        header('location:index.php?order_updated=order updated successfully');
    } else {
        header('location:products.php?order_failed=Error Please try again.');
    }
} else {
    header('location:index.php');
    exit;
}
?>



<?php include('sidemenu.php');?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 d-flex justify-content-center align-items-center mt-5">
    <div class="container" style="margin: auto; margin-top: 130px; max-width:500px">
        <div class=" pt-3 pb-2">
            <h2 class="text-cen">Edit Order</h2>
        </div>
        <div class="row">
                <form id="edit-form" method="POST" action="edit_order.php">
                    <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
                    <div class="form-group">
                        <label>Order ID</label>
                        <p class=""><?php echo $order['order_id']; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Order Price</label>
                        <p class=""><?php echo $order['order_cost']; ?></p>
                    </div>
                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                    <div class="form-group">
                        <label>Order Status</label>
                        <select class="form-control" required name="order_status">
                            <option value="not paid" <?php if($order['order_status'] == 'not paid'){echo "selected";} ?>>Not Paid</option>
                            <option value="paid" <?php if($order['order_status'] == 'paid'){echo "selected";} ?>>Paid</option>
                            <option value="shipped" <?php if($order['order_status'] == 'shipped'){echo "selected";} ?>>Shipped</option>
                            <option value="delivered" <?php if($order['order_status'] == 'delivered'){echo "selected";} ?>>Delivered</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Order Date</label>
                        <p class=""><?php echo $order['order_date']; ?></p>
                    </div>
                    <div class="flex">
                        <input type="submit" class="btn" style="background-color:green; color:white" name="edit_btn" value="Edit"/>
                    </div>
                </form>
          
        </div>
    </div>
</main>


