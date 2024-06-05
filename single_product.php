<?php
session_start();
include('server/connection.php');

// Check if product ID is set
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Prepare and execute SQL statement to fetch product details
    $stmt = $conn->prepare("SELECT * FROM products  WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    // Get product details
    $product = $stmt->get_result();

    // Redirect to login page if user is not logged in
    // if (!isset($_SESSION['logged_in'])) {
    //     header("Location: Login.php");
    //     exit();
    // }
}
?>

<?php include('layouts/header.php'); ?>

<!-- Single product -->
<section class="container single-product my-5 pt-5">
    <div class="row mt-5 justify-content-center gap-4">
        <?php while ($row = $product->fetch_assoc()) { ?>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <img src="images/<?php echo $row['product_image']; ?>" class="img-fluid w-100 pb-1" id="main-img" style="border-radius:20px">  
            </div>

            <div class="col-lg-6 col-md-12 col-12">
                <h6 class="mb-2 text-uppercase"><?php echo $row['product_category']; ?></h6>
                <h2 class="mb-1"><?php echo $row['product_name']; ?></h2>
                <h3 class="mb-4" style="color: coral">Rs. <?php echo $row['product_price'];?></h3>
                <div class="mb-4">
                    <p style="color:black; font-size:18px"><?php echo $row['product_description']; ?></p>
                </div>
                <div style="display:grid; grid-template-columns: 1fr 1fr; justify-content: center; align-items:center; width:70%; margin-bottom:20px";>
                <!-- <span style="grid-column: span 2; font-size:20px; color:black; text-align:center">Product Details</span> -->
                    <span style="font-size:18px; border: 1px solid darkGray; padding: 2px 6px" class="text-muted">Material</span>
                    <span style="font-size:18px; border: 1px solid darkGray; padding: 2px 6px" class="text-muted"><?php echo $row['product_material']; ?></span>
                    <span style="font-size:18px; border: 1px solid darkGray; padding: 2px 6px" class="text-muted">Size</span>
                    <span style="font-size:18px; border: 1px solid darkGray; padding: 2px 6px" class="text-muted"><?php echo $row['product_size']; ?></span>
                    <span style="font-size:18px; border: 1px solid darkGray; padding: 2px 6px" class="text-muted">Comfort</span>
                    <span style="font-size:18px; border: 1px solid darkGray; padding: 2px 6px" class="text-muted"><?php echo $row['product_comfort']; ?></span>
                    <span style="font-size:18px; border: 1px solid darkGray; padding: 2px 6px" class="text-muted">Design</span>
                    <span style="font-size:18px; border: 1px solid darkGray; padding: 2px 6px" class="text-muted"><?php echo $row['product_design']; ?></span>
                    <span style="font-size:18px; border: 1px solid darkGray; padding: 2px 6px" class="text-muted">Care</span>
                    <span style="font-size:18px; border: 1px solid darkGray; padding: 2px 6px" class="text-muted"><?php echo $row['product_care']; ?></span>
                </div> 

                <form action="cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?> ">
                    <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">

                    <button class="" type="submit" name="add_to_cart">Add To Cart</button>
                </form>
            </div>
        <?php } ?>
    </div>
</section>

<!-- Related feature -->
<section id="related-products" class="my-5 pb-5">
    <div class="container">
    <h2 class="mb-4">Related Products</h2>
    </div>
    <div class="">
        <div class="d-flex justify-content-evenly featured-container gap-5">
          <?php include('server/get_featured_products.php');?>
          <?php
            while($row =$featured_products->fetch_assoc()){
          ?>
        <a href="<?php echo "single_product.php?product_id=". $row ['product_id']; ?>" class="product-link product  col-lg-3 col-md-4 col-sm-12" style="width:18rem;">
            <img src="images/<?php echo $row['product_image']; ?>" class="img-fluid mb-3" style="width:18rem; height:18rem; object-fit: cover;">
            <div style="display:flex; justify-content:space-between; align-items:center">
              <div>
                <h4 class="p-name"><?php  echo $row['product_name']; ?></h4>
                <h5 class="p-price text-success">Rs.<?php echo $row['product_price'];?></h5>
              </div>
              <form action="cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?> ">
                <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                
                <button type="submit" name="add_to_cart" style="border-radius: 12px"><i class="fa-solid fa-cart-shopping"></i></button>
              </form>
            </div>
            </a>
        <?php } ?>
        </div>
    </div>
</section>

<?php include('layouts/footer.php'); ?>
