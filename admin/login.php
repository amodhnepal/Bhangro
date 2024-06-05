<?php
session_start();

include ('../server/connection.php');

if(isset($_SESSION['admin_logged_in'])){
    header('location: index.php');
    exit;
}

//check whether the submit button is clicked or not
if(isset($_POST['login_btn'])){
    // get data from login form
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $stmt = $conn->prepare("SELECT admin_id, admin_name, admin_email, admin_password FROM admins WHERE admin_email = ? AND admin_password=? LIMIT  1");
    $stmt->bind_param('ss', $email, $password);
    
    if ($stmt->execute()) {
        $stmt->bind_result($admin_id, $admin_name, $admin_email, $admin_password);
        $stmt->store_result();
    
        if ($stmt->num_rows() ==  1) {
            $stmt->fetch();
            // Corrected the variable name from $rows to $admin
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_name'] = $admin_name;
            $_SESSION['admin_email'] = $admin_email;
            $_SESSION['admin_logged_in'] = TRUE;

            header('location:index.php?login_success=logged in');
        } else {
            header('location: login.php?error= could not verify your account');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Admin Login</title>
    <style>
        /* Add custom styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
            flex-direction: column;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .error-message {
            color: red;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        .button-container{
            display: flex;
            justify-content: end;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <form action="login.php" method="post" id="login-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <?php if(isset($_GET['error'])): ?>
                <p class="error-message"><?php echo $_GET['error']; ?></p>
            <?php endif; ?>
            <div class="button-container">
                <input type="submit" class="submit-btn" name="login_btn" value="Login">
            </div>
        </form>
    </div>
</body>
</html>

