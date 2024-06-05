<?php
include('server/connection.php');
session_start(); // Ensure session is started before using session variables

if (isset($_SESSION['logged_in'])) {
    header('location:account.php');
    exit;
}

$errors = [];

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $token = bin2hex(random_bytes(50));

    if ($password !== $confirmPassword) {
        $errors['confirmPassword'] = 'Passwords don\'t match';
    } else if (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters long';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email address';
    }

    if (!preg_match("/^(98|97)[0-9]{8}$/", $phone)) {
        $errors['phone'] = 'Invalid phone number';
    }

    if (empty($errors)) {
        $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email=?");
        $stmt1->bind_param('s', $email);
        $stmt1->execute();
        $stmt1->bind_result($num_rows);
        $stmt1->store_result();
        $stmt1->fetch();

        if ($num_rows != 0) {
            $errors['email'] = 'Email already exists';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, address, phone, user_password, token, verified) VALUES(?,?,?,?,?,?,0)");
            $stmt->bind_param('ssssss', $name, $email, $address, $phone, $hashed_password, $token);
            if ($stmt->execute()) {
                header('location:register.php?success=Account created successfully');
                exit;
            } else {
                $errors['general'] = 'Could not create account at the moment';
            }
        }

        $stmt1->close();
    }
}

include('layouts/header.php'); // Include header after header logic
?>

<style>
#register-form {
    margin-top: 30px;
}

form label {
    font-weight: bold;
}

.invalid-feedback {
    color: red;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.btn-link {
    color: #007bff;
    text-decoration: none;
}

.btn-link:hover {
    text-decoration: underline;
}
</style>

<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold">Register</h2>
        <hr class="mx-auto" style="width: 50%;">
    </div>
    <div class="mx-auto container w-50">
        <form id="register-form" action="register.php" method="POST" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="register-name">Name</label>
                <input type="text" class="form-control" id="register-name" name="name" placeholder="Enter your name" required>
                <div class="invalid-feedback">Please enter your name.</div>
            </div>
            <div class="form-group">
                <label for="register-email">Email</label>
                <input type="email" class="form-control" id="register-email" name="email" placeholder="Enter your email" required>
                <?php if(isset($errors['email'])): ?>
                    <div class="invalid-feedback" style="display: block;"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
                <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <div class="form-group">
                <label for="register-address">Address</label>
                <input type="text" class="form-control" id="register-address" name="address" placeholder="Enter your address" required>
                <div class="invalid-feedback">Please enter your address.</div>
            </div>
            <div class="form-group">
                <label for="register-phone">Phone</label>
                <input type="tel" class="form-control" id="register-phone" name="phone" placeholder="Enter your phone number" required>
                <?php if(isset($errors['phone'])): ?>
                    <div class="invalid-feedback" style="display: block;"><?php echo $errors['phone']; ?></div>
                <?php endif; ?>
                <div class="invalid-feedback">Please enter a valid phone number.</div>
            </div>
            <div class="form-group">
                <label for="register-password">Password</label>
                <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
                <?php if(isset($errors['password'])): ?>
                    <div class="invalid-feedback" style="display: block;"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
                <div class="invalid-feedback">Please enter a password.</div>
            </div>
            <div class="form-group">
                <label for="register-confirm-password">Confirm Password</label>
                <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required>
                <?php if(isset($errors['confirmPassword'])): ?>
                    <div class="invalid-feedback" style="display: block;"><?php echo $errors['confirmPassword']; ?></div>
                <?php endif; ?>
                <div class="invalid-feedback">Please confirm your password.</div>
            </div>
            <?php if(isset($errors['general'])): ?>
                <div class="form-group">
                    <div class="invalid-feedback" style="display: block; text-align: center;"><?php echo $errors['general']; ?></div>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="register">Register</button>
            </div>
            <div class="form-group" style="text-align:center">
                <a href="shop.php" class="btn-link">Already have an account? Login</a>
            </div>
        </form>
    </div>
</section>

<?php include('layouts/footer.php'); ?>
