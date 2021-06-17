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
<?php

// Create connection
$con=mysqli_connect("localhost","root","password","shoplada");
// Check connection
if(mysqli_connect_errno())
	{
		echo"Failed to connect to mySQL:".mysqli_connect_error();
	}
    else
        {
             require_once ('auth/auth.database.php');
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
            }
        $productid = $_GET['productid'];
        $sql = "SELECT ProductName,Price,Stock,SizeW,SizeL,SizeH,Weight,Discount,Description,subcategoryID FROM product WHERE productID = '$productid'";
        $result = mysqli_query($con,$sql);
        
        $Product = mysqli_real_escape_string($con,$_POST['Name']);
        $Price = mysqli_real_escape_string($con,$_POST['price']);
        $Descripe = mysqli_real_escape_string($con,$_POST['describe']);
        $Picture = mysqli_real_escape_string($con,$_POST['picPath']);
        $Stock = mysqli_real_escape_string($con,$_POST['stock']);
        $SizeW = mysqli_real_escape_string($con,$_POST['SizeW']);
        $SizeL = mysqli_real_escape_string($con,$_POST['SizeL']);
        $SizeH = mysqli_real_escape_string(  $con,$_POST['SizeH']);
        $Weight = mysqli_real_escape_string($con,$_POST['Weight']);
        $Discount = mysqli_real_escape_string($con,$_POST['discount']);
        

        // if(!$SubCategory)
        //     {
        //         echo "ERROR NOT FOUND";
        //     }
        
        $sql = "UPDATE product
        SET ProductName = '$Product', Description='$Descripe',Price = $Price,Discount = $Discount
        ,Picture = '$Picture',Stock = $Stock,SizeW = $SizeW,SizeL = $SizeL,SizeH = $SizeH,
        Weight = $Weight,ShopID = 'SHOP-331' WHERE ProductID = '$productid';
        " ;

        // $result = mysqli_query($con,$sql);
        if(mysqli_query($con, $sql)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
        }

    }
    header("location:ShopManagement.php");
?>