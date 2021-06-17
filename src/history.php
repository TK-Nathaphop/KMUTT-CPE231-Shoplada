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
  		<title>History</title>

 		 <!-- CSS  -->
  		<link href="./Shoplada_files/icon" rel="stylesheet">
		 <link href="./Shoplada_files/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
 		 <link href="./Shoplada_files/style.css" type="text/css" rel="stylesheet" media="screen,projection">
         <!-- Sweet Alert-->
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
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
          <a id="logo-container" href="http://35.240.164.131/index.html" class="brand-logo"><img src="http://35.240.164.131/Logo.png" width="64" height="62"></a>
          <ul class="right hide-on-med-and-down">
            <?php
              if ($userData->Picture == "NULL") {
                ?>
                <li><a href="">Welcome, <b><?php echo $userData->Username;?></b></a></li>
                <?php
              }else{
                ?>
                <li><a href=""></a><img class="brand-logo" width="64" height="62"  src="./images/<?php echo $userData->Picture;?>" class="circle responsive-img">
                Welcome, <b><?php echo $userData->Username;?></b></li>
                <?php
              }
            ?>
            <li><a href="ShoppingCart.php"><i class="material-icons">shopping_cart</i></a></li>
            <li><a href="shop_register.php">register shop</a></li>
            <li><a href="preview.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
          <ul id="nav-mobile" class="sidenav">
            <li><a href="ShoppingCart.php"><i class="material-icons">shopping_cart</i></a></li>
            <li><a href="shop_register.php">register shop</a></li>
            <li><a href="preview.php">Profile</a></li>
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
          <a id="logo-container" href="http://35.240.164.131/index.html" class="brand-logo"><img src="http://35.240.164.131/Logo.png" width="64" height="62"></a>
          <ul class="right hide-on-med-and-down">
            <li><a href=""></a>
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
      <!--Content -->
      <div class="container">
      	<div class="row">
      		<div class="col l12 m12 s12">
      			<div class="card panel-white" style="margin-top: 15px">
      				<div class="card-content">
      					<p class="black-text center-align"> <span class="flow-text"><b>History</b></span></p>
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
                      //$UserID="USER-1"; // wait for send UserID from session;
                      $subcOrderSQL = "SELECT sc.*, p.Picture, p.ProductName, p.Price, p.Discount
                      FROM subcustomerorder sc, customerorder co, customer c, product p
                       WHERE sc.OrderID = co.OrderID AND co.UserID = c.UserID AND sc.ProductID = p.ProductID 
                       AND sc.Version = p.Version AND c.UserID = '$userData->UserID'  ";
                      $result = mysqli_query($con,$subcOrderSQL);
                      if(!$result)
                      {
                      	die("ERRROR Can't query").mysqli_error();
                      }
                      $i=0;
                      while($row=mysqli_fetch_array($result))
                      {
                          $Picture = $row['Picture'];
                          $ProductName = $row['ProductName'];
                          $Amount = $row['Amount'];
                          $Price = $row['Price'];
                          $Discount = $row['Discount'];
                          $Status = $row['Status'];
                          $SOID = $row['SubOrderID'];
                          $i++;
                          if($Status==0)
                        {
                          $StatusDetail = "In Shopping Cart";
                          $ReviewEnable = "disabled";
                        }
                        else if($Status==1)
                        {
                          $StatusDetail = "Purchased";
                          $ReviewEnable = "disabled";
                        }
                        else if($Status==2)
                        {
                          $StatusDetail = "Packaging";
                          $ReviewEnable = "disabled";
                        }
                        else if($Status==3)
                        {
                          $StatusDetail = "Delivering";
                          $ReviewEnable = "";
                        }
                        else
                        {
                          $StatusDetail = "Unknown";
                          $ReviewEnable = "disabled";
                        }
                        
                          echo'
                          <div class="row">
                            <div class="col l3 m6 s12">	';
                            if(!is_null($Picture))
                            {
                              echo '<img src="data:image/jpeg;base64, '.base64_encode( $Picture ).' " />';
                            }
                            else
                            {
                              echo '<img src="http://35.240.164.131/images/product/null.png">';
                            }
                          echo'
                            </div>
                            <div class="col l3 m6 s12" >
                              <p class="black-text"> Product Name: '.$ProductName.' </p>
                                <p> Amount: '.$Amount.'</p>
                                <p> Price: '.$Amount*($Price-$Discount).' ยังไม่เสร็จโว้ย </p> 
                            </div>
                            <div class="col l3 m5 s12">
                            
                              <p> Status:     '.$StatusDetail.' </p>
                              <br>
                              <a href="Review.php?SOID='.$SOID.'" class="waves-effect waves-light btn-small '.$ReviewEnable.' "><i class="material-icons left">feedback</i>Review</a>
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
</body>
</html>
