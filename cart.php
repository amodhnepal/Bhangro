<?php
include('server/connection.php');
include('layouts/header.php');

if (!isset($_SESSION['logged_in'])) {
  header('location: Login.php');
  exit;
}

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
  $product_id = $_POST['product_id'];
  $quantity = $_POST['quantity'];

  // Ensure quantity is at least 1
  $quantity = max(1, $quantity);

  if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['product_quantity'] = $quantity;
    calculateTotalCart();
  }
}

if (isset($_POST['clear-cart'])) {
  unset($_SESSION['cart']);
  unset($_SESSION['total']);
  header("Location: cart.php");
  exit;
}

if (isset($_POST['add_to_cart'])) {
  $product_id = $_POST['product_id'];
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $stock = $_POST['stock'];
  $product_image = $_POST['product_image'];
  $product_quantity = max(1, $_POST['product_quantity']); // Default to 1 if not set

  $product_array = array(
    'product_id' => $product_id,
    'product_name' => $product_name,
    'product_price' => $product_price,
    'stock' => $stock,
    'product_image' => $product_image,
    'product_quantity' => $product_quantity
  );

  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
  }

  if (!array_key_exists($product_id, $_SESSION['cart'])) {
    $_SESSION['cart'][$product_id] = $product_array;
  } else {
    echo '<script>alert("Product already added to cart.")</script>';
    echo '<script>window.location="index.php"</script>';
    exit;
  }
}

if (isset($_POST['remove_product'])) {
  $product_id = $_POST['product_id'];
  unset($_SESSION['cart'][$product_id]);
  calculateTotalCart();
}

if (isset($_POST['edit_quantity'])) {
  $product_id = $_POST['product_id'];
  $product_quantity = max(1, $_POST['product_quantity']); // Ensure quantity is at least 1
  if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['product_quantity'] = $product_quantity;
    calculateTotalCart();
  }
}

function calculateTotalCart() {
  $total = 0;
  if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
      $total += $value['product_price'] * $value['product_quantity'];
    }
  }
  $_SESSION['total'] = $total;
}

calculateTotalCart();
?>

<!-- Cart -->
<section class="h-100 gradient-custom " style="margin-top: 100px">
  <div class="container py-5">
    <div class="row d-flex justify-content-center my-4">
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Cart items</h5>
          </div>
          <div class="card-body">
            <!-- Single item -->
            <?php if (isset($_SESSION["cart"])) { ?>
              <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                <div class="row border-top-0 border-right-0 border-left-0 py-2 d-flex gap-2 justify-content-between align-items-center">
                  <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                    <!-- Image -->
                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                      <img src="images/<?php echo $value['product_image']; ?>" class="w-100" alt="">
                      <a href="#!">
                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                      </a>
                    </div>
                    <!-- Image -->
                  </div>

                  <div class="col-lg-2 col-md-2 mb-4 mb-lg-0">
                    <!-- Data -->
                    <p style="margin-bottom:1px; color:black; font-size:20px"><strong><?php echo $value['product_name']; ?></strong></p>
                    <p style="margin-bottom:1px; color:black;"><strong>Color: </strong>blue</p>
                    <p class="text-start" style="color:green;">
                      <strong id="price_<?php echo $value['product_id']; ?>">
                        <?php echo $value['product_price'] * $_SESSION['cart'][$value['product_id']]['product_quantity']; ?>
                      </strong>
                    </p>
                    <!-- Data -->
                  </div>

                  <div class="col-lg-2 col-md-2 mb-4 mb-lg-0">
                    <!-- Quantity -->
                    <div class="d-flex mb-4" style="display:flex;">
                      <div class="quantity-btn" onclick="decrementQuantity(this)">
                        <i class="fas fa-minus"></i>
                      </div>
                      <form action="cart.php" method="POST" id="quantityForm_<?php echo $value['product_id']; ?>" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
                        <input id="quantity_<?php echo $value['product_id']; ?>" min="1" name="quantity"
                          value="<?php echo $_SESSION['cart'][$value['product_id']]['product_quantity']; ?>"
                          type="number" class="form-control" onchange="updatePrice(this)"
                          data-price="<?php echo $value['product_price']; ?>"
                          data-stock="<?php echo $value['stock']; ?>" 
                          />
                      </form>
                      <div class="quantity-btn" onclick="incrementQuantity(this)">
                        <i class="fas fa-plus"></i>
                      </div>
                    </div>
                  </div>

                  <form action="cart.php" method="POST"
                    class="col-lg-2 col-md-2 mb-4 mb-lg-0 d-flex justify-content-center align-items-center">
                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
                    <button class="btn-sm me-1 mb-2 d-flex gap-2 justify-content-center align-items-center"
                      style="color:#D11A2A; height: auto; display: inline-block; background: none; border: none;"
                      type="submit" name="remove_product">
                      <i class="fas fa-trash" style="font-size:20px"></i>
                    </button>
                  </form>
                </div>
              <?php } ?>
            <?php } else { ?>
              <div class="d-flex justify-content-center">Cart is empty</div>
            <?php } ?>
          </div>

          <?php if (!empty($_SESSION['cart'])) { ?>
            <form action="" method="POST" class="d-flex justify-content-end">
              <input type="submit" name="clear-cart" value="Clear Cart" style="border:none; background: none; color:red; margin:20px"/>
            </form>
          <?php } ?>
        </div>

        <div class="card mb-4 mb-lg-0">
          <div class="card-body">
            <h5 class="mb-4">We accept</h5>
            <div style="display:flex; gap:25px">
              <img class="me-2" width="45px" src="./images/khalti.png" alt="khalti img" />
              <img class="me-2" width="45px" src="./images/cod.png" alt="cash on delivery" />
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Summary</h5>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0"></li>
              <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                <strong>Total amount</strong>
                <span><strong>
                  <?php if (isset($_SESSION['cart'])) { ?>
                    Rs. <?php echo $_SESSION['total']; ?>
                  <?php } ?>
                </strong></span>
              </div>
            </ul>

            <form action="place_order.php" method="POST" style="display: flex; flex-direction: column">
              <span style="text-align: center; font-size:24px; font-weight:semi-bold; text-transform: uppercase; margin-bottom: 10px">Update Billing Address</span>
              <label for="address" style="font-size:18px; margin-bottom:5px;">Delivery Address</label>
              <input type="text" id="address" name="address" value="<?php echo $_SESSION['address']; ?>" style="margin-bottom: 10px; padding:4px; border-radius: 3px; font-size:18px;">
              <label for="phone" style="font-size:18px; margin-bottom:5px;">Phone Number</label>
              <input type="text" id="phone" name="phone" value="<?php echo $_SESSION['phone']; ?>" style="margin-bottom: 10px; padding:4px; border-radius: 3px; font-size:18px;">
              <div style="display:flex; gap:40px">
                <div style="display:flex; gap:10px;">
                  <input type="radio" value="place_order" name="order" id="place_order" checked>
                  <label for="place_order">Pay with khalti</label>
                </div>
                <div style="display:flex; gap:10px;">
                  <input type="radio" value="cod" name="order" id="cash_on_delivery">
                  <label for="cash_on_delivery">Cash on delivery</label>
                </div>
              </div>
              <input type="submit" class="btn btn-primary btn-lg btn-block" value="Go to checkout" name="checkout">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('layouts/footer.php'); ?>

