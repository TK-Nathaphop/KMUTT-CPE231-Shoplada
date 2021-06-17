<!DOCTYPE html>
  <html>
    <head>
      <title>Shop register</title>
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
      require_once ('class/getUserClass.php');
      require_once ('class/registerClass.php');
      require_once ('auth/session.php');
        $userClass = new getUserClass();
        $session = new session();
        if ($session->insession($_SESSION["user"])) {
          $userData = $userClass->getUserData($_SESSION['user']);
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
                  }
                  
                  if($file_size > 2097152) {
                     $errors[]='File size must be excately 2 MB';
                  }
                  
                  if(empty($errors)==true) {

                     $regisClass = new regisClass();
                     $countAllShop = $regisClass->getNewShopID();

                     $newShopID = $countAllShop+1;

                     $txtShopID = "SHOP-".$newShopID;

                     $filename_user = $txtShopID.".".$file_ext;

                     //defined variable to send to sql and save files
                     $regisShop = $regisClass->registerShop($txtShopID,$_POST['ShopName'],$_POST['Address'],$_POST['Province'],$_POST['District'],$_POST['Road'],$_POST['Postcode'],$filename_user,$_POST['URL'],$_POST['Mail'],$_POST['Facebook'],$_POST['StoreType'],$_POST['PhoneNumber'],$_POST['ShippingCriteria'],$_SESSION['user']);

                     $shopUpload = move_uploaded_file($file_tmp,"images/".$filename_user);
                      
                    if($regisShop && $shopUpload){
                      ?>
                        <script type="text/javascript">swal("สำเร็จ", "บันทึกข้อมูลเรียบร้อยแล้ว", "success")
                        .then((value) => {
                            window.location = "main.php";
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
    <!--END HEADER-->
      <div class="container">
        <div class="card-panel white" style="margin-top: 15px;">
          <form name="form1" action="" method="post" id="myform" enctype="multipart/form-data">
            <div class="row">
              <div class="col l12">
                <p class="center-align"><span class="flow-text"><b>Shop register</b></span></p>
                <div class="row">
                  <div class="col l6 m12 s12">
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">account_circle</i>
                      <input id="ShopName" type="text" class="validate" name="ShopName">
                      <label for="ShopName">Shop name</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">shopping_cart</i>
                      <select id="StoreType" type="text" class="validate" name="StoreType">
                        <option value="" disabled selected>Choose your StoreType</option>
                        <option value="1">Personal</option>
                        <option value="2">Business</option>
                      </select>
                      <!-- <input id="StoreType" type="text" class="validate" name="StoreType"> -->
                      <label for="StoreType">Store type</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">contact_mail</i>
                      <input id="Mail" type="email" class="validate" name="Mail">
                      <label for="Mail">E-mail</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">language</i>
                      <input id="URL" type="text" class="validate" name="URL">
                      <label for="URL">URL</label>
                    </div>
                    <div class="input-field col l11 m11 s11" style="margin-bottom: -5px;">
                      <i class="material-icons prefix">attach_money</i>
                      <input id="ShippingCriteria" type="text" class="validate" name="ShippingCriteria">
                      <label for="ShippingCriteria">Shipping Criteria</label>
                      <p style="margin-top: 1px;">*Minimum price for free shipping</p>
                    </div>
                    <div class="col l1 m1 s1">
                      <p style="padding-top: 11.5px;">baht</p>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">people</i>
                      <input id="Facebook" type="text" class="validate" name="Facebook">
                      <label for="Facebook">Facebook</label>
                    </div>
                  </div>
                  <div class="col l6 m12 s12">
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">add_location</i>
                      <input id="Address" type="text" class="validate" name="Address">
                      <label for="Address">Address</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">add_location</i>
                      <input id="Road" type="text" class="validate" name="Road">
                      <label for="Road">Road</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">add_location</i>
                      <input id="Province" type="text" class="validate" name="Province">
                      <label for="Province">Province</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">add_location</i>
                      <input id="District" type="text" class="validate" name="District">
                      <label for="District">District</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">add_location</i>
                      <input id="Postcode" type="text" class="validate" name="Postcode">
                      <label for="Postcode">Postcode</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">call_end</i>
                      <input id="PhoneNumber" type="text" class="validate" name="PhoneNumber">
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