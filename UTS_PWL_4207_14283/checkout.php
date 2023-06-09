<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'product already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
      $message[] = 'product added to cart!';
   }

};

if(isset($_POST['update_cart'])){
   $update_quantity = $_POST['cart_quantity'];
   $update_id = $_POST['cart_id'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
   $message[] = 'cart quantity updated successfully!';
}

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   header('location:product.php');
}
  
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:product.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping Cart</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
   <link rel="icon" href="image/iconweb.png">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/product.css">

</head>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
<head>
        <header>
            <a href="#" class="logo">Ostyle Shop</a>
            <div class="menu-toggle"></div>
            <nav>
                <ul>
                    <li><a href="http://localhost/UTS_PWL_4207_14283/index.php" class="active">Home</a></li>
                    <li><a href="http://localhost/UTS_PWL_4207_14283/product.php" class="">Product</a></li>
                    <li><a href="http://localhost/UTS_PWL_4207_14283/about.php" class="">About Us</a></li>
                    <li> <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('are your sure you want to logout?');" >Logout</a>
                    <li><a href="http://localhost/UTS_PWL_4207_14283/cart.php"><i class="fa fa-shopping-cart"></i></a></li>
                </ul>
            </nav>
            <div class="clearfix"></div>
        </header>
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".menu-toggle").click(function(){
                    $(".menu-toggle").toggleClass("active")
                    $("nav").toggleClass("active")
                })
            })
        </script>
    </head>
<body>
   
 <!-- <?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>  -->


<div class="container">
      <!--
    <div class="user-profile">
         <?php
            $select_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
            if(mysqli_num_rows($select_user) > 0){
               $fetch_user = mysqli_fetch_assoc($select_user);
            };
         ?>

         <p> username : <span><?php echo $fetch_user['name']; ?></span> </p>
         <p> email : <span><?php echo $fetch_user['email']; ?></span> </p>
         <div class="flex">
            <a href="login.php" class="btn">login</a>
            <a href="register.php" class="option-btn">register</a>
            <a href="product.php?logout=<?php echo $user_id; ?>" onclick="return confirm('are your sure you want to logout?');" class="delete-btn">logout</a>
         </div>
      </div>

   <div class="products">
      <h1 class="heading">Product</h1>
      <div class="box-container">
         <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            if(mysqli_num_rows($select_product) > 0){
               while($fetch_product = mysqli_fetch_assoc($select_product)){
         ?>
            <form method="post" class="box" action="">
               <img src="image/<?php echo $fetch_product['image']; ?>" alt="">
               <div class="name"><?php echo $fetch_product['name']; ?></div>
               <div class="price">Rp <?php echo $fetch_product['price']; ?>k</div>
               <input type="number" min="1" name="product_quantity" value="1">
               <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
               <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
               <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
               <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
         <?php
               };
            };
         ?>
      </div>
   </div>

   -->

   <div class="shopping-cart">
      <h1 class="heading">Coming soon</h1>
      <!-- <table>
         <thead>
            <th>image</th>
            <th>name</th>
            <th>price</th>
            <th>quantity</th>
            <th>total price</th>
            <th>action</th>
         </thead>
         <tbody>
            <?php
               $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $grand_total = 0;
               if(mysqli_num_rows($cart_query) > 0){
                  while($fetch_cart = mysqli_fetch_assoc($cart_query)){
            ?>
            <tr>
               <td><img src="image/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
               <td><?php echo $fetch_cart['name']; ?></td>
               <td>Rp <?php echo $fetch_cart['price']; ?>k</td>
               <td>
                  <form action="" method="post">
                     <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                     <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                     <input type="submit" name="update_cart" value="update" class="option-btn">
                  </form>
               </td>
               <td>Rp <?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>k</td>
               <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('remove item from cart?');">remove</a></td>
            </tr>
            <?php
               $grand_total += $sub_total;
                  }
               }else{
                  echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
               }
            ?>
            <tr class="table-bottom">
               <td colspan="4">grand total :</td>
               <td>Rp <?php echo $grand_total; ?>k</td>
               <td><a href="product.php?delete_all" onclick="return confirm('delete all from cart?');" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">delete all</a></td>
            </tr>
         </tbody>
      </table>
      
         <div class="cart-btn">  
            <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
         </div> 
      -->
   </div>
</div>
   <footer>
         <div class="footertop">
               <div class="medsos">
                  <ul>
                     <li><a href="https://www.instagram.com/evaafadila"><i class="fab fa-instagram"></i></a></li>
                     <li><a href="https://www.youtube.com/channel/UC0lOoZ3AE_3Vkqt8gGBYBpQ"><i class="fab fa-youtube"></i></a></li>
                     <li><a href="https://www.tiktok.com/@evaafadila?_t=8YSy4nhoRAf&_r=1"><i class="fab fa-tiktok"></i></a></li>
                  </ul>
               </div>
         </div>
         <div class="footerbottom">
               <div class="copyright">
                  <h4 style="margin-top: 0px;"><br> &copy 2022 Ostyle Shop by Eva </br></h4>
               </div>
         </div>
    </footer>
</body>
</html>