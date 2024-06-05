<?php
include('header.php'); 

// Redirect to login if admin is not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

// Get page number or set it to 1 by default
if(isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET["page_no"];
} else {
    //  set page number to 1 by default
    $page_no = 1;
}

// Get search parameter
$search = isset($_GET['search']) ? $_GET['search'] : "";

// Get total number of records
if ($search != '') {
    $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM orders WHERE order_id = ? OR user_phone = ?");
    $stmt1->bind_param('is', $search, $search);
} else {
    $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM orders");
}
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

// Products per page
$total_records_per_page = 10;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";
$total_no_of_pages = ceil($total_records / $total_records_per_page);

// Get orders
if ($search != '') {
    $stmt2 = $conn->prepare("SELECT * FROM orders WHERE order_id = ? OR user_phone = ? LIMIT ?, ?");
    $stmt2->bind_param('isii', $search, $search, $offset, $total_records_per_page);
} else {
    $stmt2 = $conn->prepare("SELECT * FROM orders LIMIT ?, ?");
    $stmt2->bind_param('ii', $offset, $total_records_per_page);
}
$stmt2->execute();
$orders = $stmt2->get_result();

// Calculate total cost of delivered orders
$stmt3 = $conn->prepare("SELECT SUM(order_cost) AS total_cost FROM orders WHERE order_status = 'delivered'");
$stmt3->execute();
$stmt3->bind_result($total_cost);
$stmt3->store_result();
$stmt3->fetch();

$stmt4 = $conn->prepare("SELECT COUNT(*) AS total_products_left FROM orders WHERE order_status != 'delivered'");
$stmt4->execute();
$stmt4->bind_result($total_products_left);
$stmt4->store_result();
$stmt4->fetch();

$stmt5 = $conn->prepare("SELECT COUNT(*) AS total_delivered FROM orders WHERE order_status = 'delivered'");
$stmt5->execute();
$stmt5->bind_result($total_products_delivered);
$stmt5->store_result();
$stmt5->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Orders</title>
</head>
<body>

<style>
    .form-group{
        display: flex;
        margin-bottom: 20px;
    }

    .button-search{
        background-color: coral;
        border: none;
        color: white;
        padding: 5px;
    }

    .button-search:hover{
        background-color: #ff7f50;
    }

    .dashboard {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        margin: 50px;
    }

    .dashboard-box {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding: 16px 32px;
        border: 1px solid lightgray;
        border-radius: 8px;
        box-shadow: 4px 4px 10px 2px rgba(0, 0, 0, 0.066);
    }

    .d-icon {
        border: 1px solid lightgreen;
        border-radius: 50%;
        display: flex;
        padding: 14px;
        font-size: 28px;
        justify-content: center;
        align-items: center;
        background-color: lightgreen;
        color: darkgreen;
    }
    
    .truck {
        color: cornflowerblue;
        border: 1px solid lightblue;
        background-color: lightblue;
    }

    .cart {
        color: rgb(215, 141, 3);
        border: 1px solid rgba(255, 201, 101, 0.651);
        background-color: rgba(255, 201, 101, 0.651);
    }

    .dashboard-heading {
        font-size: 20px;
        color: gray;
    }

    .d-number {
        font-size: 38px;
        font-weight: 600;
    }
</style>

<?php include('sidemenu.php'); ?>
<main class="index-section">
    <h1 class="h2">Orders</h1>
    <?php if(isset($_GET['order_updated'])) { ?>
        <p class="text-center" style="color:green;"><?php echo $_GET['order_updated']; ?></p>
    <?php } ?>
    <?php if(isset($_GET['order_failed'])) { ?>
        <p class="text-center" style="color:red;"><?php echo $_GET['order_failed']; ?></p>
    <?php } ?>
    <div class="index-container">
        <div class="dashboard">
            <div class="dashboard-box">
                <i class="fa-solid fa-cart-shopping d-icon cart"></i>
                <div class="dashboard-content">
                    <h2 class="dashboard-heading">To be delivered</h2>
                    <h3 class="d-number"> <?php echo $total_products_left; ?></h3>
                </div>
            </div>
            <div class="dashboard-box">
                <i class="fa-solid fa-rupee-sign d-icon"></i>
                <div class="dashboard-content">
                    <h2 class="dashboard-heading">Total Revenue</h2>
                    <h3 class="d-number">Rs. <?php echo $total_cost; ?></h3>
                </div>
            </div>
            <div class="dashboard-box">
                <i class="fa-solid fa-truck d-icon truck"></i>
                <div class="dashboard-content">
                    <h2 class="dashboard-heading">Total Delivered</h2>
                    <h3 class="d-number"> <?php echo $total_products_delivered; ?></h3>
                </div>
            </div>
        </div>

        <!-- Search form -->
        <form method="GET" action="">
            <div class="form-group">
                <label for="search">Search by Order ID or Phone:</label>
                <input type="text" id="search" name="search" class="" placeholder="Enter Order ID or Phone" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" class="button-search">Search</button>
            </div>
        </form>

        <?php if ($orders->num_rows > 0) { ?>
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">Order Id</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">User id</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">User Phone</th>
                        <th scope="col">User Address</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $order) { ?>
                        <tr>
                            <td><?php echo $order['order_id']; ?></td>
                            <td><?php echo $order['order_status']; ?></td>
                            <td><?php echo $order['user_id']; ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                            <td><?php echo $order['user_phone']; ?></td>
                            <td><?php echo $order['user_address']; ?></td>
                            <td><a href="edit_order.php?order_id=<?php echo $order['order_id']; ?>" style="text-decoration: none; color:#4169E1; display:flex; justify-content:center"><i class="fa-solid fa-pencil" style="font-size: 24px"></i></a></td>
                            <td>
                                <form method="post" action="delete_order.php" style="display:flex; justify-content:center; align-items: center;">
                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                    <button type="submit" class="" style="background:none; border:none;"><i class="fa-solid fa-trash" style="font-size: 24px; color:red"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No records found for the given search criteria.</p>
        <?php } ?>

        <nav aria-label="Page navigation example" class="mx-auto">
            <ul class="pagination mt-5 mx-auto">
                <li class="page-item <?php if($page_no <= 1) { echo 'disabled'; } ?>">
                    <a class="page-link" href="<?php if($page_no <= 1) { echo '#'; } else { echo "?page_no=".$previous_page . '&search=' . $search; } ?>">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="?page_no=1&search=<?php echo $search; ?>">1</a></li>
                <li class="page-item"><a class="page-link" href="?page_no=2&search=<?php echo $search; ?>">2</a></li>
                <?php if($page_no >= 3) { ?>
                    <li class="page-item"><a class="page-link" href="#">...</a></li>
                    <li class="page-item"><a class="page-link" href="<?php echo "?page_no=".$page_no . '&search=' . $search; ?>"><?php echo $page_no; ?></a></li>
                <?php } ?>
                <li class="page-item <?php if($page_no >= $total_no_of_pages) { echo 'disabled'; } ?>">
                    <a class="page-link" href="<?php if($page_no >= $total_no_of_pages) { echo '#'; } else { echo "?page_no=".$next_page . '&search=' . $search; } ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</main>
</body>
</html>
