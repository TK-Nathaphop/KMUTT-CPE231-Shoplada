<!DOCTYPE HTML>
<html>
<head>
    	<!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      	<!--Import materialize.css-->
      	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

    	  <!--Let browser know website is optimized for mobile-->
   	   	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   	   	 <!-- Compiled and minified CSS -->
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    	<!-- Compiled and minified JavaScript -->
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
            
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
  		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
  		<title>Shoplada</title>

 		 <!-- CSS  -->
  		<link href="./Shoplada_files/icon" rel="stylesheet">
		 <link href="./Shoplada_files/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
 		 <link href="./Shoplada_files/style.css" type="text/css" rel="stylesheet" media="screen,projection">
         <!-- Sweet Alert-->
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body bgcolor="#eaeaea">
     <!-- Header -->
     <?php 
      require_once ('auth/auth.database.php');
      require_once ('class/getUserClass.php');
      require_once ('class/registerClass.php');
      require_once ('auth/session.php');
      $userClass = new getUserClass();
      $session = new session();
      //if(strlen($_SESSION["user"]) == 0)
      if ($session->insession()) {
        $userData = $userClass->getUserData($_SESSION["user"]);
        ?>
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
              echo '<li><a href="shopmanagement.php">Product Management</a></li>';
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
              echo '<li><a href="shopmanagement.php">Product Management</a></li>';
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
      }
      else{
        ?>
        <nav class="green" role="navigation">
        <div class="nav-wrapper container">
          <a id="logo-container" href="index.php" class="brand-logo"><img src="images/logo.png" width="64" height="62"></a>
          <ul class="right hide-on-med-and-down">
            <li><a href="login.php">Login</a></li>
          </ul>
          <ul id="nav-mobile" class="sidenav">
            <li><a href="login.php">Login</a></li>
          </ul>
          <a href="javascript:void(0)" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
      </nav>
        <?php
      }
      //header("location: login.php");
      //echo $_SESSION['user'];
      ?>
      <!-- CONTENT -->
      
    <div class="container">
      	<div class="row">
      		<div class="col l12 m12 s12">
      			<div class="card panel-white" style="margin-top: 15px">
      				<div class="card-content">
      					<p class="black-text center-align"> <span class="flow-text"><b>Shopping Cart</b></span></p>
      					<br>
                        <br>
                        <?php 
      $hostname = "localhost";
      $username = "root";
      $password = "password";
      $dbname = "shoplada";
      $con = mysqli_connect($hostname,$username,$password,$dbname);
      if(mysqli_connect_errno())
      {
        echo"Failed to connect to mySQL:".mysqli_connect_error();
      }
      $QueryShoppingCart = "SELECT sco.*, p.Picture, p.ProductName, p.Price, p.Discount, s.ShopName
      FROM subcustomerorder sco, customerorder co, customer c, product p, shop s
       WHERE sco.OrderID = co.OrderID AND co.UserID = c.UserID AND sco.ProductID = p.ProductID AND p.ShopID =s.shopID 
       AND sco.Version = p.Version AND c.UserID = '$userid' AND sco.Status = '0'"; // อาจจะ Query ไม่100% รอแก้
        if(!$showProduct= mysqli_query($con,$QueryShoppingCart))
        {
            die("ERROR! Can't Query Shopping Cart   ").mysqli_error();
        }
        $countSubOrder=0;
        $subTotal =0;

        //$PriceArray = array();
        while($row=mysqli_fetch_array($showProduct))
        {
            $Picture = $row['Picture'];
            $ProductName = $row['ProductName'];
            $Price = $row['Price'];
            $Discount = $row['Discount'];
            $Amount = $row['Amount'];
            $ShopName = $row['ShopName'];
            $PricePerPiece = $Price - $Discount;
            $subTotal = ($PricePerPiece*$Amount) + $subTotal;
          //  $PriceArray[$countSubOrder] = $PricePerPiece;
            $countSubOrder++;
            echo'
                          <div class="row">
                            <div class="col l3 m6 s12">	';
                            if(!is_null($Picture))
                            {
                              echo '<img src="data:image/jpeg;base64, '.base64_encode( $Picture ).' " />';
                            }
                            else
                            {
                              echo '<img src="http://e22vvb.asuscomm.com:43221/images/product/null.png">';
                            }
                          echo'
                            </div>
                            <div class="col l6 m6 s12" >  
                              <p class="black-text"> <b> Product Name: </b> '.$ProductName.' </p> <br>
                              <p> <b> Shop Name: </b>'.$ShopName.'</p> <br>
                                <p> <b> Price per Piece: </b><strike> '.$Price.'฿</strike> =>'.$PricePerPiece.'฿</p> <br>
                                <p> <b>Amount:</b> '.$Amount.'</p> <br>
                                <p> <b>Net:</b> '.$PricePerPiece*$Amount.'฿ </p> 
                            </div>
                          </div>
                          <br>
                          ';
        }
      ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class ="container">
        <div class ="row">
          <div class ="col l3 m6 s12">
          </div>
          <div class ="col l6 m6 s12">
            <div class="card panel-white" style="margin-top: 15px">
              <div class = "card-content">
              <div class="container">

              <?php
                
                if(isset($_GET['Voucher']))
                {
                  echo '<p> ewqpeop[op[12o3[2p1 </p>';
                  $VoucherID = $_GET['Voucher'];
                  $checkExistVoucher ="SELECT co.OrderID
                  FROM customerorder co, voucher v
                  WHERE v.VoucherID = co.VoucherID AND co.VoucherID = '$VoucherID' ";
                  $result = mysqli_query($con,$checkExistVoucher);
                  if(isset($result))
                  {
                    $NotExistVoucher = 1; // Voucher Exists
                  }
                  else
                  {
                    $NotExistVoucher = -1; //Voucher Not Exists
                  }
                  echo '<p> '.$NOtExistVoucher.' </p>';
                  $checkCategoryVoucher =" SELECT sc.CategoryID AS 'scCategoryID', v.CategoryID AS 'vCategoryID'
                  FROM customerorder co, voucher v, customer c, product p, subcustomerorder sco, subcategory sc, category ca
                  WHERE sco.OrderID = co.OrderID AND co.UserID = c.UserID AND sco.ProductID = p.ProductID AND c.UserID = '$userid' AND sco.Status = '0'
                  AND co.VoucherID = v.VoucherID AND v.CategoryID  = ca.CategoryID AND p.SubCategoryID = sc.SubCategoryID AND v.VoucherID = '$VoucherID'
                  ";
                  $checkCategory =  mysqli_query($con,$checkCategoryVoucher);
                  if(isset($checkCategory))
                  {
                    die("ERROR!").mysqli_connect_errno();
                  }
                  $categoryFlag=0;
                  while($ResultCheckCategory=mysqli_fetch_array($checkCategory))
                  {
                    $scCategoryID = $ResultCheckCategory['scCategoryID'];
                    $vCategoryID = $ResultCheckCategory['vCategoryID'];
                    if($scCategoryID == $vCategoryID)
                    {
                      $categoryFlag =1;
                    }
                    echo '<p> '.$catgoryFLag.' </p>';
                  }
                  /*$checkConditionVoucher = "SELECT pm.Condition, pm.DiscountOrder, pm.PromoID, (p.Price-p.Discount)*sco.Amount 
                  AS 'priceperpieceorder',p.price,p.Discount,p.ProductID 
                  FROM promotion pm, voucher v, customer c, product p, subcustomerorder sco, subcategory sc, category ca, customerorder co 
                  WHERE sco.OrderID = co.OrderID AND co.UserID = c.UserID AND sco.ProductID = p.ProductID AND c.UserID = 'USER-688' AND sco.Status = '0' 
                  AND co.VoucherID = v.VoucherID AND v.VoucherID = '2EG8HLFF3D' AND v.CategoryID = ca.CategoryID AND p.SubCategoryID = sc.SubCategoryID 
                  AND pm.PromoID = v.PromoID
                  GROUP BY sc.CategoryID, */
                  $SQLExpirePromo = "SELECT DISTINCT pm.ExpireDate AS 'PromoExpire',co.DateTime AS 'OrderDate', pm.DiscountOrder AS 'DiscountOrder'
                  FROM customerorder co, voucher v, customer c, product p, subcustomerorder sco, subcategory sc, category ca, promotion pm 
                  WHERE sco.OrderID = co.OrderID AND co.UserID = c.UserID AND sco.ProductID = p.ProductID AND c.UserID = '$userid' AND sco.Status = '0' 
                  AND co.VoucherID = v.VoucherID AND v.VoucherID = '$VoucherID'AND v.PromoID = pm.PromoID
                  ";
                  $checkExpirePromo =mysqli_query($con,$SQLExpirePromo);
                  $expirePromoFlag=0;
                  while($ResultExpirePromo=mysqli_fetch_array($checkExpirePromo))
                  {
                    $ExpirePromo = $ResultExpirePromo['PromoExpire'];
                    $OrderDate = $ResultExpirePromo['OrderDate'];
                    $discountOrder = $ResultExpirePromo['DiscountOrder'];
                    if(($ExpirePromo-$OrderDate)>0)
                    {
                      $expirePromoFlag =1;
                    }
                    echo '<p> ='.$expirePromoFlag.' </p>';
                  }
                }
                $SQLNumShop = "SELECT count(s.shopID) AS 'countShop'
                FROM customerorder co, customer c, product p, subcustomerorder sco, shop s
                WHERE sco.OrderID = co.OrderID AND co.UserID = c.UserID AND sco.ProductID = p.ProductID AND c.UserID = '$userid' 
                AND sco.Version = p.Version AND p.ShopID = s.ShopID AND sco.Status= '0'
                ";
                $resultNumShop = mysqli_query($con,$SQLNumShop);
                while($dataNumShop = mysqli_fetch_array($resultNumShop))
                {
                  $numShop = $dataNumShop['countShop'];
                }
                
                $SQLSumsuborder="SELECT SUM(((p.Price-p.Discount)*sco.Amount)) AS 'SUMALL', p.ShopID, p.ProductID
                FROM product p, subcustomerorder sco, customer c, customerorder co
                WHERE sco.OrderID = co.OrderID AND co.UserID = c.UserID AND sco.ProductID = p.ProductID AND c.UserID = '$userid' AND sco.Status='0'
                GROUP BY p.ShopID, p.ProductID";
                $resultSumsuborder = mysqli_query($con,$SQLSumsuborder);
                $i=0;
                while($dataSumsuborder = mysqli_fetch_array($resultSumsuborder))
                {
                  $sumsuborder[$i] = $datasumsuborder['SUMALL'];
                }
                
                $SQLCriteria = "SELECT s.ShippingCriteria AS 'shippingCriteria', (p.SizeW+ p.SizeL+p.SizeH) AS 'ProductSize', p.Stock, s.shopname AS shop 
                FROM customerorder co, customer c, product p, subcustomerorder sco, shop s
                WHERE sco.OrderID = co.OrderID AND co.UserID = c.UserID AND sco.ProductID = p.ProductID AND c.UserID = '$userid' 
                AND sco.Version = p.Version AND p.ShopID = s.ShopID AND sco.Status= '0'
                ";
                echo'
                <div class="row">
                <p class="left-align"><b> SubTotal : </b>'.$subTotal.'</p> <br>';
                $i=0;
                $TotalShippingFee=0;
                $resultCriteria = mysqli_query($con,$SQLCriteria);
                while($dataCriteria = mysqli_fetch_array($resultCriteria))
                {
                  $shippingCriteria = $dataCriteria['shippingCriteria'];
                  $productSize = $dataCriteria['ProductSize'];
                  
                  if($shippingCriteria>$sumsuborder[$i])
                  {  
                    if($productSize<60)
                    {
                      $ShippingFee = 30; 
                    }
                    else if(60<=$productSize&&$productSize<90)
                    {
                      $ShippingFee = 60;
                    }
                    else if(90<=$productSize&&$productSize<120)
                    {
                      $ShippingFee = 90; 
                    }
                    else if(120<=$productSize&&$productSize<150)
                    {
                      $ShippingFee = 120;
                    }
                    else if ($productSize>150)
                    {
                      $ShippingFee = 150;
                    }
                    $TotalShippingFee= $TotalShippingFee + $ShippingFee;
                  echo'<p class ="left-align"> <b> Shipping fee for '.$dataCriteria['shop'].': </b>'.$ShippingFee.' </p>';

                    }
                    $i++;
                }             
                      if($categoryFlag==1 && $NotExistVoucher==1 && $expirePromoFlag ==1)
                      {
                        $netOrder = $subTotal - $discountOrder;
                      }
                      else
                      {
                        $alert = "Sorry, invalid Voucher ";
                        echo "<script>alert($alert)</script>";
                      }
                      $SuperTotal= $TotalShippingFee + $subTotal;
                      echo '<b>Total:</br> '.$SuperTotal;
                     echo '
                  </div>
                  <form name="voucherForm" action="ShoppingCart.php" method="GET">
                  <div class="row">
                      <div class ="input-field col l9 m9 s9">
                        <input id="Voucher" type="text" class="validate">
                        <label for="Voucher" value=>Voucher code </label> 
                      </div>
                        <div class="col l3 m3 s3">
                          <button class = "btn waves-effect waves-light" "> Validate </button>
                        </div>
                    </div>
                    </form> 
                    <div class="row">
                        <div class="col l12 m12 s12 center-align">
                        <a href="payment.php"><button class = "btn waves-effect waves-light" "> Proceed to checkout </button></a>
                        </div>
                  </div>
                  ';
                     /* $query = "UPDATE customerorder SET VoucherID = '$_GET['Voucher']' WHERE UserID = '$userid' ";
                     /* echo "<p> '.$SQLstatement.'</p>";
                      $insert = mysqli_query($con,$query);
                      if(!$insert)
                      {
                        die("Can't Insert Voucher");
                      }*/
              ?>
                </div>
              </div>
            </div>
          <div class ="col l3 m6 s12">
          </div>
          </div>
        </div>
    </div>
    
    <!-- FOOTER-->
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
  <!-- Scripts (Put this in the end) -->
  <script src="./Shoplada_files/jquery-2.1.1.min.js.download"></script>
  <script src="./Shoplada_files/materialize.js.download"></script>
  <script src="./Shoplada_files/init.js.download"></script>

		<div class="sidenav-overlay"></div><div class="drag-target"></div>

  	<script type="text/javascript" src="js/materialize.min.js"></script>
</script>
</script>
</body>
</html>