<?php
$current_page = basename($_SERVER['PHP_SELF']);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333; 
        }

        #sidebarMenu {
            width: 300px;
            background-color: white;
            border-right: 2px;
            padding: 50px 20px;
            position: sticky absolute;
            height: 100%;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .nav-link {
            display: flex;
            gap: 20px;
            padding: 12px 10px;
            width: 100%;
            font-size:1.2rem ;
            text-decoration: none;
            color: black;
            transition: background-color 0.3s;
            border-radius: 10px;
            align-items: center;
        }

        .nav-link:hover {
            background-color: #ff7f50;
        }

        .active {
            font-weight: bold;
            color: #ff7f50;
        }

        .nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 20px
        }
    </style>
</head>
<body>
    <div>
        <nav id="sidebarMenu">
        <a href="#" class="navbar-brand px-3">Bhangro</a>
            <h1>Admin Panel</h1>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page == 'index.php') echo 'active'; ?>"  href="edit_order.php">
                    <i class="fa-solid fa-sack-dollar"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page == 'products.php') echo 'active'; ?>" href="products.php">
                    <i class="fa-solid fa-boxes-stacked"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page == 'Account.php') echo 'active'; ?>" href="Account.php">
                    <i class="fa-solid fa-user-plus"></i>
                        <span>Account</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page == 'add_product.php') echo 'active'; ?>" href="add_product.php">
                    <i class="fa-solid fa-plus"></i>
                        <span>Add Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page == 'feedbacks.php') echo 'active'; ?>" href="feedbacks.php">
                    <i class="fa-solid fa-comment"></i>
                        <span>View Feedbacks</span>
                    </a>
                </li>
                <li class="nav-item">
                <?php if(isset($_SESSION['admin_logged_in'])){ ?>

                    <a href="logout.php?logout=1" class="nav-link">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span></a>
                    <?php }?>
                </li>
            </ul>
        </nav>
    </div>
</body>
</html>
