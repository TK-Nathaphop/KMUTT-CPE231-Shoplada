
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
  <!-- Content-->
  <div class="container">
    <h4 class="black-text center-align"> payment</h4>
    <div class="row">
      <div class="col l12 m12 s12">
        <div class="card-panel white" style ="margin-top:15px;">
          <div class="card-content">
            <h5> <i class="material-icons" style=" font-size :3rem"> local_shipping</i>                  Shipping Address</h5>
            <br>
            <form action="payment.php" method="POST">
              <div class="row">
                <div class="input-field col l6 m6 s12">
                  <i class="material-icons prefix"> account_circle</i>
                  <input placeholder="First Name" id="firstName" type="text" class="validate" name="firstName" required/>
                  <label for="firstName"> First Name</label>
                </div>
                <div class="input-field col l6 m6 s12">
                  <i class="material-icons prefix"> account_circle</i>
                  <input placeholder="Surname" id="Surname" type="text" class="validate" name="Surname" required/>
                  <label for="Surname"> Surname </label>
                </div>
              </div>
              <div class="row">
               <div class="input-field col s12">
                <select name="AddressDropDown" id="AddressDropDown" onchange="showtextbox()">
                  <option value="" disabled selected>Choose your Address</option>
                  <option value="AddAddress"> Add new Address </option>
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
                      $AddressQuery = "SELECT * FROM address WHERE UserID ='$userid'";  /* น่าจะต้องแก้เป็น Query จาก OrderID -> UserID -> Address*/
                      $objQuery = mysqli_query($con,$AddressQuery);
                      if(!$objQuery)
                      {
                        die("Can't query Address".mysqli_error($con));
                      }
                      else
                      {
                        $i=0;
                        while($row=mysqli_fetch_array($objQuery))
                        {
                          $i++;
                          $Address = $row['Address'];
                          $Road = $row['Road'];
                          $District = $row['District'];
                          $Province = $row['Province'];
                          $Postcode = $row['Postcode'];
                          $Phone = $row['Phone'];
                          echo " <option value=".$i."> $Address  $Road Road, $District District, $Province, $Postcode, $Phone</option>";
                        }
                      }
                      mysqli_close($con)
                      ?>
                </select>
                <label>Choose your Address</label>
              </div>
              </div>
              <div class="row" style="display :none" id="Address_fill1">
                <div class="input-field col l6 m6 s12">
                  <i class="material-icons prefix"> location_on</i>
                  <input placeholder="Address" id="Address" type="text" class="validate" name="Address" required/>
                  <label for="Address"> Address</label>
                </div>
                <div class="input-field col 16 m6 s12">
                  <input placeholder="Road" id="road" type="text" class="validate" name="road" required/>
                  <label for="road"> Road</label>
                </div>
              </div>
              <div class="row" style="display :none" id="Address_fill2">
                <div class="input-field col l6 m6 s12">
                  <input placeholder="District" id="district" type="text" class="validate" name="district" required/>
                  <label for="district"> District </label>
                </div>
                 <div class="input-field col l6 m6 s12">
                  <input placeholder="Province" id="province" type="text" class="validate" name="province" required/>
                  <label for="province"> Province </label>
                </div>
              </div>
              <div class="row" style="display :none"id="Address_fill3">
                <div class="input-field col l6 m6 s12">
                  <input placeholder="Postcode" id="Postcode" type="number" class="validate" name="Postcode" min="10000"pattern="[0-9]{5}"required/>
                  <label for="Postcode"> Postcode</label>
                </div>
                <div class="input-field col l6 m6 s12">
                  <input placeholder="Phone" id="Phone" type="number" class="validate" name="Phone" required/>
                  <label for="Phone"> Phone</label>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col l12 m12 s12">
        <div class = "card-panel white" style="margin-top: 15px;">
          <div class="card-content">
            <h5> <i class="material-icons" style=" font-size :3rem"> payment</i>                  Payment Method</h5>
            <br>
              <div class="row">
                <div class="input-field col l6 m6 s12">
                  <i class="material-icons prefix">credit_card</i>
                  <input placeholder="Card Holder's Name" id="cardName" type="text" class="validate" name="payerName" required/>
                  <label for="cardName"> Card Holder's Name</label>
                </div>
                <div class="input-field col l6 m6 s12">
                  <select name="paymentMethod">
                    <option value="" disabled selected> Choose your option</option>
                    <option value="Credit"> Credit Card</option>
                    <option value="Debit"> Debit Card</option>
                  </select>
                  <label> Select Payment Method</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col l6 m6 s12">
                  <input placeholder="Card Number" id="creditNo" type="number" class="validate" name="creditNo" min="0" required/>
                  <label for="creditNo"> Card Number</label>
                </div>
                <div class="input-field col l6 m6 s12">
                    <select name="Bankname">
                      <option value="" diabled selected> Bank Name </option>
                      <option value="Bangkok_Bank"> Bangkok Bank </option>
                      <option value="SCB"> Siam Commercial Bank </option>
                      <option value="KASIKORN"> Kasikorn Bank </option>
                      <option value="Krungsri"> Bank of Ayudhya (Krungsri) </option>
                      <option value="Thanachart"> Thanachart Bank </option>
                      <option value="TMB"> TMB Bank </option>
                      <option value="Kiatnakin"> Kiatnakin Bank </option>
                      <option value="CIMB"> CIMB </option>
                      <option value="Standard_Chartered"> Standard Chartered Bank</option>
                      <option value="Unit_Overseas"> Unit Overseas Bank </option>
                      <option value="Tisco"> Tisco Bank </option>
                      <option value="ICBC"> Industrial and Commercial Bank of China </option>
                      <option value="MegaICB"> Mega ICB </option>
                      <option value="YEEB"> Korbboon Bank</option>
                    </select>
                    <label> Select Bank </label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col l3 m3 s6">
                  <select name="expirationMonth">
                    <option value="" disabled selected> Month</option>
                    <option value="01"> 01</option>
                    <option value="02"> 02</option>
                    <option value="03"> 03</option>
                    <option value="04"> 04</option>
                    <option value="05"> 05</option>
                    <option value="06"> 06</option>
                    <option value="07"> 07</option>
                    <option value="08"> 08</option>
                    <option value="09"> 09</option>
                    <option value="10"> 10</option>
                    <option value="11"> 11</option>
                    <option value="12"> 12</option>
                  </select>
                  <label> Select Expiration Date</label>
                </div>
                <div class="input-field col l3 m3 s6">
                  <select name="expirationYear">
                    <option value="" disabled selected> Year </option>
                    <option value="2019"> 19 </option>
                    <option value="2020"> 20 </option>
                    <option value="2021"> 21 </option>
                    <option value="2022"> 22 </option>
                    <option value="2023"> 23 </option>
                    <option value="2024"> 24 </option>
                    <option value="2025"> 25 </option>
                    <option value="2026"> 26 </option>
                    <option value="2027"> 27 </option>
                    <option value="2028"> 28 </option>
                    <option value="2029"> 29 </option>
                    <option value="2030"> 30 </option>
                    <option value="2031"> 31 </option>
                    <option value="2032"> 32 </option>
                  </select>
                </div>
                <div class="input-field col l6 m6 s12">
                  <input placeholder="Secuirty Code" id="ScCode" type="number" class="validate" name="ScCode" min="0"pattern ="[0-9]{3}"required/>
                  <label for="ScCode"> CVV</label>
                </div>
              </div>
            </div>
        </div>
        <div class = "center-align">
          <button id="submit_button"class="btn waves-effect waves-light card-panel green" type="submit" name="submit_button">Submit
          <i class="material-icons right">send</i>
           <script> 
            $('#submit_button').click(function()
              {
                swal({
                title: "Success!",
                text: "Thank you for shopping with us!",
                icon: "success",
                button: "Continue",
                });
              }
            );
          </script>
          </button>
        </div>
    </div>
     </form>
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

      <!-- datepicker Script-->
      <script > document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems, {format:'mm-yy'});
  });
