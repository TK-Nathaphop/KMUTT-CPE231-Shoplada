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
        $regisClass = new regisClass();
        if ($session->insession($_SESSION["user"])) {
          $userData = $userClass->getUserData($_SESSION['user']);
          $shopData = $userClass->getShopData($_SESSION['user']);
          $UShopID = $shopData->ShopID;
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

                     $countAllProduct = $regisClass->getNewProductID();

                     $newProductID = $countAllProduct+1;

                     $txtProductID = "PD-".$newProductID;

                     $filename_user = $txtProductID.".".$file_ext;

                     //defined variable to send to sql and save files
                     $registerProduct = $regisClass->registerProduct($txtProductID,$version,$_POST['ProductName'],$_POST['Description'],$_POST['Price'],$_POST['Discount'],$filename_user,$_POST['Stock'],$_POST['sizeW'],$_POST['sizeL'],$_POST['sizeH'],$_POST['Weight'],"",$_POST['Flag'],$_POST['SubCategoryID'],$UShopID);

                     $productUpload = move_uploaded_file($file_tmp,"images/".$filename_user);
                      
                    if($registerProduct && $productUpload){
                      ?>
                        <script type="text/javascript">swal("สำเร็จ", "บันทึกข้อมูลเรียบร้อยแล้ว", "success")
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
          }
      ?>
      <nav class="green" role="navigation">
        <div class="nav-wrapper container">
          <a id="logo-container" href="index.php" class="brand-logo"><img src="http://e22vvb.asuscomm.com/logo.png" width="64" height="62"></a>
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
    <!--END HEADER-->
      <div class="container">
        <div class="card-panel white" style="margin-top: 15px;">
          <form name="form1" action="" method="post" id="myform" enctype="multipart/form-data">
            <div class="row">
              <div class="col l12">
                <p class="center-align"><span class="flow-text"><b>Stock</b></span></p>
                <div class="row">
                  <div class="col l6 m12 s12">
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">shopping_basket</i>
                      <input id="ProductName" type="text" class="validate" name="ProductName">
                      <label for="ProductName">Product name</label>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">contact_mail</i>
                      <input id="Description" type="text" class="validate" name="Description">
                      <label for="Description">Description</label>
                    </div>
                    <div class="input-field col l5 m11 s11">
                      <i class="material-icons prefix">attach_money</i>
                      <input id="Price" type="text" class="validate" name="Price">
                      <label for="Price">Price</label>
                    </div>
                    <div class="col l1 m1 s1">
                      <p style="padding-top: 11.5px;">baht</p>
                    </div>
                    <div class="input-field col l5 m11 s11" style="margin-bottom: -5px;">
                      <i class="material-icons prefix">attach_money</i>
                      <input id="Discount" type="text" class="validate" name="Discount">
                      <label for="Discount">Discount</label>
                    </div>
                    <div class="col l1 m1 s1">
                      <p style="padding-top: 11.5px;">baht</p>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">inbox</i>
                      <input id="Stock" type="text" class="validate" name="Stock">
                      <label for="Stock">Stock</label>
                    </div>
                  </div>
                  <div class="col l6 m12 s11">
                    <div class="input-field col l15 m5 s11">
                      <input id="sizeW" type="text" class="validate" name="sizeW">
                      <label for="sizeW">sizeW</label>
                    </div>
                    <div class="col l1 m1 s1">
                      <p style="padding-top: 11.5px;">cm.</p>
                    </div>
                    <div class="input-field col l5 m5 s11">
                      <input id="sizeL" type="text" class="validate" name="sizeL">
                      <label for="sizeL">sizeL</label>
                    </div>
                    <div class="col l1 m1 s1">
                      <p style="padding-top: 11.5px;">cm.</p>
                    </div>
                    <div class="input-field col l5 m5 s11">
                      <input id="sizeH" type="text" class="validate" name="sizeH">
                      <label for="sizeH">sizeH</label>
                    </div>
                    <div class="col l1 m1 s1">
                      <p style="padding-top: 11.5px;">cm.</p>
                    </div>
                    <div class="input-field col l5 m5 s11">
                      <input id="Weight" type="text" class="validate" name="Weight">
                      <label for="Weight">Weight</label>
                    </div>
                    <div class="col l1 m1 s1">
                      <p style="padding-top: 11.5px;">kg.</p>
                    </div>
                    <div class="input-field col l12 m12 s12">
                      <i class="material-icons prefix">shopping_cart</i>
                      <select id="StoreType" type="text" class="validate" name="StoreType" required>
                        <option value="" disabled selected>Choose your StoreType</option>
                        <option value="SCAT-01">Mobiles</option>
                        <option value="SCAT-02">Labtops</option>
                        <option value="SCAT-03">Tablets</option>
                        <option value="SCAT-04">Desktops</option>
                        <option value="SCAT-05">Gaming Consoles</option>
                        <option value="SCAT-06">Car Camera</option>
                        <option value="SCAT-07">Video_Camera</option>
                        <option value="SCAT-08">Security_Camera</option>
                        <option value="SCAT-09">Digitals_Camera</option>
                        <option value="SCAT-10">Gadgets</option>
                        <option value="SCAT-11">TV & Video Devices</option>
                        <option value="SCAT-12">TV Accessories</option>
                        <option value="SCAT-13">Home Audio</option>
                        <option value="SCAT-14">Large Appliances</option>
                        <option value="SCAT-15">Small Kitchen appliances</option>
                        <option value="SCAT-16">Cooling & Air Treatment</option>
                        <option value="SCAT-17">Vacuums & Floor Care</option>
                        <option value="SCAT-18">Iron & Sewing Machines</option>
                        <option value="SCAT-19">Personal Care Appliances</option>
                        <option value="SCAT-20">Parts & Accessories</option>
                        <option value="SCAT-21">Makeup</option>
                        <option value="SCAT-22">Skincare</option>
                        <option value="SCAT-23">Beauty Tools</option>
                        <option value="SCAT-24">Hair Care</option>
                        <option value="SCAT-25">Bath & Body</option>
                      </select>
                      <label for="StoreType">Store type</label>
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