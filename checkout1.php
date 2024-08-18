<?php
session_start();

@include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['order_btn'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pin_code = $_POST['pin_code'];

    $cart_query = mysqli_query($conn, "SELECT cart.*, products.name AS product_name, products.price AS product_price FROM `cart` LEFT JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = '$user_id'");
    $price_total = 0;
    $total_products = "";

    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
            $product_name = $product_item['product_name'];
            $product_quantity = $product_item['quantity'];
            $product_price = $product_item['product_price'];
            $product_total_price = $product_price * $product_quantity;
            $price_total += $product_total_price;
            $total_products .= $product_name . ' (' . $product_quantity . '), ';
        }
        $total_products = rtrim($total_products, ', ');
    }

    $detail_query = mysqli_query($conn, "INSERT INTO `order` (user_id, name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price) VALUES ('$user_id', '$name','$number','$email','$method','$flat','$street','$city','$state','$country','$pin_code','$total_products','$price_total')");

    if ($detail_query) {
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");

        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Order Confirmation</title>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'>
            
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                    background: #f0f0f0;
                    margin: 0;
                }
                .order-message-container {
                    background: #fff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    max-width: 600px;
                    text-align: center;
                }
                .order-message-container h3 {
                    font-size: 1.5em;
                    margin-bottom: 20px;
                }
                .order-detail, .customer-details {
                    margin-bottom: 15px;
                }
                .order-detail span, .customer-details span {
                    display: block;
                    font-size: 1em;
                    margin: 5px 0;
                }
                .order-detail .total {
                    font-weight: bold;
                    font-size: 1.2em;
                }
                .btn {
                    display: inline-block;
                    padding: 10px 20px;
                    background: #333;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 1em;
                    text-align: center;
                    margin-top: 20px;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <div class='order-message-container'>
                <h3>Thank you for shopping!</h3>
                <div class='order-detail'>
                    <span>$total_products</span>
                    <span class='total'>Total: $$price_total/-</span>
                </div>
                <div class='customer-details'>
                    <p>Your name: <span>$name</span></p>
                    <p>Your number: <span>$number</span></p>
                    <p>Your email: <span>$email</span></p>
                    <p>Your address: <span>$flat, $street, $city, $state, $country - $pin_code</span></p>
                    <p>Your payment mode: <span>$method</span></p>
                    <p>(*Pay when product arrives*)</p>
                </div>
                <a href='index.php' class='btn'>Continue Shopping</a>
            </div>
        </body>
        </html>
        ";
        exit();
    } else {
        die('Query failed: ' . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .checkout-form h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }
        .checkout-form .flex {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .checkout-form .inputBox {
            flex: 1 1 45%;
            display: flex;
            flex-direction: column;
        }
        .checkout-form .inputBox span {
            font-size: 1em;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .checkout-form .inputBox input, .checkout-form .inputBox select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        .checkout-form .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            text-align: center;
            margin-top: 20px;
        }
        .display-order span {
            display: block;
            font-size: 1em;
            margin: 5px 0;
        }
        .grand-total {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 10px;
        }
        .order-message-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .message-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .message-container h3 {
            margin-bottom: 20px;
            font-size: 1.5em;
        }
        .message-container .order-detail,
        .message-container .customer-details {
            margin-bottom: 10px;
        }
        .message-container .order-detail span,
        .message-container .customer-details span {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <section class="checkout-form">
            <h1 class="heading">Complete Your Order</h1>
            <form action="" method="post">
                <div class="display-order">
                    <?php
                    $select_cart = mysqli_query($conn, "SELECT cart.*, products.name AS product_name, products.price AS product_price FROM `cart` LEFT JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = '$user_id'");
                    $grand_total = 0;
                    if(mysqli_num_rows($select_cart) > 0){
                        while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                            $total_price = $fetch_cart['product_price'] * $fetch_cart['quantity'];
                            $grand_total += $total_price;
                            ?>
                            <span><?= $fetch_cart['product_name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
                            <?php
                        }
                    } else {
                        echo "<div class='display-order'><span>Your cart is empty!</span></div>";
                    }
                    ?>
                    <span class="grand-total">Grand Total: $<?= number_format($grand_total); ?>/-</span>
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>Your Name</span>
                        <input type="text" placeholder="Enter your name" name="name" required>
                    </div>
                    <div class="inputBox">
                        <span>Your Number</span>
                        <input type="number" placeholder="Enter your number" name="number" required>
                    </div>
                    <div class="inputBox">
                        <span>Your Email</span>
                        <input type="email" placeholder="Enter your email" name="email" required>
                    </div>
                    <div class="inputBox">
                        <span>Payment Method</span>
                        <select name="method">
                            <option value="cash on delivery" selected>Cash on Delivery</option>
                            <option value="credit card">Credit Card</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <span>Address Line 1</span>
                        <input type="text" placeholder="e.g. Flat No." name="flat" required>
                    </div>
                    <div class="inputBox">
                        <span>Address Line 2</span>
                        <input type="text" placeholder="e.g. Street Name" name="street" required>
                    </div>
                    <div class="inputBox">
                        <span>City</span>
                        <input type="text" placeholder="e.g. Mumbai" name="city" required>
                    </div>
                    <div class="inputBox">
                        <span>State</span>
                        <input type="text" placeholder="e.g. Maharashtra" name="state" required>
                    </div>
                    <div class="inputBox">
                        <span>Country</span>
                        <input type="text" placeholder="e.g. India" name="country" required>
                    </div>
                    <div class="inputBox">
                        <span>Pin Code</span>
                        <input type="text" placeholder="e.g. 123456" name="pin_code" required>
                    </div>
                </div>
                <input type="submit" value="Order Now" name="order_btn" class="btn">
            </form>
        </section>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
