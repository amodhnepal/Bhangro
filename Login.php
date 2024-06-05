<?php 
session_start();
include('server/connection.php');
if (isset($_SESSION['logged_in'])) {
    header("Location: profile.php");
    exit();
}

if(isset($_POST['login_btn'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $sql1 = "SELECT * FROM users WHERE user_email='$email' AND user_password='$password'";
    $res1 = mysqli_query($conn, $sql1);
    $count1 = mysqli_num_rows($res1);

    if($count1 > 0){
        $rows = mysqli_fetch_assoc($res1);
        $_SESSION['user_id'] = $rows['user_id'];
        $_SESSION['user_name'] = $rows['user_name'];
        $_SESSION['user_email'] = $rows['user_email'];
        $_SESSION['address'] = $rows['address'];
        $_SESSION['phone'] = $rows['phone'];
        $_SESSION['logged_in'] = TRUE;
        header('location:profile.php');
        exit(); // Ensure the script stops executing after redirect
    } else {
        // Redirect to the login page with an error message
        header("Location: Login.php?error=Email or password is incorrect.");
        exit();
    }
}
?>

<?php include('layouts/header.php'); ?>
<!-- Login -->
<section class="my-5 py-5">
    <div class="text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Login</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto w-25">
        <!-- Form -->
        <form id="login-form" action="Login.php" method="POST" >
          <p style="color:red " class="text_center"><?php if(isset($_GET['error'])){echo $_GET['error'];}    ?></p>
            <div class="form-group">
                <label >Email</label>
                <input type="text" class="form-control" id="login-email" name="email" placeholder="email" required>
            </div>
            <div class="form-group">
                <label >Password</label>
                <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login" >
            </div>
            <div class="form-group">
                <a id="register-url" href="register.php" class="btn">Don't have an account? Register</a>
            </div>
  
        </form>
    </div>
</section>
<?php include('layouts/footer.php'); ?>