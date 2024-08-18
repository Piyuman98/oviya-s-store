<?php

@include 'config.php';

if(isset($_POST['add_product'])){
   $p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
   $p_price = $_POST['p_price'];
   $p_category = mysqli_real_escape_string($conn, $_POST['p_category']);
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = 'uploaded_img/'.$p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `products`(`name`, `price`, `category`, `image`) VALUES('$p_name', '$p_price', '$p_category', '$p_image')") or die('query failed');

   if($insert_query){
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'Product added successfully';
   }else{
      $message[] = 'Could not add the product';
   }
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id ") or die('query failed');
   if($delete_query){
      header('location:admin.php');
      $message[] = 'Product has been deleted';
   }else{
      header('location:admin.php');
      $message[] = 'Product could not be deleted';
   }
};

if(isset($_POST['update_product'])){
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_category = mysqli_real_escape_string($conn, $_POST['update_p_category']);
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/'.$update_p_image;

   $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_p_name', price = '$update_p_price', category = '$update_p_category', image = '$update_p_image' WHERE id = '$update_p_id'");

   if($update_query){
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      $message[] = 'Product updated successfully';
      header('location:admin.php');
   }else{
      $message[] = 'Product could not be updated';
      header('location:admin.php');
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   }
}
?>

<?php include 'header.php'; ?>
<br><br>

<div class="container">
   <header class="header"></header>
</div>

<section>
   <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
      <h3>Add a new product</h3>
      <input type="text" name="p_name" placeholder="Enter the product name" class="box" required>
      <input type="number" name="p_price" placeholder="Enter the product price" class="box" required>
      <select name="p_category" class="box" required>
         <option value="" disabled selected>Select category</option>
         <option value="newIn">New In</option>
         <option value="sale">Sale</option>
         <option value="women_clothing">Women Clothing</option>
         <option value="curve">Curve</option>
         <option value="underwear&sleepwear">Underwear & Sleepwear</option>
         <option value="menFashion">Men Fashion</option>
         <option value="jewelry&phpAccessories">Jewelry & Accessories</option>
         <option value="shoes">Shoes</option>
         <option value="beauty&health">Beauty & Health</option>
         <option value="kids">Kids</option>
         <option value="bags&Luggage">Bags & Luggage</option>
         <option value="sports&outdoors">Sports & Outdoors</option>
         <option value="hometextile">Home Textile</option>
      </select>
      <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
      <input type="submit" value="Add the product" name="add_product" class="btn">
   </form>
</section>

<section class="display-product-table">
   <table>
      <thead>
         <th>Product Image</th>
         <th>Product Name</th>
         <th>Product Price</th>
         <th>Product Category</th>
         <th>Action</th>
      </thead>
      <tbody>
         <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>
         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td>$<?php echo $row['price']; ?>/-</td>
            <td><?php echo $row['category']; ?></td>
            <td>
               <a href="admin.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this?');"> <i class="fas fa-trash"></i> Delete </a>
               <a href="admin.php?edit=<?php echo $row['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> Update </a>
            </td>
         </tr>
         <?php
               }
            } else {
               echo "<div class='empty'>No product added</div>";
            }
         ?>
      </tbody>
   </table>
</section>

<section class="edit-form-container">
   <?php
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="100" alt="">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
      <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">
      <select name="update_p_category" class="box" required>
         <option value="<?php echo $fetch_edit['category']; ?>" selected><?php echo $fetch_edit['category']; ?></option>
         <option value="newIn">New In</option>
         <option value="sale">Sale</option>
         <option value="women_clothing">Women Clothing</option>
         <option value="curve">Curve</option>
         <option value="underwear&sleepwear">Underwear & Sleepwear</option>
         <option value="menFashion">Men Fashion</option>
         <option value="jewelry&phpAccessories">Jewelry & Accessories</option>
         <option value="shoes">Shoes</option>
         <option value="beauty&health">Beauty & Health</option>
         <option value="kids">Kids</option>
         <option value="bags&Luggage">Bags & Luggage</option>
         <option value="sports&outdoors">Sports & Outdoors</option>
         <option value="hometextile">Home Textile</option>
      </select>
      <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="Update the product" name="update_product" class="btn">
      <input type="reset" value="Cancel" id="close-edit" class="option-btn">
   </form>
   <?php
         }
      }
      echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
   }
   ?>
</section>
</div>

<script src="js/script.js"></script>

</body>
</html>
