<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bhangro</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    
    <style>
      .dropdown-menu {
        background-color: #ffffff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        min-width: 100px !important;
      }
      .dropdown-menu a {
        color: #333333;
      }
      .dropdown-menu a:hover, .dropdown-menu a:active {
        color: #333333;
        background-color: #f0f0f0;
      }

      .navbar-collapse{
        flex-grow: 0 ;
      }
      .nav-link.active {
        font-weight: bold;
        color: green;
      }

    .dropdown-item.active, .dropdown-item:active {
    color: #fff;
    text-decoration: none;
    background-color: coral;
}

.dropdown-toggle::after {
    display: inline-block;
    margin-left: 0;
    vertical-align: .255em;
    content: "";
    border-top: .3em solid;
    border-right: .3em solid transparent;
    border-bottom: 0;
    border-left: .3em solid transparent;
}
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white py-3 fixed-top">
  <div class="container-fluid justify-content-space-between">
    <img src="images\Logo.png">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"><i class="fa-solid fa-bars" style="color:black; border:none"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php if($current_page == 'index.php') echo 'active'; ?>" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($current_page == 'shop.php') echo 'active'; ?>" href="shop.php">Shop</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($current_page == 'aboutus.php') echo 'active'; ?>" href="aboutus.php">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($current_page == 'contact.php') echo 'active'; ?>" href="contact.php">Contact Us</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex gap-2 align-items-center" style="text-decoration:none" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-user"></i>  
            <?php if(isset($_SESSION['user_name'])) {
              $user_name = $_SESSION['user_name'];
              echo $user_name;
            } else {
              echo "";
            } ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php if(isset($_SESSION['user_name'])): ?>
              <li><a class="dropdown-item <?php if($current_page == 'profile.php') echo 'active'; ?>" href="profile.php">Profile</a> </li>
              <li><a class="dropdown-item <?php if($current_page == 'cus_order.php') echo 'active'; ?>" href="cus_order.php">Your Orders</a></li>
              <li><a class="dropdown-item" href="logout.php" >Logout</a></li>
            <?php else: ?>
              <li><a class="dropdown-item" href="login.php">Login</a></li>
            <?php endif; ?>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"> <i class="fa fa-cart-plus" ></i></a>
        </li>
        <!-- <li class="nav-item">
          <span>
            <?php if(isset($_SESSION['user_name'])) {
              $user_name = $_SESSION['user_name'];
              echo "Welcome: " . $user_name;
            } else {
              echo "";
            } ?>
          </span>
        </li> -->
      </ul>
    </div>
  </div>
</nav>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js" integrity="sha384-B/aPxCfVCfFF6kcxp3qzYL41jBpMhcrTTgftBj5VkH1t8JqXSNp1N7/SS+D13gb/" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js" integrity="NEW-INTEGRITY-HASH" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/144a91ca19.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</body>
</html>
