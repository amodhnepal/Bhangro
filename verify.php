<?php
include('server/connection.php');

if(isset($_GET['token'])){
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE token=? AND verified=0");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $stmt->fetch();
        $stmt = $conn->prepare("UPDATE users SET verified=1, token='' WHERE user_id=?");
        $stmt->bind_param('i', $user_id);
        if($stmt->execute()){
            header('location:login.php?message=Your email has been verified. You can now log in.');
        } else {
            header('location:login.php?error=Failed to verify your email.');
        }
    } else {
        header('location:login.php?error=Invalid or expired token.');
    }
} else {
    header('location:login.php?error=No token provided.');
}
?>
