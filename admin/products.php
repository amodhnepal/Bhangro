<?php include('header.php');?>

<?php


if(!isset($_SESSION['admin_logged_in'])){
    header('location: login.php');
    exit();


}


?>


<?php


  if(isset($_GET['page_no'])&& $_GET['page_no'] !="") {
    $page_no = $_GET["page_no"];
    } else {
      //  set page number to 1 by default
      $page_no = 1;


  }
  // return number of products
  $stmt1 = $conn->prepare("SELECT COUNT(*) As total_records FROM products");
  $stmt1->execute();
  $stmt1->bind_result($total_records);
  $stmt1->store_result();
  $stmt1->fetch();

  // products per page
  $total_records_per_page=5;
  $offset = ($page_no-1) * $total_records_per_page;
  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;

  $adjacents ="2";
  $total_no_of_pages= ceil($total_records / $total_records_per_page);


// get all products
$stmt2 = $conn->prepare("SELECT *  FROM products LIMIT $offset,$total_records_per_page");
$stmt2->execute();
$products= $stmt2->get_result();

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Document</title>
</head>

<body>
    <div class="product-container">
    <?php
    include('sidemenu.php');


    ?>

    <main class="product-section" >
            <h1 class="h2">Products</h1>
        <?php if(isset($_GET['edit_success_message'])) { ?>
            <p class="text-center" style="color:green;"><?php echo $_GET['edit_success_message']; ?></p>
            <?php  } ?>

            <?php if(isset($_GET['edit_failure_message'])) { ?>
            <p class="text-center" style="color:red;"><?php echo $_GET['edit_failure_message']; ?></p>
            <?php  } ?>

            <?php if(isset($_GET['deleted_successfully'])) { ?>
            <p class="text-center" style="color:green;"><?php echo $_GET['deleted_successfully']; ?></p>
            <?php  } ?>

            <?php if(isset($_GET['deleted_failure'])) { ?>
            <p class="text-center" style="color:red;"><?php echo $_GET['deleted_failure']; ?></p>
            <?php  } ?>


            <?php if(isset($_GET['product_created'])) { ?>
            <p class="text-center" style="color:red;"><?php echo $_GET['product_created']; ?></p>
            <?php  } ?>

            <?php if(isset($_GET['product_failed'])) { ?>
            <p class="text-center" style="color:red;"><?php echo $_GET['product_failed']; ?></p>
            <?php  } ?>

            <?php if(isset($_GET['images_updated'])) { ?>
            <p class="text-center" style="color:red;"><?php echo $_GET['images_updated']; ?></p>
            <?php  } ?>

            <?php if(isset($_GET['images_failed'])) { ?>
            <p class="text-center" style="color:red;"><?php echo $_GET['images_failed']; ?></p>
            <?php  } ?>


        <div class="table-responsive">
            <table class="table table-striped table-lg">
                <thead>
                    <tr>
                        <th scope="col" >Product Id</th>
                        <th scope="col" >Product Image</th>

                        <th scope="col" >Product Name</th>
                        <th scope="col" >Product Price</th>
                        <th scope="col" >Product category</th>

                        <th scope="col" >Product Color</th>
                      

                        <th scope="col" >Edit</th>
                        <th scope="col" >Delete</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product) { ?>
                    <tr>
                        <td><?php echo $product['product_id'];  ?></td>
                        <td><img src="<?php echo "../images/". $product['product_image'];  ?>" style="width:70px; height:70px"></td>
                        <td><?php echo $product['product_name'];  ?></td>
                        <td><?php echo "Rs.".$product['product_price'];  ?></td>
                        <td><?php echo $product['product_category'];  ?></td>
                        <td><?php echo $product['product_color'];  ?></td>
                        <!-- <td><a class="btn btn-warning" href="<?php echo "edit_images.php?product_id=".$product["product_id"]."&product_name=".$product['product_name'];?>">Edit Images</a></td> -->
                        <td><a class=""  style="text-decoration: none; color:#4169E1; display:flex; justify-content:center" href="edit_product.php?product_id=<?php echo $product["product_id"]?>"><i class="fa-solid fa-pencil" style="font-size: 24px"></i></a></td>
                        <td><a class=""  style="text-decoration: none; color:red; display:flex; justify-content:center" href="delete_product.php?product_id=<?php echo $product['product_id'] ?>"><i class="fa-solid fa-trash" style="font-size: 24px"></i></a> </td>
                    </tr>
                    <?php  } ?>
                </tbody>
            </table>

            <nav aria-label="Page navigation example" class="mx-auto">
        <ul class="pagination mt-5 mx-auto" >

            <li class="page-item <?php if($page_no<=1){ echo 'disabled'; } ?> ">
            <a class="page-link" href="<?php if($page_no<=1){echo '#';} else{echo "?page_no".$page_no-1;}?>">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
            <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>

              <?php if($page_no >=3) { ?>
            <li class="page-item"><a class="page-link" href="">...</a></li>
            <li class="page-item"><a class="page-link" href="<?php echo "?page_no".$page_no;  ?>"><?php echo $page_no; ?></a></li>
                <?php } ?>

            <li class="page-item <?php if($page_no>= $total_no_of_pages){echo 'disabled';}?>">
            <a class="page-link" href="<?php if($page_no>= $total_no_of_pages){echo '#';} else{ echo "?page_no=".$page_no+1;}?>">Next<a></li>
        </ul>
      </nav>



        </div>
       </main>
       </div>

    <!-- </div>
</div> -->
</body>
</html>