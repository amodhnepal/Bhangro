<?php
// Include necessary files
include('header.php');
include('sidemenu.php');

// Check if the admin is logged in
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true){
    header('location:login.php');
    exit;
}

// Retrieve the admin information from the session
$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];
$admin_email = $_SESSION['admin_email'];

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['change_password'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password !== $confirm_password) {
            echo "Error: The new password and confirmation do not match.";
        } else {
            // Hash the new password securely
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $stmt = $conn->prepare("UPDATE admins SET admin_password = ? WHERE admin_id = ?");
            $stmt->bind_param('si', $hashed_password, $admin_id);

            if ($stmt->execute()) {
                echo "Password changed successfully.";
            } else {
                echo "Error: Could not change password.";
            }
        }
    }
}

// Handle addition of a new admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_admin'])) {
    // Retrieve form data
    $username = $_POST['admin_name'];
    $email = $_POST['admin_email'];
    $password = $_POST['admin_password'];

    // Hash the password securely
    $hashed_password = md5($password);

    // SQL query to insert new admin into the database
    $sql = "INSERT INTO admins (admin_name, admin_email, admin_password) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "New admin added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<section class="ml-5 my-5 py-5" style="margin-left: 350px">
  <div class="" style="box-shadow: none">
    <div class="d-flex flex-column justify-content-center align-items-center">
      <div class="col-lg-6">
        <div class="card shadow">
          <div class="card-body">
            <h3 class="card-title text-center mb-4">Your Details</h3>
            <div class="admin-details-container">
              <p><strong>ID:</strong> <?php echo $admin_id; ?></p>
              <p><strong>Name:</strong> <?php echo $admin_name; ?></p>
              <p><strong>Email:</strong> <?php echo $admin_email; ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card shadow">
          <div class="card-body">
            <h3 class="card-title text-center mb-4">Add New Admin</h3>
            <form method="post" action="" class="add-admin-container d-flex flex-column gap-3">
              <div class="form-group">
                <label for="admin-name">Username</label>
                <input type="text" class="form-control" id="admin-name" name="name" placeholder="Admin name" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Admin email" required>
              </div>
              <div class="form-group">
                <label for="admin-password">Password</label>
                <input type="password" class="form-control" id="admin-password" name="color" placeholder="********" required>
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" style="grid-column: span 2; padding: 6px; background-color: green;" name="add_admin" value="Add Admin"/>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<style>

    /* .admin-container {
        display: flex;
        flex-direction: column;
        gap: 50px;
        justify-content: center;
        align-items: center;
        margin-left: 300px;
    }

    .admin-details-container{
        padding: 30px;
        box-shadow: 10px 10px 20px 4px rgba(0, 0, 0, 0.187);
        width: 350px;
        margin-top: 50px;

    }



    .admin-details-container .main-text {
        display: grid;
        grid-template-columns: 1fr 4fr;
        text-align: start;
        color: green;
        gap: 10px;
        margin: 0;
        font-size: 1.2rem;
    }
    .admin-details-container .main-text span{
        font-weight: bold;
    }

    .account-heading{
        margin:0;
        margin-bottom: 20px;
        text-align: center;
    }

    .add-admin-container{
        margin-top: 50px;
        width: 400px;
        padding: 30px;
        box-shadow: 10px 10px 20px 4px rgba(0, 0, 0, 0.187);
    }

    form {
        margin-bottom: 20px;
    }

    input[type="text"], input[type="password"], input[type="submit"] {
        display: block;
        margin-bottom: 10px;
        padding: 8px;
    } */
</style>


