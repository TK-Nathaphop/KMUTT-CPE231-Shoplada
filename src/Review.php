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
 /* ---- Wait for connecting with another page -----*/
 $SuborderID = @$_GET['SOID'];
 if(isset($SuborderID)&&!empty($SuborderID))
 {
   $query ="SELECT p.*
   FROM subcustomerorder sco, product p
   WHERE sco.ProductID = p.ProductID  AND sco.SubOrderID = '$SuborderID'";
   if(!$result=mysqli_query($con,$query))
   {
      die("ERROR!").mysqli_error();
   }
   while($row=mysqli_fetch_array($result))
   {
     if(isset($row))
     {
      $selectedProduct = $row['ProductName'];
     }
   }
 }
 mysqli_close($con);
?>
  <!-- Content (Put content below) -->
  	<div class="container">
        <div class="card white" style="margin-top: 50px">
  		    <div class="card-content blue-text">
  			    <div class="row">
              <p class="black-text center-align" style="margin-top: 5px" > <span class="flow-text"> <b>Review </b></span></p>
               <h6 class="grey-text left-align"> <b>Rate for <?php echo $selectedProduct;?> </b></h6>
                <!-- Start Star rate-->
               <form class ="col s12" action="" method="POST">
                  <div class="rate left-align">
                   <input type="radio" id="star5" name="star_rate" value="5" />
                   <label for="star5" title="text">5 stars</label>
                   <input type="radio" id="star4" name="star_rate" value="4" />
                   <label for="star4" title="text">4 stars</label>
                   <input type="radio" id="star3" name="star_rate" value="3" />
                   <label for="star3" title="text">3 stars</label>
                   <input type="radio" id="star2" name="star_rate" value="2" />
                   <label for="star2" title="text">2 stars</label>
                   <input type="radio" id="star1" name="star_rate" value="1" />
                   <label for="star1" title="text">1 star</label>
                  </div>
                  <!-- End Star rate-->
                <div class="row">
                  <div class="input-field col l12 m12 s12">
                    <i class="material-icons prefix">mode_edit</i>
                    <textarea id="ReviewText" name="reviewText",class="materialize-textarea"></textarea>
                    <label for="ReviewText" class="active">Give Review</label>
                  </div>
                </div>
                <div class = "center-align">
                
                  <button id="submit_button" class="btn waves-effect waves-light card-panel green" type="submit" name="submit_button" >Submit
                  <i class="material-icons right">send</i>
              
                  </button>
                </div>
              </form>
            </div>
  		    </div>
        </div>    
  	 </div>
<?php 
  $con = mysqli_connect($hostname,$username,$password,$dbname);
  if(mysqli_connect_errno())
  {
    echo"Failed to connect to mySQL:".mysqli_connect_error();
  }
  if(isset($_POST['submit_button']))
  {
    $star = $_POST['star_rate'];
    $reviewtext=mysqli_real_escape_string($con,$_POST['reviewText']);
    date_default_timezone_set("Asia/Bangkok");
    $dateTime=date("Y-m-d H:i:s");
    /* add primary keys in the form of RW-XXXX)*/
    $twoDigitYear = date("y");
    $fullYear = date("Y");
    $sqlPrimary = "SELECT COUNT(*) AS numberReview FROM review";
    if(!$resultPrimary=mysqli_query($con,$sqlPrimary))
    {
      die("ERROR").mysqli_error($resultPrimary);
    }
    $num=mysqli_num_rows($result);
    $i=0;
    do
    {
    $i++;
    $PrimaryKey= "RV-".($num+$i);
    $sql = "SELECT reviewid FROM review WHERE reviewid = '$PrimaryKey'";
    $result = mysqli_query($con,$sql);
    }while(mysqli_num_rows($result) != 0);
    //echo $PrimaryKey;
    $SuborderID = @$_GET['SOID'];
    $sqlInsert = "INSERT INTO `review`(`ReviewID`, `Message`, `Star`, `DateTime`, `SubOrderID`) VALUES('$PrimaryKey','$reviewtext','$star', STR_TO_DATE('$dateTime','%Y-%m-%e %H:%i:%s'),'$SuborderID')";
    if(!mysqli_query($con,$sqlInsert))
    {
      die("Can't insert REVIEW").mysqli_error($con);
    }
    else{
      $message = "Thank you for your review";
      echo "<script type='text/javascript'>alert('$message');location= 'http://e22vvb.asuscomm.com:43221/history.php';</script>";
    }
  }

?>


<!-- End of Content -->
   <footer class="page-footer green" style="width:100%; margin-top: 50px">
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


        <script> $('#ReviewText').val('review');
        M.textareaAutoResize($('#ReviewText'));> </script>
        <div class="sidenav-overlay"></div><div class="drag-target"></div>
        <script>
       /*  SWAL FUNCTION
       function alert_box()
        {
          var submit_status = $('#submit_button').val();
          document.write(FUCKKK);
          if(!empty(submit_status))
          {
            swal({
                    title: "Success!",
                    text: "Thank you for your review",
                    icon: "success",
                    button: "Continue",
                  });
          }
        } */
        </script>
	</body>
</html>