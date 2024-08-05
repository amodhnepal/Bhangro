    <?php
    session_start();
    include('server/connection.php');

    if(!isset($_SESSION['logged_in'])){
        header('location: Login.php');
        exit;
    } else if(isset($_POST['order']) && $_POST['order']==='place_order'){
            // 1. Get user info and store it in the database
          
            $phone=$_POST['phone'];
            $address=$_POST['address'];
            $order_cost=$_SESSION['total'];
            $order_status ="not paid";
            $user_id =$_SESSION['user_id'];
            $order_date = date("Y-m-d H:i:s");

            $stmt=$conn->prepare("INSERT INTO orders (order_cost,order_status,user_id,user_phone,user_address,order_date) VALUES(?,?,?,?,?,?)");
            $stmt->bind_param('isisss',$order_cost,$order_status,$user_id,$phone,$address,$order_date);
            $stmt_status=$stmt->execute();
            if(!$stmt_status) {
                header('location:index.php');
                exit;
            }

            // 2. Issue order and store order information in the database
            $order_id=$stmt->insert_id;

            // 3. Get products from cart (from session)
            foreach ($_SESSION['cart'] as $key => $value) {
                $product=$_SESSION['cart'][$key];
                $product_id=$product['product_id'];
                $product_name=$product['product_name'];
                $product_image=$product['product_image'];
                $product_price=$product['product_price'];
                $product_quantity=$product['product_quantity'];

                // Store each single item in the order_items database
                $stmt1 = $conn->prepare("INSERT INTO order_items (order_id,product_id,product_name,product_image,product_price,product_quantity,user_id,order_date) VALUES(?,?,?,?,?,?,?,?)");
                $stmt1->bind_param('iissiiis', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);
                $stmt1->execute();

                $stmt2 = $conn->prepare("UPDATE products SET stock = stock - ? WHERE product_id = ?");

// Bind the parameters to the SQL query
$stmt2->bind_param("ii", $product_quantity, $product_id);

// Execute the statement
$stmt2->execute();
            }

            $_SESSION['order_id'] = $order_id;

            // 5. Redirect to the payment page with the correct order_id parameter
            header("Location: khalti.php?order_id=$order_id");
            exit;
        } else if(isset($_POST['order']) && $_POST['order']==='cod'){
            // Handling the cash on delivery option
        
            // Get user info
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $order_cost = $_SESSION['total'];
            $order_status = "Cash on Delivery";
            $user_id = $_SESSION['user_id'];
            $order_date = date("Y-m-d H:i:s");
        
            // Insert order into the orders table
            $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_address, order_date) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('isisss', $order_cost, $order_status, $user_id, $phone, $address, $order_date);
            $stmt_status = $stmt->execute();
            if(!$stmt_status) {
                header('location: index.php');
                exit;
            }
        
            // Get the order ID
            $order_id = $stmt->insert_id;
        
            // Insert order items into the order_items table
            foreach ($_SESSION['cart'] as $key => $value) {
                $product = $_SESSION['cart'][$key];
                $product_id = $product['product_id'];
                $product_name = $product['product_name'];
                $product_image = $product['product_image'];
                $product_price = $product['product_price'];
                $product_quantity = $product['product_quantity'];
        
                // Store each single item in the order_items database
                $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt1->bind_param('iissiiis', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);
                $stmt1->execute();

                // Prepare the SQL statement
            $stmt2 = $conn->prepare("UPDATE products SET stock = stock - ? WHERE product_id = ?");

        // Bind the parameters to the SQL query
            $stmt2->bind_param("ii", $product_quantity, $product_id);

// Execute the statement
            $stmt2->execute();
            }

            // Store order details in the session
            $_SESSION['order_id'] = $order_id;
            
            unset($_SESSION['cart']);
            ?>
    <script type="text/javascript">
        alert("Your order has been placed successfully!");
        setTimeout(function() {
            window.location.href = "http://localhost/Bhangro/index.php";
        }, 1000); // Delay of 2 seconds
    </script>
    <?php
            
            exit;
        } 

    ?>

