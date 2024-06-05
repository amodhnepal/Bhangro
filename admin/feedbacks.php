<?php
include('header.php');

if(!isset($_SESSION['admin_logged_in'])){
    header('location: login.php');
    exit();
}

// Pagination logic
if(isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET["page_no"];
} else {
    $page_no = 1;
}

$stmt1 = $conn->prepare("SELECT COUNT(*) As total_records FROM reviews");
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

$total_records_per_page = 10;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$total_no_of_pages = ceil($total_records / $total_records_per_page);

$stmt2 = $conn->prepare("SELECT * FROM reviews LIMIT ?, ?");
$stmt2->bind_param("ii", $offset, $total_records_per_page);
$stmt2->execute();
$reviews = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Feedback</title>
</head>
<body>
    <div class="product-container">
        <?php include('sidemenu.php'); ?>
        <main class="product-section">
            <h1 class="h2">User Feedback</h1>
            <div class="table-responsive">
                <table class="table table-striped table-lg">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review) { ?>
                            <tr>
                                <td><?php echo $review['Name']; ?></td>
                                <td><?php echo $review['Email']; ?></td>
                                <td><?php echo $review['Comment']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <!-- Pagination -->
                <nav aria-label="Page navigation example" class="mx-auto">
                    <ul class="pagination mt-5 mx-auto">
                        <li class="page-item <?php if($page_no <= 1) { echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if($page_no <= 1) { echo '#'; } else { echo "?page_no=".($page_no-1); } ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_no_of_pages; $i++) { ?>
                            <li class="page-item <?php if($page_no == $i) { echo 'active'; } ?>">
                                <a class="page-link" href="<?php echo "?page_no=".$i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                        <li class="page-item <?php if($page_no >= $total_no_of_pages) { echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if($page_no >= $total_no_of_pages) { echo '#'; } else { echo "?page_no=".($page_no+1); } ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </main>
    </div>
</body>
</html>
