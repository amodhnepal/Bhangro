<?php
include('../server/connection.php');

if(isset($_POST['create_product'])){
        
    $product_name = $_POST['title'];
    $product_description = $_POST['description'];
    $product_price = $_POST['price'];
    $product_category = $_POST['category'];
    $product_color = $_POST['color'];
    $product_material = $_POST['material'];
    $product_design = $_POST['design'];
    $product_comfort = $_POST['comfort'];
    $product_size = $_POST['size'];
    $product_care = $_POST['care'];
    $product_impact = $_POST['impact'];

    $image_tmp = $_FILES['image']['tmp_name'];
    $file_name = $_FILES['image']['name'];
    $image_name = "$product_name" . ".jpeg";
    move_uploaded_file($image_tmp, "../images/" . $image_name);

    $stmt = $conn->prepare("INSERT INTO products (product_name,product_description,product_price,
                            product_image,product_category,product_color,product_material,product_design,
                            product_comfort,product_size,product_care,product_impact) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

    $stmt->bind_param('ssssssssssss', $product_name, $product_description, $product_price, $image_name, $product_category, $product_color, $product_material, $product_design, $product_comfort, $product_size, $product_care, $product_impact);
    
    if($stmt->execute()){
        header('location:products.php?product_created=Product has been created');
    } else {
        header('location:products.php?product_failed=Error occurred, try again');
    }
}   
?>
