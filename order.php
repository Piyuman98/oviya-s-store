<?php

@include 'config.php';

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM `order` WHERE id = $delete_id ") or die('query failed');
    if($delete_query){
       header('location:order.php');
       $message[] = 'product has been deleted';
    }else{
       header('location:order.php');
       $message[] = 'product could not be deleted';
    };
 };
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Oder manage</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   


<?php include 'header.php'; ?>
<br>
<br>

<div class="container">
   <style>
      .header{
   background-color: var(--black);
   position: sticky;
   top:0; left:0;
   z-index: 1000;
}
.h1{
   background-color: var(--white);
}
</style>

<header class="header">

</div>


<section  >
<<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
@media screen and (max-width: 767px) {
    .left2, .main2 {
        width: 100%;
    }
    thead {
        display: none;
    }
    td {
        display: block;
    }
    td:first-child {
        background-color: black;
        color: white;
    }
    td:nth-child(1)::before {
        content: "Orders"
    }
    td {
        text-align: center;
    }
    td::before {
        float: left;
    }
}
</style>

<table id="customers">

      <thead>
      <th>Name</th>
         <th>Number</th>
         <th>E-mail</th>
         <th>Method</th>
         <th>Address</th>
         <th>Street</th>
         <th>City</th>
         <th>State</th>
         <th>Country</th>
         <th>pin code</th>
         <th>total product</th>
         <th>total price</th>
         <th>action</th>
      </thead>

      <tbody>
         <?php
         
            $select_products = mysqli_query($conn, "SELECT * FROM `order`");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>

         <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['number']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['method']; ?></td>
            <td><?php echo $row['flat']; ?></td>
            <td><?php echo $row['street']; ?></td>
            <td><?php echo $row['city']; ?></td>
            <td><?php echo $row['state']; ?></td>
            <td><?php echo $row['country']; ?></td>
            <td><?php echo $row['pin_code']; ?></td>
            <td><?php echo $row['total_products']; ?></td>
            <td>$<?php echo $row['total_price']; ?></td>
            <td>
               <a href="order.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
               
            </td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty'>no product added</div>";
            };
         ?>
      </tbody>
   </table>

</section>



</div>















<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>