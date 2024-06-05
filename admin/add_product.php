<?php include('header.php'); ?>

<?php
include('sidemenu.php');
?>

<main class="add-product-container">
    <h2 class="add-product-title mb-4">Create Product</h2>
    <div class="" style="width:600px; box-shadow: 5px 5px 20px 5px rgba(0, 0, 0, 0.127); padding:50px; padding-top: 0">
        <form id="edit-form" method="POST" class="form-container" enctype="multipart/form-data" action="create_product.php">
            <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
            <div class="form-group mt-2">
                <label for="product-name">Title</label>
                <input type="text" class="form-control" id="product-name" name="title" placeholder="Bag" required>
            </div>
            <div class="form-group mt-2">
                <label for="product-desc">Description</label>
                <input type="text" class="form-control" id="product-desc" name="description" placeholder="Description of the products" required>
            </div>
            <div class="form-group mt-2">
                <label for="product-price">Price</label>
                <input type="text" class="form-control" id="product-price" name="price" placeholder="Price of the product in Rs." required>
            </div>
            
            <div class="form-group mt-2">
                <label for="form-select">Category</label>
                <select id="form-select" class="form-select" required name="category">
                    <option value="fannypacks">Fanny Packs</option>
                    <option value="sidebags">Side Bags</option>
                    <option value="Bagpacks">Bagpacks</option>
                    <option value="Totebags">Tote Bags</option>
                </select>
            </div>
            <div class="form-group mt-2">
                <label for="product-color">Color</label>
                <input type="text" class="form-control" id="product-color" name="color" placeholder="Color of the product" required>
            </div>

            <div class="form-group mt-2">
                <label for="product-material">Material</label>
                <input type="text" class="form-control" id="product-material" name="material" placeholder="100% hemp; sustainable, durable, biodegradable" >
            </div>

            <div class="form-group mt-2">
                <label for="product-design">Design</label>
                <input type="text" class="form-control" id="product-design" name="design" placeholder="Stylish, minimalist; spacious interior" >
            </div>

            <div class="form-group mt-2">
                <label for="product-comfort">Comfort</label>
                <input type="text" class="form-control" id="product-comfort" name="comfort" placeholder="Sturdy handles, lightweight, ergonomic" >
            </div>

            <div class="form-group mt-2">
                <label for="product-size">Size</label>
                <input type="text" class="form-control" id="product-size" name="size" placeholder="15&quot; (H) x 12&quot; (W) x 5&quot; (D)" >
            </div>

            <div class="form-group mt-2">
                <label for="product-care">Care</label>
                <input type="text" class="form-control" id="product-care" name="care" placeholder="Spot clean with mild detergent, air dry" >
            </div>

            <div class="form-group mt-2">
                <label for="product-impact">Impact</label>
                <input type="text" class="form-control" id="product-impact" name="impact" placeholder="Supports fair trade, community development" >
            </div>

            <div class="form-group mt-2">
                <label for="product-image">Image</label>
                <input type="file" class="form-control" id="product-image" name="image" required>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <input type="submit" class="submit-btn" name="create_product" value="Create"/>
            </div>
        </form>
    </div>
</main>