<script>
function updatePrice(input) {
  var productId = input.id.split('_')[1];
  var quantity = parseInt(input.value);
  var initialPrice = parseFloat(input.getAttribute('data-price'));
  var stock = parseInt(input.getAttribute('data-stock'));

  if (quantity > stock) {
    input.value = stock;
    quantity = stock;
  }

  var totalPrice = initialPrice * quantity;
  document.getElementById('price_' + productId).textContent = totalPrice.toFixed(2);

  // Submit the form to update the session variable
  document.getElementById('quantityForm_' + productId).submit();

  // Update button state and input field
  updateButtonState(productId);
}

function incrementQuantity(btn) {
  var input = btn.parentNode.querySelector('input[type=number]');
  var currentQuantity = parseInt(input.value);
  var stock = parseInt(input.getAttribute('data-stock'));

  if (currentQuantity < stock) {
    input.stepUp();
    updatePrice(input);
  }

  updateButtonState(input.id.split('_')[1]); // Ensure button state is updated
}

function decrementQuantity(btn) {
  var input = btn.parentNode.querySelector('input[type=number]');
  if (parseInt(input.value) > 1) {
    input.stepDown();
    updatePrice(input);
  }

  updateButtonState(input.id.split('_')[1]); // Ensure button state is updated
}

function updateButtonState(productId) {
  var input = document.getElementById('quantity_' + productId);
  var quantity = parseInt(input.value);
  var stock = parseInt(input.getAttribute('data-stock'));
  var incrementButton = document.querySelector('#quantityForm_' + productId + ' .quantity-btn:last-child');
  var decrementButton = document.querySelector('#quantityForm_' + productId + ' .quantity-btn:first-child');

  if (quantity >= stock) {
    incrementButton.classList.add('disabled');
    incrementButton.style.cursor = 'not-allowed !important'; // Force cursor style
    input.setAttribute('disabled', true);
  } else {
    incrementButton.classList.remove('disabled');
    incrementButton.style.cursor = 'pointer'; // Restore cursor
    input.removeAttribute('disabled');
  }

  // Disable decrement button if quantity <= 1
  if (quantity <= 1) {
    decrementButton.classList.add('disabled');
    decrementButton.style.cursor = 'not-allowed !important'; // Force cursor style
  } else {
    decrementButton.classList.remove('disabled');
    decrementButton.style.cursor = 'pointer'; // Restore cursor
  }

  // Set min and max attributes for input
  input.setAttribute('min', 1);
  input.setAttribute('max', stock);
}

// Initial update for all quantities
document.querySelectorAll('input[type=number]').forEach(input => {
  updateButtonState(input.id.split('_')[1]);
});

</script>
