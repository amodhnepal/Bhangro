  <?php
session_start();
include('server/connection.php');
if(isset($_SESSION['logged_in'])){
  unset($_SESSION['logged_in']);
  unset($_SESSION['user_email']);
  unset($_SESSION['user_name']);
  unset($_SESSION['address']);
  unset($_SESSION['phone']);
  header('location:Login.php');
  exit;
}
  ?>