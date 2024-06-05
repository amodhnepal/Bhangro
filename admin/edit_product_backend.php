<?php include('header.php');?>
<?php
if(isset($_POST['edit_btn'])) {
    $product_id=$_POST["product_id"];
    $title =$_POST['title'];
    $description = $_POST['description'];
    $price= $_POST['price'];
    $offer=$_POST['offer'];
    $color=$_POST['color'];
    $category=$_POST['category'];

    // Image handling
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    move_uploaded_file($image_tmp, "../images/" . $image_name);

    $stmt = $conn->prepare("UPDATE products SET product_name=?, product_description=?, product_price=?, product_color=?, product_category=?, product_image=? WHERE product_id=?");
    $stmt->bind_param('ssssssi', $title, $description, $price, $color, $category, $image_name, $product_id);
    if($stmt->execute()) {
        header('location: products.php?edit_success_message=Product edited successfully');
    } else {
        header('location: products.php?edit_failure_message=Error. Please try again.');
    }
} else {
    header('products.php');
    exit;
}
?>