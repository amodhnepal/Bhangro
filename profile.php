<?php
include('server/connection.php');
session_start();
if(!isset($_SESSION['logged_in'])){
  header('location: Login.php');
  exit;
}

if(isset($_POST['change_password'])){
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $user_email = $_SESSION['user_email'];

  if($password !== $confirm_password) {
    header('location: profile.php?error=passwords dont match');
    exit;
  }

  // Check if password length is less than 6 characters
  if(strlen($password) < 6) {
    header('Location: profile.php?error=Password must be at least 6 characters long');
    exit;
  }

  // Encrypt the password
  $password = md5($_POST['password']);
  
  // Update password in the database
  $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
  $stmt->bind_param('ss', $password, $user_email);  
  if($stmt->execute()){
    header('location: profile.php?message=password updated successfully');
  } else {
    header('location: profile.php?error=could not update password');
  }
  exit;
}

// Fetch user information
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
$address = isset($_SESSION['address']) ? $_SESSION['address'] : '';
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
?>

<?php include('layouts/header.php'); ?>

<style>
    .account-info p{
        color:#555;
    }
</style>

<!-- Profile -->
<section class="my-5 py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card shadow">
          <div class="card-body">
            <h3 class="card-title text-center mb-4">Account Information</h3>
            <div class="account-info">
              <p><strong>User Id:</strong> <?php echo $user_id; ?></p>
              <p><strong>Name:</strong> <?php echo $user_name; ?></p>
              <p><strong>Email:</strong> <?php echo $user_email; ?></p>
              <p><strong>Address:</strong> <?php echo $address; ?></p>
              <p><strong>Phone:</strong> <?php echo $phone; ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card shadow">
          <div class="card-body">
            <h3 class="card-title text-center mb-4">Change Password</h3>
            <form id="password-form" method="POST" action="profile.php">
              <p class="text-center" style="color:red;"><?php if(isset($_GET['error'])) echo $_GET['error']; ?></p>
              <p class="text-center" style="color:green;"><?php if(isset($_GET['message'])) echo $_GET['message']; ?></p>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
              </div>
              <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
              </div>
              <div class="form-group mb-2">
                <button type="submit" class="btn btn-primary btn-block" name="change_password">Change Password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('layouts/footer.php'); ?>
