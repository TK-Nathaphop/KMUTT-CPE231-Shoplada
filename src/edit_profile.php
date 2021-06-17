<!DOCTYPE html>
<html>
  <head>
    <title>edit profile</title>
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
      require_once ('class/updateClass.php');
      $userClass = new getUserClass();
      $session = new session();
      $updateClass = new updateUser();
      $users = array();
      if ($session->insession($_SESSION["user"])) {
        $userData = $userClass->getUserData($_SESSION["user"]);
        $UserID = $_SESSION["user"];
      }
      else{
        header("location: login.php");
      }
          //echo $_SESSION['user'];
      if(!empty($_POST["submit_button"])){
        if(isset($_FILES['image'])){
          $errors= array();
          $file_name = $_FILES['image']['name'];
          $file_size = $_FILES['image']['size'];
          $file_tmp = $_FILES['image']['tmp_name'];
          $file_type = $_FILES['image']['type'];
          $tmp = explode('.',$_FILES['image']['name']);
          $file_ext = end($tmp);
          $expensions= array("jpeg","jpg","png");
            
          if(in_array($file_ext,$expensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            $filename_user = $userData->Picture;
            $updateData = $updateClass->updateUserData($_SESSION["user"],$_POST['UserName'],$_POST['Password'],$_POST['FirstName'],$_POST['LastName'],$_POST['Mail'],$_POST['DOB'],$_POST['Phone'],$filename_user);

            if($updateData){
              ?>
                <script type="text/javascript">swal("Success", "Data recorded", "success")
                .then((value) => {
                    window.location = "preview.php";
                  });
                </script>
              <?php
              exit();
            }
            else{
              // print_r($errors);
              ?>
              <script type="text/javascript">swal("Warning", "Please fill in correctly", "warning");</script>
              <?php
              }
          }

          if($file_size > 2097152) {
             $errors[]='File size must be excately 2 MB';
          }
          
          if(empty($errors)==true) {
            
            $oldfilename_user = $userData->Picture;
            echo $oldfilename_user;
            $file_exi = file_exists("images/".$oldfilename_user);
            if ($file_exi) {
              unlink("images/".$oldfilename_user); //remove the file
            }

            $filename_user = $_SESSION["user"].".".$file_ext;

            $regisUpload = move_uploaded_file($file_tmp,"images/".$filename_user);
            //print($regisUpload);
            //defined variable to send to sql and save files
            $updateData = $updateClass->updateUserData($_SESSION["user"],$_POST['UserName'],$_POST['Password'],$_POST['FirstName'],$_POST['LastName'],$_POST['Mail'],$_POST['DOB'],$_POST['Phone'],$filename_user);

              
            if($updateData && $regisUpload){
              ?>
                <script type="text/javascript">swal("Success", "Data recorded", "success") //พารามิตเตอร์สุดท้ายคือicon
                .then((value) => {
                    window.location = "preview.php";
                  });
                </script>
              <?php
            } 
          }else{
            //print_r($errors);
            ?>
            <script type="text/javascript">swal("Warning", "Image errored", "warning");</script>
            <?php
            }
        }
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
            <div class="col l12">
              <p class="center-align"><span class="flow-text"><h2><b>Edit Profile</b></h2></span></p>
              <div class="row">
                  <div class="input-field col l4 m6 s12">
                    <i class="material-icons prefix">account_circle</i>
                    <input placeholder="6-16 characters" id="UserName" type="text" value="<?php echo $userData->Username;?>" class="validate" name="UserName"
                    minlength="6" maxlength="16" required>
                    <label for="UserName">Username</label>
                  </div>
                  <div class="input-field col l4 m6 s12">
                    <i class="material-icons prefix">lock</i>
                    <input placeholder="6-16 characters" id="Password" type="password" name="Password" required>
                    <label id="lblPassword" for="Password">Password</label>
                    <span class="helper-text" data-error="Password not match" data-success="Password match"></span>
                  </div>
                  <div class="input-field col l4 m12 s12">
                    <i class="material-icons prefix">lock</i>
                    <input placeholder="6-16 characters" id="Re-Password" type="password" name="Re-Password" minlength="6" maxlength="16" required>
                    <label id="lblRe-Password" for="Re-Password">Please retype your password</label>
                    <span class="helper-text" data-error="Password not match" data-success="Password match"></span>
                  </div>
                  <div class="input-field col l6 m6 s12">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="FirstName" type="text" class="validate" value="<?php echo $userData->FirstName;?>" name="FirstName">
                    <label for="FirstName">First name</label>
                  </div>
                  <div class="input-field col l6 m6 s12">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="LastName" type="text" class="validate" value="<?php echo $userData->LastName;?>" name="LastName">
                    <label for="LastName">Last name</label>
                  </div>
                  <div class="input-field col l6 m6 s12">
                    <i class="material-icons prefix">local_phone</i>
                    <input id="Phone" type="text" class="validate" value="<?php echo $userData->Phone;?>" name="Phone">
                    <label for="Phone">Mobile phone</label>
                  </div>
                  <div class="input-field col l6 m6 s12">
                    <i class="material-icons prefix">date_range</i>
                    <input id="DOB" type="text" class="datepicker" value="<?php echo $userData->DOB;?>" name="DOB">
                    <label for="DOB">Date of birth</label>
                  </div>
                  <div class="input-field col l6 m6 s12">
                    <i class="material-icons prefix">contact_mail</i>
                    <input id="Mail" type="email" class="validate" value="<?php echo $userData->Mail;?>" name="Mail">
                    <label for="Mail">E-mail</label>
                  </div>
                  <div class="file-field input-field col l6 m6 s12">
                    <div class="btn">
                      <span>File</span>
                      <input type="file" name="image">
                    </div>
                    <div class="file-path-wrapper">
                      <input class="file-path validate" type="text">
                    </div>
                  </div>
                <div class="col l12 m12 s12">
                  <div class="center-align">
                    <input type="submit" id="submit_button" name="submit_button" style="font-color:#fff;" class="btn waves-light card-panel green" value="SUBMIT">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
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
    <script>
      $("#Password").keyup(()=>{
        const password = $("#Password").val()
        const re_password = $("#Re-Password").val()
        if(password !== re_password){
          $("#Password").addClass("invalid").removeClass('valid')
          $("#Re-Password").addClass("invalid").removeClass("valid")
          $("#submit_button").addClass("disabled")
        }else{
          $("#Password").removeClass("invalid").addClass("valid")
          $("#Re-Password").removeClass("invalid").addClass("valid")
          $("#submit_button").removeClass("disabled")
        }
      })
      $("#Re-Password").keyup(()=>{
        const password = $("#Password").val()
        const re_password = $("#Re-Password").val()
        if(password !== re_password){
          $("#submit_button").addClass("disabled")
          $("#Re-Password").addClass("invalid").removeClass("valid")
          $("#Password").addClass("invalid").removeClass('valid')
        }else{
          $("#Re-Password").removeClass("invalid").addClass("valid")
          $("#Password").removeClass("invalid").addClass("valid")
          $("#submit_button").removeClass("disabled")
        }
      })
    </script>
  </body>
</html>