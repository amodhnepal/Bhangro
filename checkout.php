  <?php include('server/connection.php') ?>
<?php
session_start();

 include('server/connection.php') ;

if (!isset($_SESSION['logged_in'])) {
    header("Location: Login.php");
    exit();
}






?>



<?php include('layouts/header.php'); ?>

      <!-- Checkout -->
      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Check Out</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <!-- Form -->
            <form id="checkout-form" action="place_order.php" method="POST" >
              <p class="text-center" style="color:red" >
              <?php if(isset($_GET['message'])){ echo $_GET['message']; }  ?></p>
              <?php if(isset($_GET['message'])) {?>
                <a href="Login.php" class="btn btn-primary">Login</a>
                <?php  }  ?>
                <div class="form-group checkout-small-element" >
                    <label >Name</label>
                    <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" required>
                </div>
                <div class="form-group checkout-small-element">
                    <label >Email</label>
                    <input type="text" class="form-control" id="checkout-email" name="email" placeholder="email" required>
                </div>
                <div class="form-group checkout-small-element">
                    <label >Phone</label>
                    <input type="text" class="form-control" id="checkout-phone" name="phone" placeholder="Phone Number" required>
                </div>
                <div class="form-group checkout-small-element">
                    <label >City</label>
                    <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required>
                </div>
                <div class="form-group checkout-large-element">
                    <label >Address</label>
                    <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" required>
                </div>
                
    
                <div class="form-group checkout-btn-container">
                  <p>Total amount:$<?php echo $_SESSION['total'];  ?></p>
                    <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order"/>
                    <input type="submit" class="btn" id="checkout-btn" name="cod" value="Cash on Delivery"/>
                </div>
                
            </form>
        </div>
    </section>




    <?php include('layouts/footer.php'); ?>