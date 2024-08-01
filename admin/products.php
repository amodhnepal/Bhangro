<?php
include('header.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

// Get current page number from query parameters
$page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? $_GET['page_no'] : 1;

// Capture sorting preference
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'stock_asc'; // Default sorting is by stock ascending

// Capture filter preference
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Prepare statement to get the total number of products
$filter_condition = '';
if ($filter == 'low_stock') {
    $filter_condition = 'WHERE stock <= 2';
}

$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products $filter_condition");
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

// Products per page
$total_records_per_page = 5;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;

// Calculate total number of pages
$total_no_of_pages = ceil($total_records / $total_records_per_page);

// Determine the ORDER BY clause based on sorting preference
// switch ($sort_by) {
//     case 'stock_asc':
//         $order_by = "ORDER BY stock ASC";
//         break;
//     case 'stock_desc':
//         $order_by = "ORDER BY stock DESC";
//         break;
//     case 'price_asc':
//         $order_by = "ORDER BY product_price ASC";
//         break;
//     case 'price_desc':
//         $order_by = "ORDER BY product_price DESC";
//         break;
//     default:
//         $order_by = "ORDER BY stock ASC"; // Default sorting
// }

// Get all products with sorting, filtering, and pagination
$stmt2 = $conn->prepare("
    SELECT * 
    FROM products 
    $filter_condition
    LIMIT ?, ?
");
$stmt2->bind_param("ii", $offset, $total_records_per_page);
$stmt2->execute();
$products = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Products</title>
</head>
<body>
    <div class="product-container">
        <?php include('sidemenu.php'); ?>

        <main class="product-section">
            <h1 class="h2">Products</h1>

            <div class="filter-options">
                <form method="GET" action="" class="filter-form">
                    <input type="hidden" name="page_no" value="<?php echo $page_no; ?>">
                    <input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>">
                    <select name="filter" onchange="this.form.submit()">
                        <option value="" <?php if ($filter == '') echo 'selected'; ?>>Show All Products</option>
                        <option value="low_stock" <?php if ($filter == 'low_stock') echo 'selected'; ?>>Show Low Stock Products</option>
                    </select>
                </form>
            </div>

            <!-- <div class="sort-options">
                <form method="GET" action="" class="sort-form">
                    <input type="hidden" name="page_no" value="<?php echo $page_no; ?>">
                    <input type="hidden" name="filter" value="<?php echo $filter; ?>">
                    <select name="sort_by" onchange="this.form.submit()">
                        <option value="stock_asc" <?php if ($sort_by == 'stock_asc') echo 'selected'; ?>>Sort by Stock (Ascending)</option>
                        <option value="stock_desc" <?php if ($sort_by == 'stock_desc') echo 'selected'; ?>>Sort by Stock (Descending)</option>
                        <option value="price_asc" <?php if ($sort_by == 'price_asc') echo 'selected'; ?>>Sort by Price (Ascending)</option>
                        <option value="price_desc" <?php if ($sort_by == 'price_desc') echo 'selected'; ?>>Sort by Price (Descending)</option>
                    </select>
                </form>
            </div> -->

            <!-- Display any messages -->
            <?php if (isset($_GET['edit_success_message'])) { ?>
                <p class="text-center" style="color:green;"><?php echo $_GET['edit_success_message']; ?></p>
            <?php } ?>

            <?php if (isset($_GET['edit_failure_message'])) { ?>
                <p class="text-center" style="color:red;"><?php echo $_GET['edit_failure_message']; ?></p>
            <?php } ?>

            <?php if (isset($_GET['deleted_successfully'])) { ?>
                <p class="text-center" style="color:green;"><?php echo $_GET['deleted_successfully']; ?></p>
            <?php } ?>

            <?php if (isset($_GET['deleted_failure'])) { ?>
                <p class="text-center" style="color:red;"><?php echo $_GET['deleted_failure']; ?></p>
            <?php } ?>

            <?php if (isset($_GET['product_created'])) { ?>
                <p class="text-center" style="color:red;"><?php echo $_GET['product_created']; ?></p>
            <?php } ?>

            <?php if (isset($_GET['product_failed'])) { ?>
                <p class="text-center" style="color:red;"><?php echo $_GET['product_failed']; ?></p>
            <?php } ?>

            <?php if (isset($_GET['images_updated'])) { ?>
                <p class="text-center" style="color:red;"><?php echo $_GET['images_updated']; ?></p>
            <?php } ?>

            <?php if (isset($_GET['images_failed'])) { ?>
                <p class="text-center" style="color:red;"><?php echo $_GET['images_failed']; ?></p>
            <?php } ?>

            <div class="table-responsive">
                <table class="table table-striped table-lg">
                    <thead>
                        <tr>
                            <th scope="col">Product Id</th>
                            <th scope="col">Product Image</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Price</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Product Category</th>
                            <th scope="col">Product Color</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($product = $products->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $product['product_id']; ?></td>
                                <td><img src="<?php echo "../images/" . $product['product_image']; ?>" style="width:70px; height:70px"></td>
                                <td><?php echo $product['product_name']; ?></td>
                                <td><?php echo "Rs." . $product['product_price']; ?></td>
                                <td style="<?php if ($product['stock'] <= 2) echo 'color: red;'; ?>"><?php echo $product['stock']; ?></td>
                                <td><?php echo $product['product_category']; ?></td>
                                <td><?php echo $product['product_color']; ?></td>
                                <td><a class="" style="text-decoration: none; color:#4169E1; display:flex; justify-content:center" href="edit_product.php?product_id=<?php echo $product['product_id'] ?>"><i class="fa-solid fa-pencil" style="font-size: 24px"></i></a></td>
                                <td><a class="" style="text-decoration: none; color:red; display:flex; justify-content:center" href="delete_product.php?product_id=<?php echo $product['product_id'] ?>"><i class="fa-solid fa-trash" style="font-size: 24px"></i></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <nav aria-label="Page navigation example" class="mx-auto">
                    <ul class="pagination mt-5 mx-auto">
                        <li class="page-item <?php if ($page_no <= 1) echo 'disabled'; ?>">
                            <a class="page-link" href="<?php if ($page_no <= 1) { echo '#'; } else { echo "?page_no=" . $previous_page . "&sort_by=" . $sort_by . "&filter=" . $filter; } ?>">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="?page_no=1&sort_by=<?php echo $sort_by; ?>&filter=<?php echo $filter; ?>">1</a></li>
                        <li class="page-item"><a class="page-link" href="?page_no=2&sort_by=<?php echo $sort_by; ?>&filter=<?php echo $filter; ?>">2</a></li>

                        <?php if ($page_no >= 3) { ?>
                            <li class="page-item"><a class="page-link" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="?page_no=<?php echo $page_no; ?>&sort_by=<?php echo $sort_by; ?>&filter=<?php echo $filter; ?>"><?php echo $page_no; ?></a></li>
                        <?php } ?>

                        <li class="page-item <?php if ($page_no >= $total_no_of_pages) echo 'disabled'; ?>">
                            <a class="page-link" href="<?php if ($page_no >= $total_no_of_pages) { echo '#'; } else { echo "?page_no=" . $next_page . "&sort_by=" . $sort_by . "&filter=" . $filter; } ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </main>
    </div>
</body>
</html>
