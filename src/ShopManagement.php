
<!-- saved from url=(0033)http://35.240.164.131/header.html -->
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
  <title>Shoplada</title>
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</head>
<body>
 <!-- Header -->
 <nav class="green" role="navigation">
        <div class="nav-wrapper container">
          <a id="logo-container" href="index.php" class="brand-logo"><img src="http://e22vvb.asuscomm.com:43221/images/logo.png" width="64" height="62"></a>
          <ul class="right hide-on-med-and-down">
            <?php
              if (($userData->Picture == "NULL")||($userData->Picture == "")) {
                ?>
                <li><a href="preview.php">Welcome, <b><?php echo $userData->Username;?></b></a></li>
                <?php
              }else{
                ?>
                <li><a href="preview.php"><img class="brand-logo" width="64" height="62"  src="./images/<?php echo $userData->Picture;?>" class="circle responsive-img">
                Welcome, <b><?php echo $userData->Username;?></b></a></li>
                <?php
              }
            ?>
            <?php
            $con=mysqli_connect("localhost","root","password","shoplada");
              //Check Connection
              if(mysqli_connect_errno())
              {
                echo"Failed to connect to mySQL:".mysqli_connect_error();
              }
            $userid = $_SESSION["user"];
            $sql = "SELECT shopid FROM shop WHERE userid = '$userid'";
            $result = mysqli_query($con,$sql);
            $data = mysqli_fetch_row($result);
            if($data)
              {
              $shopid = $data[0];
              echo '<li><a href="ordermanage.php">Order Management</a></li>';
              echo '<li><a href="ShopManagement.php">Product Management</a></li>';
              }
            else
              {
              echo '<li><a href="shop_register.php">Register shop</a></li>';
              }
            ?>
            
            <li><a href="ShoppingCart.php"><i class="material-icons">shopping_cart</i></a></li>
            <li><a href="report.php">Report</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
          <ul id="nav-mobile" class="sidenav">
            <li><a href="preview.php">Profile</a></li>
            <?php
            if($data)
              {
              echo '<li><a href="ordermanage.php">Order Management</a></li>';
              echo '<li><a href="ShopManagement.php">Product Management</a></li>';
              }
            else
              echo '<li><a href="shop_register.php">Register shop</a></li>'; ?>
            <li><a href="ShoppingCart.php"><i class="material-icons">shopping_cart</i></a></li>
            <li><a href="report.php">Report</li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
          <a href="javascript:void(0)" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
      </nav>
     <?php require_once ('auth/auth.database.php');
      require_once ('auth/session.php');
      require_once ('class/getUserClass.php');
      require_once ('class/registerClass.php');
      require_once ('class/updateClass.php');
      $updateClass = new updateUser();
      $userClass = new getUserClass();
      $session = new session();
      if ($session->insession()) {
        $userData = $userClass->getUserData($_SESSION['user']);
        $shopData = $userClass->getShopData($_SESSION['user']);
        $UShopID = $shopData->ShopID;
      }
      else{
        header("location: login.php");
      }?>

  <div class="container">
  <div class="card-content">
  
    <!--Adding the prodcut-->
<div class ="row">
  <div class="card white">
    <div class="card-content">
    <?php 
      $conn = new mysqli('localhost', 'root', 'password','shoplada') or die(mysqli_error($conn));
      $sqlShop = ("SELECT * FROM shop WHERE ShopID = '$UShopID' ");
      $result = mysqli_query($conn,$sqlShop);

      $sqlProduct = ("SELECT * FROM product WHERE ShopID = '$UShopID'");
      $result2 = mysqli_query($conn,$sqlProduct);
      ?> 
      <?php if($data = mysqli_fetch_row($result)): ?>
      <h5 class="blue-text">SHOP INFOMATION </h5>
      <div class"card-content">
          <div class="row">
              <div class="col s2"></div>
              <div class="col s6">
                <h5>ShopName:  <?php echo $data[1]; ?></h5>
              </div>
          </div>
          <div class="row">
              <div class="col s2"></div>
              <div class="col s6">

                <h5>Address:  <?php echo $data[2]?> <?php echo $data[3]?> 
                <?php echo $data[4]?> <?php echo $data[5];?> <?php echo $data[6];?></h5>
              </div>
          </div>
          <div class="row">
              <div class="col s2"></div>
              <div class="col s6">
                <h5>Contact:  <?php echo $data[9];?> <?php echo $data[12];?></h5>
              </div>
          </div>
          <div class="row">
              <div class="col s10"></div>
                <div class="col s2">
                  <a class="waves-effect waves-light btn" href="edit_shop.php">EDIT</a>
                </div>
            </div>   
          </div>

      </div>
      <?php endif; ?>
    </div>
  </div>
</div>  

      
    <div class="card white">
    <div class="card-content">
        <div class="row">
            <table class="highlight centered">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th></th><th></th>
                  </tr>
                </thead>
                <?php while($row = $result2->fetch_assoc()): ?>
                <?php if($row['Flag'] == 1){
                 echo' <tr>
                    <tbody>
                    <td class="teal-text text-darken-1"> '.$row['ProductID'].' </td>
                    <td>'.$row['ProductName'].'</td>
                    <td>'.$row['Price'].'</td>
                    <td>'. $row['Stock'].'</td>
                    <td>
                      <a class="mdl-button mdl-js-button waves-effect waves-light"  href="EditProductPage.php?productid='.$row['ProductID'].'">Edit</a>
                    </td>
                    <td>
                    <a class="mdl-button mdl-js-button waves-effect waves-light red-text"  href="DeleteProducProcess.php?productid='.$row['ProductID'].'">Delete</a>
                    </td>
                    </tbody>
                   </tr>';
                  }
                   else{
                   echo' 
                   <tbody>
                    </tbody>
                   </tr>';
                   }
                   ?>
                  <?php endwhile; ?>
              </table>
        </div>
        <div class="row">
          <div class="col s10"></div>
          <div class="col s2">
          <a href="AddProductPage.php">
          <button class="waves-effect waves-light btn" >
            ADD
            </button></a>
          </div>
        </div>
</form>
    </div> 
    </div>
  </div>
  </div>
</body>
</html>

<footer class="page-footer green" style="width:100%;">
        <div class="container">
        <h5 class="white-text">Never Slow Down team Bio</h5>
        <p class="grey-text text-lighten-4">We are a team of KMUTT students working on database project. In our team consist of<br>
        Chawakorn Boonrin        60070503415<br>
        Nathaphop Sundarabhogin  60070503420<br>
        Natthawat Tungruethaipak 60070503426<br>
        Thaweesak Saiwongse      60070503429<br></p>
        </div>
      <div class="footer-copyright">
        <div class="container">
        Made by Never Slow Down
        </div>
      </div>
</footer>
