<!DOCTYPE html>
<html>
  <head>
    <title>preview</title>
    <meta charset="UTF-8">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet"
      href="css/materialize.css">
      
      <script type = "text/javascript"
      src = "https://code.jquery.com/jquery-3.4.1.min.js"></script>
      <!--JavaScript at end of body for optimized loading-->
      <script type ="text/javaScript"
      src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
      <script type="text/javascript" src="./assets/js/sweetalert.js"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <!--tong css-->
      <link rel="stylesheet" href="./css/register.css">
    </head>
    <body>
      <?php
      require_once ('auth/auth.database.php');
      require_once ('auth/session.php');
      require_once ('class/getUserClass.php');
      require_once ('class/registerClass.php');
          $userClass = new getUserClass();
          $session = new session();
          $regisClass = new regisClass();
          $users = array();
          if ($session->insession($_SESSION["user"])) {
              $userData = $userClass->getUserData($_SESSION["user"]);
              $UserID = $_SESSION["user"];
              $userAddressall = $userClass->getAddressall($_SESSION["user"]);
          }
          else{
            header("location: login.php");
          }
          //echo $_SESSION['user'];
      ?>
      <?php
      if(!empty($_POST["submit_button"])){
        header("location: edit_profile.php");
      }
      if(!empty($_POST["add_address"])){
        header("location: addaddress.php");
      }
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
      
    <!-- Content (Put content below) -->
    <div class="container">
      <div class="card-panel white" style="margin-top: 15px;">
        <form name="form1" action="" method="post" id="myform" enctype="multipart/form-data">
          <div class="row">
          <span class="flow-text"><h2><b>Profile</b></h2></span>
          <div class="row">
            <div class="input-field col l3 m6 s12">
              <i class="material-icons prefix">account_circle</i>
              <input placeholder="6-16 characters" id="UserName" type="text" value="<?php echo $userData->Username;?>" class="validate" name="UserName"
              minlength="6" maxlength="16" required>
              <label for="UserName">Username</label>
            </div>
            <div class="input-field col l3 m6 s12">
              <i class="material-icons prefix">lock</i>
              <input placeholder="6-16 characters" id="Password" type="password" name="Password">
              <label id="lblPassword" for="Password">Password</label>
            </div>
            <div class="input-field col l3 m6 s12">
              <i class="material-icons prefix">account_circle</i>
              <input id="FirstName" type="text" class="validate" value="<?php echo $userData->FirstName;?>" name="FirstName">
              <label for="FirstName">First name</label>
            </div>
            <div class="input-field col l3 m6 s12">
              <i class="material-icons prefix">account_circle</i>
              <input id="LastName" type="text" class="validate" value="<?php echo $userData->LastName;?>" name="LastName">
              <label for="LastName">Last name</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col l4 m4 s12">
              <i class="material-icons prefix">local_phone</i>
              <input id="Phone" type="text" class="validate" value="<?php echo $userData->Phone;?>" name="Phone">
              <label for="Phone">Mobile phone</label>
            </div>
            <div class="input-field col l4 m4 s12">
              <i class="material-icons prefix">date_range</i>
              <input id="DOB" type="text" class="datepicker" value="<?php echo $userData->DOB;?>" name="DOB">
              <label for="DOB">Date of birth</label>
            </div>
            <div class="input-field col l4 m4 s12">
              <i class="material-icons prefix">contact_mail</i>
              <input id="Mail" type="email" class="validate" value="<?php echo $userData->Mail;?>" name="Mail">
              <label for="Mail">E-mail</label>
            </div>
          </div>
          <?php
          $i = 1;
          foreach ($userAddressall as $userAddress) {
            ?>
            <div class="row">
              <h4><b><?php echo "Address ".$i++;?></b></h4>
              <div class="input-field col l4 m4 s12">
                <i class="material-icons prefix">add_location</i>
                <input id="Address" type="text" class="validate" value="<?php echo $userAddress['Address'];?>" name="Address">
                <label for="Address">Address</label>
              </div>
              <div class="input-field col l4 m4 s12">
                <i class="material-icons prefix">add_location</i>
                <input id="Road" type="text" class="validate" value="<?php echo $userAddress['Road'];?>" name="Road">
                <label for="Road">Road</label>
              </div>
              <div class="input-field col l4 m4 s12">
                <i class="material-icons prefix">add_location</i>
                <input id="District" type="text" class="validate" value="<?php echo $userAddress['District'];?>" name="District">
                <label for="District">District</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col l4 m4 s12">
                <i class="material-icons prefix">add_location</i>
                <input id="Province" type="text" class="validate" value="<?php echo $userAddress['Province'];?>" name="Province">
                <label for="Province">Province</label>
              </div>
              <div class="input-field col l4 m4 s12">
                <i class="material-icons prefix">add_location</i>
                <input id="Postcode" type="text" class="validate" value="<?php echo $userAddress['Postcode'];?>" name="Postcode">
                <label for="Postcode">Postcode</label>
              </div>
              <div class="input-field col l4 m4 s12">
                <i class="material-icons prefix">call_end</i>
                <input id="PhoneNumber" type="text" class="validate" value="<?php echo $userAddress['Phone'];?>" name="PhoneNumber">
                <label for="PhoneNumber">PhoneNumber</label>
              </div>
            </div>
          <?php
          }
          ?>
          <div class="row">
            <div class="col l6 m6 s6">
              <div class="center-align">
                <input type="submit" id="submit_button" name="submit_button" style="font-color:#fff;width: 100%;" class="btn waves-light card-panel green" value="Edit profile">
              </div>
            </div>
            <div class="col l6 m6 s6">
              <div class="center-align">
                <input type="submit" id="add_address" name="add_address" style="font-color:#fff;width: 100%;" class="btn waves-light card-panel teal" value="Add address">
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
    <!-- End of Content -->
    <!-- Footer -->
    <footer class="page-footer green" style="bottom:0;left:0;width:100%;">
      <div class="container">
        <h5 class="white-text">Never Slow Down team Bio</h5>
        <p class="grey-text text-lighten-4">We are a team of KMUTT students working on database project. In our team concist of<br>
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
    <!--  Scripts -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('select');
      var instances = M.FormSelect.init(elems, {});
      });
    </script>
  </body>
</html>