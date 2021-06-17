<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="http://35.240.164.131/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="http://35.240.164.131/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
  <title>Shoplada</title>
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <!-- AJAX -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

</head>
<body>
    <!-- HEADER AND FOOTER -->
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

<?php require_once ('auth/auth.database.php');
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
      }?>
    <div class="container">
        <div class="card white">
            <div class ="card-content">
                <div class ="row">
                    <h4>Edit</h4>
                </div>
                <!-- Input Form of the product -->
                <div class="row">
                    <div class="card-content grey lighten-4">
                        
                            <!-- ROW1 -->
                            <?php
                            $con=mysqli_connect("localhost","root","password","shoplada");
                            if(mysqli_connect_errno())
                                {
                                    echo"Failed to connect to mySQL:".mysqli_connect_error();
                                }
                             $productid = $_GET['productid'];
                             $sql = "SELECT ProductName,Price,Stock,SizeW,SizeL,SizeH,Weight,Discount,Description,subcategoryID FROM product WHERE productID = '$productid'";
                             $sql2 = "SELECT ct.CategoryName FROM category ct, product p, subcategory sct WHERE p.SubcategoryID = sct.SubcategoryID AND sct.CategoryID = ct.CategoryID AND p.productID = '$productid'";
                             $result = mysqli_query($con,$sql);
                             $result2 = mysqli_query($con,$sql2);
                            $data2 = mysqli_fetch_row($result2);

                              if($data = mysqli_fetch_row($result)){ 
                             echo '
                             <div class="row">
                             <form action="http://localhost/ProjectDatabase/UpdateProductProcess.php?productid='.$productid.'" method="POST">
                                <div class="input-field col s4">
                                    <input name="Name" id="Name" type="text" class="validate" value ="'.$data[0].'">
                                    <label for="Name">Name</label>
                                </div>

                                <div class ="input-field col s4">
                                    <input name="price" id="price" type="number" class="validate" value = "'.$data[1].'">
                                    <label for="price">Price</label>
                                </div>

                                <div class="input-field col s3">
                                    <input name="stock" id="stock" type="number" class="validate" value = "'.$data[2].'">
                                    <label for="stock">Stock</label>
                                </div>
                            </div>
                            <!-- ROW2 -->
                            <div class="row">
                                <div class="input-field col s1">
                                    <input name="SizeW" id="SizeW" type="number" class="validate" value="'.$data[3].'">
                                    <label for="SizeW">SizeW</label>
                                </div>

                                <div class ="input-field col s1">
                                    <input name="SizeL" id="SizeL" type="number" class="validate" value="'.$data[4].'">
                                    <label for="SizeL">SizeL</label>
                                </div>

                                <div class="input-field col s1">
                                    <input name="SizeH" id="SizeH" type="number" class="validate" value="'.$data[5].'">
                                    <label for="SizeH">SizeH</label>
                                </div>

                                <div class="input-field col s1">
                                    <input name="Weight" id="Weight" type="number" class="validate" value="'.$data[6].'">
                                    <label for="Weight">Weight</label>
                                </div>

                                <div class="input-field col s2">
                                    <input name="discount" id="discount" type="number" class="validate" value="'.$data[7].'">
                                    <label for="discount">Discount</label>
                                </div>
                            </div>
                            <!-- Description of the product -->
                            <div class="row">
                                <div class="input-field col s10">
                                    <textarea name="describe" class="materialize-textarea" type="text" data-length="120">'.$data[8].' </textarea>
                                    <label for="describe">Describetion</label>
                                </div>
                            </div>
                            <!-- Select Category of Product -->
                            <div class="row">
                                <div class="input-field col s4">
                                    <select name ="cat" id="cat" class="validate">
                                    <option value="'.$data2[0].'">'.$data2[0].'</option>    
                                    </select>
                                    <label for="cat">Category</label>
                                </div> 
                                <div class="input-field col s4">
                                <input type="hidden" value="'.$data[9].' name="scat" id="scat">    
                                    <select name="scat" id="scat" value="'.$data[9].'">
                                        <option value="'.$data[9].'">'.$data[9].'</option>
                                    </select>
                                    <label for="scat">Sub category</label>
                                </div>
                            </div>
                            <!-- Upload picture -->
                            <div calss="row">
                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>Upload picture</span>
                                        <input type="file">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" name="picPath" id="picPath">
                                    </div>
                                </div>
                            </div>
                           
                            
                            <!-- SUMMIT BUTTON -->
                            <div class="row">
                                <div class= "col s10"></div>
                                <button class="waves-effect waves-light btn red type="submit" name="action" >SUBMIT
                                </button>
                            </div>
                        </form>
                        ';
                    }
                    else{
                        echo "ERROR";
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
     document.addEventListener('DOMContentLoaded', function() {
     var elems = document.querySelectorAll('select');
     var options = document.querySelectorAll('option');
     var instances = M.FormSelect.init(elems, options);
     });
</script>
<script>
      $(document).ready(function() {
    $('input#input_text, textarea#textarea2').characterCounter();
  });
</script>
</body>
</html>
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
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="http://35.240.164.131/js/materialize.js"></script>
  <script src="http://35.240.164.131/js/init.js"></script>
