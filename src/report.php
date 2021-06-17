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
  		<title>Review</title>

 		 <!-- CSS  -->
  		<link href="./Shoplada_files/icon" rel="stylesheet">
		 <link href="./Shoplada_files/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
 		 <link href="./Shoplada_files/style.css" type="text/css" rel="stylesheet" media="screen,projection">
     <!-- star Rating CSS-->
     <link rel="stylesheet" href="css/Review.css">
     <!-- Sweet Alert-->
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	</head>
	<body bgcolor="#eaeaea">
		 <!-- Header -->
  		<?php 
      require_once ('auth/auth.database.php');
      require_once ('auth/session.php');
      require_once ('class/getUserClass.php');
      require_once ('class/registerClass.php');
      require_once ('class/updateClass.php');
      $updateClass = new updateUser();
      $userClass = new getUserClass();
      $regisClass = new regisClass();
      $session = new session();
      if ($session->insession()) {
        $userData = $userClass->getUserData($_SESSION['user']);
        $shopData = $userClass->getShopData($_SESSION['user']);
        $UShopID = $shopData->ShopID;
      }
      else{
        header("location: login.php");
      }
      if(!empty($_POST["submit_button"])){
        $errors= array();
        echo "button pressed";
        if(empty($errors)==true) {
          echo "no error";
          $countAllRP = $regisClass->getNewReportID();
          $newRPID = $countAllRP+1;

          $txtRPID = "RP-".$newRPID;
          $response = 0;
          //defined variable to send to sql and save files

          $regisReport = $regisClass->registerReport($txtRPID,$_POST['Topic'],$_POST['ReportText'],"",$response,$_SESSION["user"]);

          
          if($regisReport){
          ?>
            <script type="text/javascript">swal("Success", "Reported", "success")
            .then((value) => {
                window.location = "index.php";
              });
            </script>
          <?php
          }
         
      }else{
        // print_r($errors);
        ?>
        <script type="text/javascript">swal("ผิดพลาด", "รูปภาพผิดพลาด", "warning");</script>
        <?php
        }
      }
      ?>
      <nav class="green" role="navigation">
        <div class="nav-wrapper container">
          <a id="logo-container" href="index.php" class="brand-logo"><img src="http://e22vvb.asuscomm.com:43221/images/logo.png" width="64" height="62"></a>
          <ul class="right hide-on-med-and-down">
            <?php
              if (($userData->Picture == "NULL") || ($userData->Picture == "")) {
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
            <li><a href="preview.php">Profile</a></li>
            <li><a href="shop_register.php">register shop</a></li>
            <li><a href="ShoppingCart.php"><i class="material-icons">shopping_cart</i></a></li>
            <li><a href="report.php">Report</li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
          <ul id="nav-mobile" class="sidenav">
            <li><a href="preview.php">Profile</a></li>
            <li><a href="shop_register.php">register shop</a></li>
            <li><a href="ShoppingCart.php"><i class="material-icons">shopping_cart</i></a></li>
            <li><a href="report.php">Report</li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
          <a href="javascript:void(0)" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
      </nav>
      <div class="container">
        <div class="card-panel white" style="margin-top: 15px;">
          <form name="form1" action="" method="post" id="myform">
          <div class="row">
            <div class="col l12 m12 s12">
              <div class="input-field col l12 m12 s12">
                <i class="material-icons prefix">text_fields</i>
                <input id="Topic" type="text" class="validate" name="Topic">
                <label for="Topic">Topic</label>
              </div>
              <div class="input-field col l12 m12 s12">
                <i class="material-icons prefix">mode_edit</i>
                <textarea id="ReportText" name="ReportText",class="materialize-textarea"></textarea>
                <label for="ReportText" class="active">Give Report</label>
              </div>
              <div class="col l12 m12 s12">
                <div class="center-align">
                  <input type="submit" id="submit_button" name="submit_button" style="color:#fff;" class="btn waves-light card-panel green" value="SUBMIT">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
<!-- End of Content -->
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

		<!--JavaScript at end of body for optimized loading-->
   	   	<script type="text/javascript" src="js/materialize.min.js"></script>
        <script> $('#ReportText').val('report');
        M.textareaAutoResize($('#ReportText'));> </script>
        <div class="sidenav-overlay"></div><div class="drag-target"></div>
	</body>
</html>