<?php
session_start(); // Start session to manage user sessions

@include 'config.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to home page if logged in
    exit();
}

// Login form submission handling
if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate user input (you can add more validation as needed)
    if (empty($email) || empty($password)) {
        $error = "Email and password are required!";
    } else {
        // Check if user exists in the database
        $query = "SELECT * FROM `users` WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            // User exists, verify password
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                // Password is correct, log in the user
                $_SESSION['user_id'] = $user['user_id'];
                header('Location: index.php'); // Redirect to home page after successful login
                exit();
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "User not found!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add your CSS links here -->
</head>
<body>

    <div class="container">
        <h2>Login</h2>
        <h3>Home page<a href="index.php">Home here</a></h3> 
        <?php if (isset($error)) : ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login_btn">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        
    </div>
   

</body>
</html>
