<?php  include('../server/connection.php') ?>
<?php

if(isset($_POST['update_images'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];




$image1 = $_FILES['image1']['tmp_name'];
    $image2 = $_FILES['image2']['tmp_name'];
    $image3 = $_FILES['image3']['tmp_name'];
    $image4 = $_FILES['image4']['tmp_name'];
    // $file_name = $_FILES['image1']['name'];

    $image_name1 = "$product_name"."_1.jpeg";
    $image_name2 = "$product_name"."_2.jpeg";
    $image_name3 = "$product_name"."_3.jpeg";
    $image_name4 = "$product_name"."_4.jpeg";
    

    move_uploaded_file($image1, "./images/".$image_name1);
    move_uploaded_file($image2, "./images/".$image_name2);
    move_uploaded_file($image3, "./images/".$image_name3);
    move_uploaded_file($image4, "./images/".$image_name4);

    $stmt =$conn->prepare("UPDATE products SET product_image=?,product_image2=?,product_image3=?,product_image4=? WHERE product_id=?" );
    $stmt->bind_param('ssssi',$image_name1,$image_name2,$image_name3,$image_name4,$product_id);
    if(!$stmt->execute()) {
       
        header('location: products.php?images_updated=Images have been updated successfully');
    } else{
        header('location: products.php?images_failed=Images have not been updated ');
    }
    }
    ?>