<?php
session_start();

@include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['add_to_cart'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']); // Sanitize input
    $product_quantity = 1;

    // Retrieve product details
    $product_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id'");
    if (mysqli_num_rows($product_query) > 0) {
        $product = mysqli_fetch_assoc($product_query);
        $product_name = $product['name'];
        $product_price = $product['price'];
        $product_image = $product['image'];

        // Check if the product is already in the user's cart
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id' AND product_id = '$product_id'");
        if (mysqli_num_rows($select_cart) > 0) {
            $message[] = 'Product already added to cart';
        } else {
            // Insert product into the user's cart
            $insert_product = mysqli_query($conn, "INSERT INTO `cart` (user_id, product_id, name, price, image, quantity) VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_image', '$product_quantity')");
            if ($insert_product) {
                $message[] = 'Product added to cart successfully';
            } else {
                $message[] = 'Failed to add product to cart';
            }
        }
    } else {
        $message[] = 'Product not found';
    }
}

?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Sports & Outdoors</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style1.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Open+Sans:400,700&display=swap&subset=latin-ext" rel="stylesheet">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
   </head>
   <body>
   <?php

      if(isset($message)){
      foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
       };
      };

   ?>
      <!-- header section start -->
      <div class="header_section">
         <div class="container-fluid">
            <nav class="navbar navbar-light bg-light justify-content-between">
               <div id="mySidenav" class="sidenav">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                  <a href="index.php">Home</a>
                  <a href="newIn1.php">New In</a>
                  <a href="sale1.php">Sale</a>
                  <a href="women_clothing1.php">Women Clothing</a>
                  <a href="curve1.php">Curve</a>
                  <a href="underwear_sleepwear1.php">Underwear & Sleepwear</a>
                  <a href="men_Fashion1.php">Men Fashion</a>
                  <a href="jewelry_Accessories1.php">Jewelry & Accessories</a>
                  <a href="shoes1.php">Shoes</a>
                  <a href="beauty_health1.php">Beauty & Health</a>
                  <a href="kids1.php">Kids</a>
                  <a href="bags_Luggage1.php">Bags & Luggage</a>
                  <a href="sports_outdoors1.php">Sports & Outdoors</a>
                  <a href="home_textile.php">Home Textile</a>
                  <a href="about.html">About</a>
                  <a href="client.html">Client</a>
                  <a href="contact.html">Contact</a>
               </div>
               <span class="toggle_icon" onclick="openNav()"><img src="images/toggle-icon.png"></span>
               <a class="logo" href="index.html"><center><img src="images/logo.png"></center></a>
               
               <form class="form-inline ">
               <div class="login_text">
                    <ul>
                        <li><a href="login.php"><img src="images/user-icon.png"></a></li>
                        <?php
                        $select_rows = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                        $row_count = mysqli_num_rows($select_rows);
                        ?>
                        <li><a href="cart1.php"><img src="images/bag-icon.png"><span><?php echo $row_count; ?></span></a></li>
                        <li><a href="logout.php"><img src="images/search-icon.png"></a></li>
                    </ul>
                </div>
               </form>

            </nav>
         </div>
      </div>
      <!-- header section end -->
      <!-- banner section start -->
      <div class="banner_section layout_padding">
         <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">Women <br>Clothing </h1>
                           <p class="banner_text">Ncididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                           <div class="read_bt"><a href="women clothing.html">Buy Now</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><center><img src="images/banner-img.jpeg" width="300"></center></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">Men <br>Fashion</h1>
                           <p class="banner_text">Ncididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                           <div class="read_bt"><a href="Men Fashion.html">Buy Now</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><img src="images/2.jpg" width="900"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">Beauty <br>Kit</h1>
                           <p class="banner_text">Ncididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                           <div class="read_bt"><a href="Beauty & health.html">Buy Now</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><img src="images/7.png" width="900"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">Jewelry &<br>Accessories</h1>
                           <p class="banner_text">Ncididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                           <div class="read_bt"><a href="Jewelry & Accessories.html">Buy Now</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><img src="images/3.jfif" width="900"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">Shoes</h1>
                           <p class="banner_text">Ncididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                           <div class="read_bt"><a href="Shoes.html">Buy Now</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><img src="images/4.jfif" width="900"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">Kids</h1>
                           <p class="banner_text">Ncididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                           <div class="read_bt"><a href="Kids.html">Buy Now</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><img src="images/9.jpg" width="900"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">Bags & <br>Luggage</h1>
                           <p class="banner_text">Ncididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                           <div class="read_bt"><a href="Bags & Luggage.html">Buy Now</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><img src="images/10.jfif" width="900"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">Sports & <br>Outdoors</h1>
                           <p class="banner_text">Ncididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                           <div class="read_bt"><a href="Sports & outdoors.html">Buy Now</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><img src="images/11.jfif" width="900"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">Home <br>Textile</h1>
                           <p class="banner_text">Ncididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                           <div class="read_bt"><a href="home textile.html">Buy Now</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><img src="images/12.jfif" width="400"></div>
                        </div>
                     </div>
                  </div>
               </div>

               <br>
            </div>
         </div>
      </div>
      <!-- banner section end -->


      <!-- product section start -->
      
      <div class="product_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <h1 class="product_taital">Sports & Outdoors Products</h1>
                  <p class="product_text">incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
               </div>
            </div>
            
            <div class="product_section_2 layout_padding">
               <div class="row">
               <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE `category` = 'sports&outdoors'");
                if (mysqli_num_rows($select_products) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_products)) {
            ?>
                <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <form action="" method="post">
                            <h4 class="bursh_text"><?php echo htmlspecialchars($fetch_product['name']); ?></h4>
                            <img src="uploaded_img/<?php echo htmlspecialchars($fetch_product['image']); ?>" alt="" class="image_1">
                            <div class="btn_main">
                                <div class="buy_bt">
                                    <ul>
                                        <li><input type="submit" class="btn" value="add to cart" name="add_to_cart"></li>
                                    </ul>
                                </div>
                                <h3 class="price_text">$<?php echo htmlspecialchars($fetch_product['price']); ?>/-</h3>
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($fetch_product['id']); ?>">
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($fetch_product['name']); ?>">
                                <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($fetch_product['price']); ?>">
                                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($fetch_product['image']); ?>">
                            </div>
                        </form>
                    </div>
                </div>
            <?php
                    }
                }
            ?>

               </div>
               <div class="seemore_bt"><a href="#">See More</a></div>
            </div>
         </div>
      </div>
      <!-- product section end -->
      <!-- about section start -->
      <div class="about_section layout_padding">
         <div class="container">
            <div class="about_section_main">
               <div class="row">
                  <div class="col-md-6">
                     <div class="about_taital_main">
                        <h1 class="about_taital">About Our beauty sotore</h1>
                        <p class="about_text">labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequatlabore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequatlabore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
                        <div class="readmore_bt"><a href="#">Read More</a></div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div><img src="images/about-img.png" class="image_3"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- about section end -->
      <!-- customer section start -->
      <div class="customer_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <h1 class="customer_taital">What says customers</h1>
               </div>
            </div>
            <div id="main_slider" class="carousel slide" data-ride="carousel">
               <div class="carousel-inner">
                  <div class="carousel-item active">
                     <div class="client_section_2">
                        <div class="client_main">
                           <div class="client_left">
                              <div class="client_img"><img src="images/client-img.png"></div>
                           </div>
                           <div class="client_right">
                              <h3 class="name_text">Jonyro</h3>
                              <p class="dolor_text">consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation  eu </p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="carousel-item">
                     <div class="client_section_2">
                        <div class="client_main">
                           <div class="client_left">
                              <div class="client_img"><img src="images/client-img.png"></div>
                           </div>
                           <div class="client_right">
                              <h3 class="name_text">Jonyro</h3>
                              <p class="dolor_text">consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation  eu </p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="carousel-item">
                     <div class="client_section_2">
                        <div class="client_main">
                           <div class="client_left">
                              <div class="client_img"><img src="images/client-img.png"></div>
                           </div>
                           <div class="client_right">
                              <h3 class="name_text">Jonyro</h3>
                              <p class="dolor_text">consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation  eu </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
               <i class="fa fa-angle-left"></i>
               </a>
               <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
               <i class="fa fa-angle-right"></i>
               </a>
            </div>
         </div>
      </div>
      <!-- customer section end -->
      <!-- contact section start -->
      <div class="contact_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                  <h1 class="contact_taital">Get In Touch</h1>
                  <p class="contact_text">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation  eu </p>
               </div>
               <div class="col-md-6">
                  <div class="contact_main">
                     <div class="contact_bt"><a href="#">Contact Form</a></div>
                     <div class="newletter_bt"><a href="#">Newletter</a></div>
                  </div>
               </div>
            </div>
         </div>
         
      </div>
      <!-- contact section end -->
      <!-- footer section start -->
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="footer_logo"><a href="index.html"><img src="images/footer-logo.png"></a></div>
            <div class="contact_section_2">
               <div class="row">
                  <div class="col-sm-4">
                     <h3 class="address_text">Contact Us</h3>
                     <div class="address_bt">
                        <ul>
                           <li>
                              <a href="#">
                              <i class="fa fa-map-marker" aria-hidden="true"></i><span class="padding_left10">Address : Loram Ipusm</span>
                              </a>
                           </li>
                           <li>
                              <a href="#">
                              <i class="fa fa-phone" aria-hidden="true"></i><span class="padding_left10">Call : +01 1234567890</span>
                              </a>
                           </li>
                           <li>
                              <a href="#">
                              <i class="fa fa-envelope" aria-hidden="true"></i><span class="padding_left10">Email : demo@gmail.com</span>
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="footer_logo_1"><a href="index.html"><img src="images/footer-logo.png"></a></div>
                     <p class="dummy_text">commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non</p>
                  </div>
                  <div class="col-sm-4">
                     <div class="main">
                        <h3 class="address_text">Best Products</h3>
                        <p class="ipsum_text">dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="social_icon">
               <ul>
                  <li>
                     <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">2020 All Rights Reserved. Design by <a href="https://html.design">Oviya's store</a></p>
         </div>
      </div>
      <!-- copyright section end -->
      <!-- Javascript files-->
      <script src="js/script.js"></script>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <!-- javascript --> 
      <script src="js/owl.carousel.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>  
      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
      <script>
         function openNav() {
           document.getElementById("mySidenav").style.width = "100%";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }
      </script> 
   </body>
</html>