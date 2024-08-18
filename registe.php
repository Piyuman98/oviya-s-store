<?php
session_start(); // Start session to manage user sessions

@include 'config.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to home page if logged in
    exit();
}

// Registration form submission handling
if (isset($_POST['register_btn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate user input (you can add more validation as needed)
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif ($password != $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email already exists in the database
        $check_query = "SELECT * FROM `users` WHERE email = '$email'";
        $result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            $error = "Email already exists!";
        } else {
            // Hash password before storing in database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into `users` table
            $insert_query = "INSERT INTO `users` (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
            if (mysqli_query($conn, $insert_query)) {
                // Registration successful, redirect to login page
                header('Location: login.php');
                exit();
            } else {
                $error = "Registration failed. Please try again later.";
            }
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
    <title>Register</title>
    <!-- Add your CSS links here -->
</head>
<body>

    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error)) : ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="register_btn">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

</body>
</html>
