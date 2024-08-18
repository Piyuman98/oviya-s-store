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
<html>
	<head>
		<meta charset="utf-8">
		<title>RegistrationForm by Oviya's Store</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
		
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="css/style2.css">
	</head>

	<body>

		<div class="wrapper" style="background-image: url('images/bg-registration-form-2.jpg');">
			<div class="inner">
				<form action="" method="post">
					<h3>Registration Form</h3>
					<?php if (isset($error)) : ?>
						<p><?php echo $error; ?></p>
					<?php endif; ?>
					<div class="form-group">
						<div class="form-wrapper">
							<label for="">First Name</label>
							<input type="text" class="form-control" id="name" name="name" required>
						</div>
						<div class="form-wrapper">
							<label for="">Last Name</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-wrapper">
						<label for="">Email</label>
						<input type="email" class="form-control" id="email" name="email" required>
					</div>
					<div class="form-wrapper">
						<label for="">Password</label>
						<input type="password" class="form-control" id="password" name="password" required>
					</div>
					<div class="form-wrapper">
						<label for="">Confirm Password</label>
						<input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox"> I caccept the Terms of Use & Privacy Policy.
							<span class="checkmark"></span>
							
						</label>
						
					</div>
					<p>Already have an account? <a href="login.php">Login here</a></p>
					<button type="submit" name="register_btn" >Register Now</button>
				</form>
				
			</div>
		</div>
		
	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>