<?php include('layouts/header.php');
include('server/connection.php');
if (isset($_GET['status']) && $_GET['status'] === "Completed") {


  $order_id = $_SESSION['order_id'];
  echo($order_id);
  $stmt = $conn->prepare("UPDATE orders SET order_status = 'paid' WHERE order_id = ?");
  $stmt->bind_param('i', $order_id);
  $stmt->execute();

  
  $conn->close();

 
  echo '<script>alert("Order placed successfully.")</script>';
  echo '<script>
  setTimeout(function() {
    window.location.href = "http://localhost/Bhangro/index.php";
  }, 0);
</script>';

  exit; 
}
?>

<style>
   

    body {
      background: #eee;
      font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
      font-size: 14px;
      color: #000;
      margin: 0;
      padding: 0;
    }

    .swiper {
      width: 100%;
      height: 60vh;
    }

    .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .adcontainer {
      text-align: center;
      padding: 20px;
    }
    .banner h4 {
      font-size: 0.9em;
      color: white;
    }
    .banner h1 {
      font-size: 3.5em;
      margin: 10px 0;
      color: #333;
    }
    .banner p {
      font-size: 1.4em;
      margin: 5px 0;
      color: #555;
    }



.home-icon {
    font-size: 40px;
    color: #4CAF50;
}

.home-icon-des {
    font-size: 18px;
    font-weight: bold;
    color: #333; 
}

.home-icon-content {
    font-size: 16px;
    color: #666; 
    text-align: center;
}

.ourFeature{
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  margin: 3rem auto;
  align-items: start;
  gap: 2rem;
}
  </style>

      <!-- Home -->
      <section id="home">
        <div class="container hero-container d-flex flex-column justify-content-center align-items-center">

          <div class="hero-details">

            <h1 class="heading">Carry Your Style,</h1>
            <h1 class="heading">Unfold Your Adventure</h1>
            <p class="hero-content">Hemp doesn't make you high.</p>
          </div>
          <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"> <button class="hero-buy-btn">Shop Now</button></a>
        </div>
      </section>
      <!-- Brand -->
      <section id="brand" class="container">
    <div class=" ourFeature">
        <div class="d-flex flex-column justify-content-center align-items-center gap-4 flex-grow-1">
            <i class="fa-solid fa-cannabis home-icon"></i>
            <span class="home-icon-des">Hemp Fiber</span>
            <p class="home-icon-content">Our hemp products offer durability, sustainability, and eco-friendliness, making them ideal for environmentally conscious consumers.</p>
        </div>

        <div class="d-flex flex-column justify-content-center align-items-center gap-4 flex-grow-1">
            <i class="fa-solid fa-leaf home-icon"></i>
            <span class="home-icon-des">Eco-friendly</span>
            <p class="home-icon-content">We focus on sustainability, using eco-friendly materials and practices in our manufacturing process to minimize our environmental impact.</p>
        </div>

        <div class="d-flex flex-column justify-content-center align-items-center gap-4 flex-grow-1">
            <i class="fa-solid fa-hand-holding-heart home-icon"></i>
            <span class="home-icon-des">Handmade</span>
            <p class="home-icon-content">Our handcrafted products are a testament to our unwavering dedication and wholehearted support for traditional craftsmanship.</p>
        </div>
    </div>
</section>

      <!-- new -->
      <section id="new" class="w-100">
        <div class="row p-2 m-2 ">
          <!-- one -->
          <div class="one col-lg-4 col-md-12 col-sm-12 ">
            <img class="img-fluid" src="images\hempbag1-Photoroom.png-Photoroom.png">
            <div class="details">
              <h2>Backpacks</h2>
              <a href="shop.php"> <button class="buy-btn">Buy Now</button></a>
            </div>
          </div>
          <!-- two -->
          <div class="one col-lg-4 col-md-12 col-sm-12 p-0 ">
            <img class="img-fluid" src="images\hemptote3-removebg-preview.png">
            <div class="details ">
              <h2>Tote bags</h2>
              <a href="shop.php"> <button class="buy-btn">Buy Now</button></a>
            </div>
          </div>
          <!-- three -->
          <div class="one col-lg-4 col-md-12 col-sm-12 p-0 ">
            <img class="img-fluid" src="images\string bag-Photoroom.png-Photoroom.png">
            <div class="details">
              <h2>String Bags</h2>
              <a href="shop.php"> <button class="buy-btn">Buy Now</button></a>
            </div>
          </div>
        </div>
      </section>
      <!-- feature -->
      <section id="featured" class="my-5 pb-5 ">
        <div class="ml-5 text-center mt-5 py-5 ">
          <h3>Our Featured </h3>
          <hr class="mx-auto">
          <p>Here you can check out our new featured products.</p>
        </div>
        <div class="d-flex justify-content-evenly featured-container gap-5">
          <?php include('server/get_featured_products.php');?>
          <?php
            while($row =$featured_products->fetch_assoc()){
          ?>
        <a href="<?php echo "single_product.php?product_id=". $row ['product_id']; ?>" class="product-link product  col-lg-3 col-md-4 col-sm-12" style="width:18rem;">
            <img src="images/<?php echo $row['product_image']; ?>" class="img-fluid mb-3" style="width:18rem; height:18rem; object-fit: cover">
            <div style="display:flex; justify-content:space-between; align-items:center">
              <div>
                <h4 class="p-name"><?php  echo $row['product_name']; ?></h4>
                <h5 class="p-price text-success">Rs.<?php echo $row['product_price'];?></h5>
              </div>
              <form action="cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?> ">
                <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                
                <button type="submit" name="add_to_cart" style="border-radius: 12px"><i class="fa-solid fa-cart-shopping"></i></button>
              </form>
            </div>
            </a>
        <?php } ?>
        </div>
      </section>


<div class="swiper mySwiper">
    <div class="swiper-wrapper">
  <div id="banner1" class="swiper-slide">
  <div class="adcontainer banner">
    <h4 class="mid-season">ECO-FRIENDLY CHOICE</h4>
    <h1>Discover Sustainable Style</h1>
    <p>Elevate your look with our hemp bags</p>

  </div>
</div>
<div id="banner2" class="swiper-slide">
  <div class="adcontainer banner">
    <h4 class="mid-season">NATURAL BEAUTY</h4>
    <h1>Explore Earth-Friendly Fashion</h1>
    <p>Embrace eco-conscious living</p>

  </div>
</div>
<div id="banner3" class="swiper-slide">
  <div class="adcontainer banner">
    <h4 class="mid-season">STYLISH & SUSTAINABLE</h4>
    <h1>Elevate Your Everyday</h1>
    <p>Upgrade to hemp bags for a greener future</p>
   
  </div>
</div>
    </div>
    <!-- <div class="swiper-button-next" style="color:lightgreen"></div>
    <div class="swiper-button-prev" style="color:lightgreen"></div> -->
  </div>

<button class="gototop" id="gototop"><i class="fa-solid fa-chevron-up"></i></button>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <script>
    var swiper = new Swiper(".mySwiper", {
      loop:true,
      autoplay: {
      delay: 5000, 
      disableOnInteraction: false,
    },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  </script>
<script>
  const topbtn = document.getElementById('gototop');
  topbtn.addEventListener('click', ()=>  window.scrollTo({
    top: 0,
    behavior: "smooth",
  }))
  console.log(topbtn);

</script>
<?php include('layouts/footer.php'); ?>