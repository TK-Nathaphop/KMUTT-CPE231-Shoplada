<!DOCTYPE html>
  <html>
    <head>
      <title>Edit shop</title>
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

      <script>
        document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var options = document.querySelectorAll('option');
        var instances = M.FormSelect.init(elems, {options});
        });
      </script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems,{format:'yyyy-mm-dd'})});
    </script>
    </head>

    <body bgcolor="#eaeaea">
      <?php 
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
      //echo $_SESSION['user'];
      if(!empty($_POST["submit_button"])){
        //echo "button pressed";
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
            $filename_user = $shopData->Picture;
            $updateData = $updateClass->updateShopData($UShopID,$_POST['ShopName'],$_POST['Address'],$_POST['Province'],$_POST['District'],$_POST['Road'],$_POST['Postcode'],$filename_user,$_POST['URL'],$_POST['Mail'],$_POST['Facebook'],$_POST['StoreType'],$_POST['PhoneNumber'],$_POST['ShippingCriteria'],$_SESSION['user']);

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

            $oldfilename_user = $shopData->Picture;
            //echo $oldfilename_user;
            $file_exi = file_exists("images/".$oldfilename_user);
            if ($file_exi) {
              unlink("images/".$oldfilename_user); //remove the file
            }

            $filename_user = $UShopID.".".$file_ext;

              $shopUpload = move_uploaded_file($file_tmp,"images/".$filename_user);
              //print($shopUpload);
              //defined variable to send to sql and save files
              $updateData = $updateClass->updateShopData($UShopID,$_POST['ShopName'],$_POST['Address'],$_POST['Province'],$_POST['District'],$_POST['Road'],$_POST['Postcode'],$filename_user,$_POST['URL'],$_POST['Mail'],$_POST['Facebook'],$_POST['StoreType'],$_POST['PhoneNumber'],$_POST['ShippingCriteria'],$_SESSION['user']);
              
            if($updateData && $shopUpload){
              ?>
                <script type="text/javascript">swal("สำเร็จ", "บันทึกข้อมูลเรียบร้อยแล้ว", "success")
                .then((value) => {
                    window.location = "preview.php";
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
      }
      ?>
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
    <!--END HEADER-->
      <div class="container">
        <div class="card-panel white" style="margin-top: 15px;">
          <form name="form1" action="" method="post" id="myform" enctype="multipart/form-data">
            <div class="row">
              <div class="col l12">
                <p class="center-align"><span class="flow-text"><b>Edit shop</b></span></p>
                <div class="row">
                  <div class="col l6 m12 s12">
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">account_circle</i>
                      <input id="ShopName" type="text" class="validate" value="<?php echo $shopData->ShopName;?>" name="ShopName">
                      <label for="ShopName">Shop name</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">shopping_cart</i>
                      <select id="StoreType" type="text" class="validate" name="StoreType" required>
                        <option value="" disabled selected>Choose your StoreType</option>
                        <option value="Personal">Personal</option>
                        <option value="Business">Business</option>
                      </select>
                      <label for="StoreType">Store type</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">contact_mail</i>
                      <input id="Mail" type="email" class="validate" value="<?php echo $shopData->Mail;?>" name="Mail">
                      <label for="Mail">E-mail</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">language</i>
                      <input id="URL" type="text" class="validate" value="<?php echo $shopData->URL;?>" name="URL">
                      <label for="URL">URL</label>
                    </div>
                    <div class="input-field col l11 m11 s11" style="margin-bottom: -5px;">
                      <i class="material-icons prefix">attach_money</i>
                      <input id="ShippingCriteria" type="text" class="validate" value="<?php echo $shopData->ShippingCriteria;?>" name="ShippingCriteria">
                      <label for="ShippingCriteria">Shipping Criteria</label>
                      <p style="margin-top: 1px;">*Minimum price for free shipping</p>
                    </div>
                    <div class="col l1 m1 s1">
                      <p style="padding-top: 11.5px;">baht</p>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">people</i>
                      <input id="Facebook" type="text" class="validate" value="<?php echo $shopData->Facebook;?>" name="Facebook">
                      <label for="Facebook">Facebook</label>
                    </div>
                  </div>
                  <div class="col l6 m12 s12">
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">add_location</i>
                      <input id="Address" type="text" class="validate" value="<?php echo $shopData->Address;?>" name="Address">
                      <label for="Address">Address</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">add_location</i>
                      <input id="Road" type="text" class="validate" value="<?php echo $shopData->Road;?>" name="Road">
                      <label for="Road">Road</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">add_location</i>
                      <input id="Province" type="text" class="validate" value="<?php echo $shopData->Province;?>" name="Province">
                      <label for="Province">Province</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">add_location</i>
                      <input id="District" type="text" class="validate" value="<?php echo $shopData->District;?>" name="District">
                      <label for="District">District</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">add_location</i>
                      <input id="Postcode" type="text" class="validate" value="<?php echo $shopData->Postcode;?>" name="Postcode">
                      <label for="Postcode">Postcode</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">call_end</i>
                      <input id="PhoneNumber" type="text" class="validate" value="<?php echo $shopData->Phone;?>" name="PhoneNumber">
                      <label for="PhoneNumber">PhoneNumber</label>
                    </div>
                    <div class="file-field input-field col l12 m12 s12">
                      <div class="btn">
                        <span>File</span>
                        <input type="file" name="image">
                      </div>
                      <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="col l12 m12 s12">
                    <div class="center-align">
                      <input type="submit" id="submit_button" name="submit_button" style="color:#fff;" class="btn waves-light card-panel green" value="SUBMIT">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!--END BODY-->
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
      <script>
        document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems, {});
        });
      </script>
      <script type="text/javascript" src="./assets/js/sweetalert.js"></script>
    </body>
  </html>