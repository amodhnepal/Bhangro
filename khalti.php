    <?php
    session_start();
    include('server/connection.php');

  
    $user_id = $_SESSION['user_id'];

   
    $res = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$user_id'") or die('Query failed');
    if(mysqli_num_rows($res) > 0){
        while($rows = mysqli_fetch_assoc($res)){
            $fullname = $rows['user_name'];
            $email = $rows['user_email'];
           
        }
    }

   
    if(isset($_SESSION['order_id'])) {
        $order_id = $_SESSION['order_id'];
    
     


        $stmt = $conn->prepare("SELECT SUM(product_price * product_quantity) AS total_amount FROM order_items WHERE order_id = ?");
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $order_details = $stmt->get_result();
      

        if($order_details->num_rows > 0) {
        
            $row = $order_details->fetch_assoc();
            $grand_total = $row['total_amount'];
            echo "Total amount fetched successfully: $grand_total";
    
            $grand_total *= 100;
        } else {

            echo("NO result found");
            $grand_total = 0;
        }

      
        echo($grand_total);
        $data = array(
            // "return_url" => "http://localhost/Bhangro%20Latest/cart.php",
            "return_url" => "http://localhost/Bhangro/index.php",
            "website_url" => "http://localhost/Bhangro/index.php",
            "amount" => $grand_total,
            // "amount" => 1000,
            "purchase_order_id" => "Order01",
            "purchase_order_name" => "Test Order",
            "customer_info" => array(
                "name" => $fullname,
                "email" => $email,
                // "phone" => $phone
            ),
  
        );

        $post_data = json_encode($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Key 05991d8ce6b147e686cc115d4b396931', 
                'Content-Type: application/json',
            ),
        ));

    
        $response = curl_exec($curl);

      
        if ($response === false) {
            echo curl_error($curl);
        } else {
            $response_array = json_decode($response, true);
            if (!empty($response_array['payment_url'])) {
            
                unset($_SESSION['cart']);
                header("Location: " . $response_array['payment_url']);
                exit;
            } else {
              
                echo "Payment initiation failed or payment URL is empty.";
            }
        }

      
        curl_close($curl);

     
        echo $response;
    } else {
        die('Order ID not provided.');
    }
    ?>
