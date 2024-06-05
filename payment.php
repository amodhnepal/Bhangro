<?php
session_start();

// Check if the order_pay_btn is clicked
if(isset($_POST['order_pay_btn'])){
    $order_status = $_POST['order_status'];
    $order_total_price = $_POST['order_total_price'];
}

// Include database connection
include('server/connection.php');

// Check if the order_id session variable is set
if(isset($_SESSION['order_id'])) {
    $order_id = $_SESSION['order_id'];

    // Retrieve order details from the database based on the order ID
    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $order_details = $stmt->get_result();

    // Calculate the total amount for the order
    $grand_total = 0;
    if(mysqli_num_rows($order_details) > 0){
        while($fetch_cart = mysqli_fetch_assoc($order_details)){
            $total_price = ($fetch_cart['product_price'] * $fetch_cart['product_quantity']);
            $grand_total += $total_price;
        }
        // Convert amount to paisa (multiply by 100)
        $grand_total *= 100;
    }

    // Prepare data for Khalti payment API
    $data = array(
        "return_url" => "http://localhost/Bhangro/cart.php",
        "website_url" => "http://localhost/Bhangro/index.php",
        "amount" => $grand_total, // Use the value of $grand_total here
        "purchase_order_id" => "Order01",
        "purchase_order_name" => "Test Order",
        // Customer info can be added here if necessary
    );

    $post_data = json_encode($data);

    // Initialize cURL session for Khalti payment API
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://khalti.com/api/v2/payment/initiate/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $post_data,
        CURLOPT_HTTPHEADER => array(
            'Authorization: 05991d8ce6b147e686cc115d4b396931', // Replace with your Khalti secret key
            'Content-Type: application/json',
        ),
    ));

    // Execute cURL request
    $response = curl_exec($curl);

    // Check for cURL errors
    if(curl_errno($curl)) {
        echo 'Error: ' . curl_error($curl);
    }

    // Close cURL session
    curl_close($curl);

    // Handle response from Khalti payment API
    $response_array = json_decode($response, true);
    echo($response_array);
    if (!empty($response_array['payment_url'])) {
        // Redirect to Khalti payment page
        header("Location: " . $response_array['payment_url']);
        exit;
    } else {
        // Handle case where payment_url is empty
        echo "Payment initiation failed or payment URL is empty.";
    }
} else {
    die('Order ID not provided.');
}
?>

<?php include('layouts/header.php'); ?>

<!-- Payment-->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Payment</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container text-center">
        <p><?php if(isset($_GET['order_status'])){echo  $_GET['order_status'];} ?></p>
        <p>Total payment: Rs<?php if(isset($_SESSION['total']) && $_SESSION['total']){echo $_SESSION['total']; }   ?></p>

        <?php if(isset($_POST['order_status']) && $_POST['order_status'] == "not paid" ) { ?>
            <input class="btn btn-primary" value="Pay Now"  type="submit"/>
        <?php } ?>
        <form action="cash_on_delivery.php">
            <input class="btn btn-primary"  value="Cash on Delivery"  type="submit"/>
        </form>
        <form action="">
        <?php if(isset($_SESSION['total']) && $_SESSION['total'] != 0 ) { ?>
                <input class="btn btn-primary" value="Pay Now" type="submit"/>
            <?php } else { ?>
                <p>You don't have an order</p>
            <?php } ?>
        </form>
    </div>
</section>

<?php include('layouts/footer.php'); ?>
