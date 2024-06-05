<?php include('header.php');?>

<?php
if(isset($_GET['product_id'])){
    $product_id=$_GET['product_id'];
    $stmt = $conn->prepare("SELECT *  FROM products WHERE product_id=? ");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $products= $stmt->get_result();
} 
?>

<?php include('sidemenu.php');?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left: 300px !important; margin-top: 100px;">
<h2 class="add-product-title mb-4">Edit Product</h2>
    <div class="container" style=" max-width: 700px;" >
        <form id="edit-form" method="POST" enctype="multipart/form-data" action="edit_product_backend.php">
            <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
            <?php foreach($products as $product): ?>
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            
            <div class="form-group mt-2">
                <label>Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $product['product_name']; ?>" placeholder="Title" required>
            </div>
            <div class="form-group mt-2">
                <label>Description</label>
                <input type="text" class="form-control" name="description" value="<?php echo $product['product_description']; ?>" placeholder="Description" required>
            </div>
            <div class="form-group mt-2">
                <label>Price</label>
                <input type="text" class="form-control" name="price" value="<?php echo $product['product_price']; ?>" placeholder="Price" required>
            </div>
            <div class="form-group mt-2">
                <label>Category</label>
                <select class="form-select" name="category" required>
                    <option value="fannypacks" <?php if($product['product_category'] == 'fannypacks') echo 'selected'; ?>>Fanny Pack</option>
                    <option value="sidebags" <?php if($product['product_category'] == 'sidebags') echo 'selected'; ?>>Side Bags</option>
                    <option value="totebags" <?php if($product['product_category'] == 'totebags') echo 'selected'; ?>>Tote Bags</option>
                    <option value="bagpacks" <?php if($product['product_category'] == 'bagpacks') echo 'selected'; ?>>Bagpacks</option>
                </select>
            </div>
            <div class="form-group mt-2">
                <label>Color</label>
                <input type="text" class="form-control" name="color" value="<?php echo $product['product_color']; ?>" placeholder="Color" required>
            </div>
          
            <div class="form-group mt-2">
    <label>Image</label>
    <input type="file" class="form-control" name="image">
    <div></div>
    <!-- Display the existing image -->
    <img src="../images/<?php echo $product['product_image']; ?>" alt="Product Image" style="max-width: 200px; margin-top: 10px;">
</div>
            <?php endforeach; ?>

            <div class="form-group mt-3">
                <input type="submit" class="btn" style="background-color:green; color:white" name="edit_btn" value="Edit"/>
            </div>
        </form>
    </div>
</main>