</script>
<!-- Select Script-->
<script>
      document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems);
  });
        </script>
		<!--JavaScript at end of body for optimized loading-->
   	   	<script type="text/javascript" src="js/materialize.min.js"></script>
      <script>
      function showtextbox()
      {
        var select_status=$('#AddressDropDown').val();
        if(select_status =='AddAddress')
        {
          $('#Address_fill1').show();
          $('#Address_fill2').show();
          $('#Address_fill3').show();
        }
        else
        {
          $('#Address_fill1').hide();
          $('#Address_fill2').hide();
          $('#Address_fill3').hide();
        }
      } 
      </script>
 </body>
</html>
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
    $sqlPrimary = "SELECT MAX(AddressID) AS lastID, count(AddressID) AS noAddress FROM address";
    $resultPrimary=mysqli_query($con,$sqlPrimary);
     if(!$resultPrimary)
      {
        die('ERROR! Cant get Address '.mysqli_error());
      }
    while($data=mysqli_fetch_array($resultPrimary))
    {
      $id=$data['noAddress']; /* waiting for query FROM DB*/
    }
    $PrimaryKeyAddress = sprintf('ADDR-%d',$id+1  );
    if(isset($_POST['Phone']))
    {
      $sqlInsertAddress ="Insert INTO address(AddressID,Phone,Address,Province,District,Road,Postcode,UserID) 
      VALUES({$PrimaryKeyAddress},{$_POST['Phone']},{$_POST['Address']},{$_POST['road']},{$_POST['district']},{$_POST['province']},{$_POST['Postcode']},{$UserID})";
       echo $sqlInsertAddress;
       if(!mysqli_query($con,$sqlInsertAddress))
      {
        die('ERROR! Adding Address'.mysqli_error($con));
      }
    }
      $sqlPrimaryOrder = "SELECT COUNT(*) AS noOrder FROM customerorder";
      $resultPrimary=mysqli_query($con,$sqlPrimaryOrder);
       if(!$resultPrimary)
        {
          die('ERROR! Cant get OrderID '.mysqli_error($con));
        }
      while($data1=mysqli_fetch_array($resultPrimary))
      {
        $id=@$data1['noOrder']; /* waiting for query FROM DB*/
      }
    $PrimaryKeyOrder = sprintf('OD-%04d',$id+1);
    date_default_timezone_set("Asia/Bangkok");
    $dateTime=date("Y-m-d H:i:s");
    if(isset($_POST['Address']))
    {
      $sqlInsertPayment = "Insert INTO customerorder(OrderID,DateTime,Phone,Address,Province,District,Road,Postcode,Paymethod,Payername,CreditNo,UserID)
       VALUES({$PrimaryKeyOrder},{$dateTime},{$Address},{$Province},{$District},{$Road},{$Postcode},{$_POST['paymentMethod']},{$_POST['firstName']},{$_POST['creditNo']},{$UserID})";
       if(!mysqli_query($con,$sqlInsertPayment))
       {
        die('ERROR! Cant insert Payment'.mysqli_error());
       }
       mysqli_close($con);
    }

  ?>