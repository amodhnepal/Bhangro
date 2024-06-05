<?php
session_start();
include ('server/connection.php');
// if (!isset($_SESSION['logged_in'])) {
//   header("Location: Login.php");
//   exit();
// }

if (isset($_POST['search'])) {
    if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
        $page_no = $_GET["page_no"];
    } else {
        $page_no = 1;
    }

    $category = $_POST['category'];

    $stmt = $conn->prepare("SELECT COUNT(*) As total_records FROM products WHERE product_category=?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $stmt->bind_result($total_records);
    $stmt->store_result();
    $stmt->fetch();

    $total_records_per_page = 8;
    $offset = ($page_no - 1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    $adjacents = "2";
    $total_no_of_pages = ceil($total_records / $total_records_per_page);

    $stmt2 = $conn->prepare("SELECT * FROM products WHERE product_category=? LIMIT ?, ?");
    $stmt2->bind_param("sii", $category, $offset, $total_records_per_page);
    $stmt2->execute();
    $products = $stmt2->get_result();

} else {

    if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
        $page_no = $_GET["page_no"];
    } else {
        $page_no = 1;
    }

    $stmt1 = $conn->prepare("SELECT COUNT(*) As total_records FROM products");
    $stmt1->execute();
    $stmt1->bind_result($total_records);
    $stmt1->store_result();
    $stmt1->fetch();

    $total_records_per_page = 8;
    $offset = ($page_no - 1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    $adjacents = "2";
    $total_no_of_pages = ceil($total_records / $total_records_per_page);

    $stmt2 = $conn->prepare("SELECT * FROM products LIMIT ?, ?");
    $stmt2->bind_param("ii", $offset, $total_records_per_page);
    $stmt2->execute();
    $products = $stmt2->get_result();
}
?>

<?php include ('layouts/header.php') ?>

<!-- Featured -->
<div class="main-shop position-relative">
    <section id="search" class="py-2 filter-section side-bar">
        <form action="shop.php" method="POST" class="form-container" style="margin-top: 100px; width:300px">
            <div class="row mx-auto container">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <p class="sidebar-title">Category</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="bagpacks" name="category" id="category_one"
                            <?php if (isset($category) && $category == 'bagpacks') { echo 'checked'; } ?>>
                        <label class="form-check-label" for="category_one">BackPacks</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="sidebags" name="category" id="category_two"
                            <?php if (isset($category) && $category == 'side bag') { echo 'checked'; } ?>>
                        <label class="form-check-label" for="category_two">Sidebags</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="category" value="tote bag" id="category_three"
                            <?php if (isset($category) && $category == 'Tote Bag') { echo 'checked'; } ?>>
                        <label class="form-check-label" for="category_three">Tote Bags</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="category" value="fannypacks" id="category_four"
                            <?php if (isset($category) && $category == 'fannypacks') { echo 'checked'; } ?>>
                        <label class="form-check-label" for="category_four">Fanny Packs</label>
                    </div>
                </div>
            </div>
            <div class="form-group my-3 mx-3">
                <input type="submit" name="search" value="Search" class="btn btn-primary">
            </div>
        </form>
    </section>

    <!-- Shop -->
    <section id="shop" class="shop-section" style="border-left: 1px solid lightgray">
        <div class="text-center py-2">
            <h3>Our products</h3>
            <hr>
            <p class="title-desc mb-5">Here you can check out our new featured products.</p>
        </div>
        <div class="d-flex justify-content-center product-container">
            <?php while ($row = $products->fetch_assoc()) { ?>
                <a href="<?php echo "single_product.php?product_id=" . $row['product_id']; ?>"
                    class="product-link product col-lg-3 col-md-4 col-sm-12" style="width:15rem;">
                    <img src="images/<?php echo $row['product_image']; ?>" class="img-fluid mb-3"
                        style="width:15rem; height:15rem; object-fit: cover">
                    <div style="display:flex; justify-content:space-between; align-items:center">
                        <div>
                            <h4 class="p-name" style="font-size:1.2rem"><?php echo $row['product_name']; ?></h4>
                            <h5 class="p-price text-success" style="font-size:1rem">Rs. <?php echo $row['product_price']; ?></h5>
                        </div>
                        <form action="cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                            <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                            <button type="submit" name="add_to_cart" style="border-radius: 7px"><i class="fa-solid fa-cart-shopping"></i></button>
                        </form>
                    </div>
                </a>
            <?php } ?>
            <nav aria-label="Page navigation" class="d-flex justify-content-end pagination-container">
                <ul class="pagination mt-5 mb-5">
                    <li class="page-item <?php if ($page_no <= 1) { echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php if ($page_no <= 1) { echo '#'; } else { echo "?page_no=" . ($page_no - 1); } ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
                    <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>
                    <?php if ($page_no >= 3) { ?>
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="<?php echo "?page_no=" . $page_no; ?>"><?php echo $page_no; ?></a></li>
                    <?php } ?>
                    <li class="page-item <?php if ($page_no >= $total_no_of_pages) { echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php if ($page_no >= $total_no_of_pages) { echo '#'; } else { echo "?page_no=" . ($page_no + 1); } ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
</div>
<?php include ('layouts/footer.php'); ?>
