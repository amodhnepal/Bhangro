<?php
session_start();
  include ('server/connection.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <!-- <link rel="stylesheet" type="text/css" > -->
    <style>
      body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
  margin: 0;
  padding: 0;
}

.main {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f2f2f2;
}

.form {
  background-color: #fff;
  padding: 40px;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.form p {
  font-size: 24px;
  font-weight: bold;
  color: #333;
  margin-bottom: 30px;
  text-align: center;
}

.form input[type="text"],
.form input[type="password"] {
  width: 100%;
  padding: 12px 20px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 16px;
  font-weight: bold;
  color: #333;
}

.form input[type="submit"] {
  width: 100%;
  padding: 12px 20px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
  font-weight: bold;
}

.form input[type="submit"]:hover {
  background-color: #45a049;
}

.form .message {
  margin-top: 20px;
  text-align: center;
}

.form .message a {
  color: #4CAF50;
  text-decoration: none;
  font-size: 16px;
  font-weight: bold;
}

.form .message a:hover {
  text-decoration: underline;
}
    </style>
</head>
<body>
  <div class="main">

    <div class="form">
    <p>User Login</p>
    <?php
      if(isset($_SESSION['register'])){
        echo $_SESSION['register'];
        unset($_SESSION['register']);
      }
      if(isset($_SESSION['error'])){
        echo $_SESSION['error'];
        unset($_SESSION['error']);
      }
    ?>


    <form action="<?php echo $home;?>user-login.php" method="POST" >
        <input type="text" name="username" placeholder="username" class="btn-input">

        <input type="password" name="password" placeholder="password" class="btn-input">

        <input type="submit" name="submit" value="Login" class="btnn">
        <p class="message">Not registered? <a href="register.php">Create an account</a></p>
        <p class="message">Admin? <a href="login.php">Login To Admin Pannel</a></p>
    </form>
    </div>
  </div>
</body>
</html>

