<?php include('layouts/header.php')  ?>
<?php

include('server/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["username"]; 
    $email = $_POST["email"];
    $comment = $_POST["comment"];
    
    $sql = "INSERT INTO reviews (Name, Email, Comment) VALUES (?, ?, ?)";

  
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $comment);

 
    if ($stmt->execute()) {
     
        echo "Review submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->error;
    }
    $stmt->close();
}
?>





<!-- contact -->

<style>
#contact {
    background-color: #fff;
}

#review-section {
    background-color: #fff;
    padding: 40px;
    border-radius: 10px;
}

#review-section h2 {
    margin-bottom: 30px;
}

.main-container {
    box-shadow: 10px 10px 10px 10px rgba(0, 0, 0, 0.16);
    width: 1100px;
    display: flex;
    justify-content: center;
    margin: auto;
}
</style>

<section class="d-flex main-container " style="margin-top:150px; border-radius:10px">
    <section id="contact" class=""
        style="width:500px;  background-image: linear-gradient(
      to bottom,
      rgba(0, 0, 0, 0.5) 40%,
      rgba(0, 0, 0, 0)
    ),
    url('./images/contact.jpg'); background-size:cover; background-position:top; padding:40px;display:flex; flex-direction:column; justify-content:space-between; border-radius: 10px 0 0 10px">
        <div class="container">
            <h3 style="text-align: center; color: white; margin-bottom: 30px">Contact Us</h3>
            <div class="d-flex justify-content-center ">
                <div class="d-flex flex-column justify-content-center  mx-auto" style="width:auto">
                    <p class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-phone" style="color:#eee; font-size:1.5rem"></i>
                        <span style="color:#eee; font-size:1.5rem">9862583199</span>
                    </p>
                    <p class="d-flex align-items-center gap-2">

                        <i class="fa-solid fa-envelope" style="color:#eee; font-size:1.5rem"></i>

                        <span style="color:#eee; font-size:1.5rem">bhangro@gmail.com</span>
                    </p>
                    <p class="d-flex align-items-center gap-2">

                        <i class="fa-solid fa-location-dot" style="color:#eee; font-size:1.5rem"></i>

                        <span style="color:#eee; font-size:1.5rem">Budhanilkantha, Kathmandu</span>
                    </p>
                </div>
            </div>
        </div>
        <div style="display:flex; justify-content:center; gap: 2rem;">
            <i class="fa-brands fa-instagram insta" style="font-size:2rem; transition:color 0.3s ease-in"></i>
            <i class="fa-brands fa-facebook fb" style="font-size:2rem; transition:color 0.3s ease-in"></i>
            <i class="fa-brands fa-twitter twitter" style="font-size:2rem; transition:color 0.3s ease-in"></i>
        </div>
    </section>

    <section id="review-section" class="">
        <?php if(isset($_SESSION['user_name'])){?>
        <div class="container">
            <h2 class="text-center">Leave a Review</h2>
            <form action="#" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="<?php echo $_SESSION['user_name'] ?>" required readonly>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo $_SESSION['user_email'] ?>" required readonly>
                </div>

                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <?php  }else{ ?>
        <span>Please Login to contact us</span>
        <?php } ?>


    </section>
</section>

<?php include('layouts/footer.php'); ?>