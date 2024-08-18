<?php
session_start(); // Start session to manage user sessions

@include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get user ID from session

// Add to cart logic
if (isset($_POST['add_to_cart_btn'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if item already exists in the cart
    $check_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id' AND product_id = '$product_id'");
    if (mysqli_num_rows($check_query) > 0) {
        // Update quantity if item exists
        mysqli_query($conn, "UPDATE `cart` SET quantity = quantity + $quantity WHERE user_id = '$user_id' AND product_id = '$product_id'");
    } else {
        // Insert new item into the cart
        mysqli_query($conn, "INSERT INTO `cart` (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')");
    }

    header('Location: cart1.php'); // Redirect to cart page
    exit();
}

// Update cart item quantity
if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id' AND user_id = '$user_id'");
    header('Location: cart1.php');
    exit();
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id' AND user_id = '$user_id'");
    header('Location: cart1.php');
    exit();
}

// Clear cart for the user
if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");
    header('Location: cart1.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping Cart</title>
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- Custom CSS file link -->
   
   <style>
       body {
           font-family: Arial, sans-serif;
           background-color: #f7f7f7;
           margin: 0;
           padding: 0;
       }
       .container {
           max-width: 1200px;
           margin: 50px auto;
           padding: 20px;
           background-color: #fff;
           box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
       }
       .heading {
           text-align: center;
           margin-bottom: 20px;
           font-size: 2rem;
           color: #333;
       }
       table {
           width: 100%;
           border-collapse: collapse;
           margin-bottom: 20px;
       }
       table, th, td {
           border: 1px solid #ddd;
       }
       th, td {
           padding: 15px;
           text-align: center;
       }
       th {
           background-color: #f4f4f4;
       }
       .product-img {
           height: 100px;
       }
       .option-btn, .delete-btn, .btn {
           display: inline-block;
           padding: 10px 20px;
           color: #fff;
           background-color: #333;
           text-decoration: none;
           border-radius: 5px;
           transition: background-color 0.3s;
       }
       .option-btn:hover, .delete-btn:hover, .btn:hover {
           background-color: #555;
       }
       .disabled {
           background-color: #ccc;
           pointer-events: none;
       }
       .checkout-btn {
           text-align: right;
       }
   </style>
</head>
<body>
<div class="container">
   <section class="shopping-cart">
      <h1 class="heading">Shopping Cart</h1>
      <table>
         <thead>
            <tr>
               <th>Image</th>
               <th>Name</th>
               <th>Price</th>
               <th>Quantity</th>
               <th>Total Price</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php
            // Select cart items for the current user
            $select_cart = mysqli_query($conn, "SELECT cart.*, products.name AS product_name, products.price AS product_price, products.image AS product_image FROM `cart` LEFT JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = '$user_id'");
            $grand_total = 0;
            if(mysqli_num_rows($select_cart) > 0){
               while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                  $sub_total = $fetch_cart['product_price'] * $fetch_cart['quantity'];
                  $grand_total += $sub_total;
                  ?>
                  <tr>
                     <td><img src="uploaded_img/<?php echo $fetch_cart['product_image']; ?>" class="product-img" alt=""></td>
                     <td><?php echo $fetch_cart['product_name']; ?></td>
                     <td>$<?php echo number_format($fetch_cart['product_price'], 2); ?>/-</td>
                     <td>
                        <form action="" method="post">
                           <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                           <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                           <input type="submit" value="Update" name="update_update_btn">
                        </form>
                     </td>
                     <td>$<?php echo number_format($sub_total, 2); ?>/-</td>
                     <td><a href="cart1.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?')" class="delete-btn"><i class="fas fa-trash"></i> Remove</a></td>
                  </tr>
                  <?php
               }
            } else {
               echo "<tr><td colspan='6'>Your cart is empty!</td></tr>";
            }
            ?>
            <tr class="table-bottom">
               <td><a href="index.php" class="option-btn" style="margin-top: 0;">Continue Shopping</a></td>
               <td colspan="3">Grand Total</td>
               <td>$<?php echo number_format($grand_total, 2); ?>/-</td>
               <td><a href="cart1.php?delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="delete-btn"><i class="fas fa-trash"></i> Delete All </a></td>
            </tr>
         </tbody>
      </table>
      <div class="checkout-btn">
         <a href="checkout1.php" class="btn <?= ($grand_total > 0) ? '' : 'disabled'; ?>">Proceed to Checkout</a>
      </div>
   </section>
</div>
<!-- Custom JS file link -->
<script src="js/script.js"></script>
</body>
</html>
