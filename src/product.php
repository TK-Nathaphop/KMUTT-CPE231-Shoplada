<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Shoplada</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <style>
    a:link{color:white;}
    a:visited{color:white;}
    a:hover{color:white;}
    a:active{color:white;}
  </style>
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

  <!-- Content (Put content below) -->
<div class="container">
<?php
$productid = $_GET['productid'];
$version = $_GET['version'];
$con=mysqli_connect("localhost","root","password","shoplada");
if(mysqli_connect_errno())
  {
    echo"Failed to connect to mySQL:".mysqli_connect_error();
  }
$sql = "SELECT p.`ProductID`, p.`Version`, p.`ProductName`, p.`Description`, p.`Price`, p.`Discount`, p.`Picture`, p.`Stock`, p.`SizeW`, p.`SizeL`, p.`SizeH`, p.`Weight`, p.`Timestamp`, p.`Flag`, p.`SubCategoryID`, p.`ShopID`, s.shopname, s.shopid
FROM product p, shop s WHERE flag='1' AND p.shopid=s.shopid AND p.productid = '$productid' AND p.version = '$version'";
 $result = mysqli_query($con, $sql);
 if($data = mysqli_fetch_row($result))
 {
  echo '<div class="row">
  <div class="col s12 m12 l12 xl12">
    <div class="card">
      <div class="card-image">';
      if(!is_null($data[6]))
        echo '<img class="materialboxed" src="images/product/'.$data[6].'">';
      else
        echo '<img class="materialboxed" src="images/product/null.png">';
      echo '</div>
      <div class="card-content">
        <div class="row">
          <div class="col s8 l8 m8 xl8">
            '.$data[3].'
          </div>';
        if($data[5]!=0)
          {
    echo '<div class="col s2 l2 m2 xl2">
            <h5><strike>'.$data[4].' ฿   </strike></h5>
          </div>
          <div class="col s2 l2 m2 xl2">
            <h5>'.($data[4]-$data[5]).' ฿</h5>
          </div>
        </div>';
          }
        else
          {
    echo '<div class="col s2 m2 l2 xl2">
          </div>
          <div class="col s2 l2 m2 xl2">
            <h5>'.$data[4].'</h5>
          </div>
          </div>';
            }
    echo '<form action="add_to_cart.php" method="GET">
    <div class="row">
      <input type="hidden" name="version" value="'.$version.'" />
      <input type="hidden" name="productid" value="'.$productid.'" />
      <div class="input-field col s7 m7 l7 xl7"></div>
      <div class="input-field col s2 m2 l2 xl2">
        <input type="number" name="amount" value="1" required/>
      </div>
      <div class="input-field col s3 m3 l3 xl3">
        <button class="btn waves-light card-panel green" type="submit" name="action">Add to cart<i class="material-icons right">add_shopping_cart</i></button>
      </div>
    </div>
  </form>
  </div>
  </div>
  </div>
  </div>';
  }
  else
  {
    echo '<div class="row><div class="col s12 m12 l12 xl12">
    <div class="card white">
    <div class="card-content">
    <p class="center-align"><span class="flow-text"><b>Can\'t find the product</b></span></p>
    </div>
    </div>
    </div></div>';
  }
?>
<div class="card white">
<div class="card-content">
  <?php
  $sql="SELECT r.message, r.star, DATE_FORMAT(r.`datetime`, '%d/%m/%Y %H:%i:%s'), p.productname,c.firstname,c.LastName,c.userid,c.picture
  FROM review r, product p, customerorder od, subcustomerorder sod, customer c
  WHERE p.productid = '$productid' AND r.suborderid = sod.suborderid AND sod.orderid = od.orderid AND
  od.userid = c.userid AND sod.productid = p.ProductID AND sod.version = p.version";
  $result = mysqli_query($con, $sql);
if(mysqli_num_rows($result) !=0)
{
  echo '<div class="collection">';
 while($data = mysqli_fetch_row($result))
 {
  echo '<div class="collection-item">';
  echo '<div class="row">
    <div class="col s3 m3 l3 xl3">';
      if(!is_null($data[7]))
        echo '<img class="materialboxed" src="images/user/'.$data[7].'">';
      else
        echo '<img class="materialboxed" src="images/user/null.jpg">';
    echo '</div>
    <div class="col s4 m4 l4 xl4">
      <p class = "left-align">';
        $count = $data[1];
        for($i=0; $i<$count; $i++)
          echo '<i class="material-icons yellow-text">star</i>';
        for($i=0; $i<5-$count;$i++)
          echo '<i class="material-icons gray-text">star</i>';
echo '</p>
    </div>
    <div class="col s5 m5 l5 xl5">
      <p class = "right-align">
        '.$data[2].'
      </p>
    </div>
  </div>
  <div class="row">
    <div class="col s3 m3 l3 xl3">';
    echo $data[4].' '.$data[5].'
    </div>
    <div class="col s9 m9 l9 xl9">
    <p>'.$data[0].'</p>
    </div>
  </div>';
echo'</div>';
 }
 echo'</div>';
}
else
  {
  echo '<div class="row">
    <div class="col s12 m12 l12 xl12">
    <p class="center-align"><span class="flow-text"><b>Don\'t have any review</b></span></p>
    </div></div>';
  }
  ?>
</div>
</div>
</div>


<!-- End of Content -->
<!-- Footer -->
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
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script>
    $(document).ready(function(){
    $('.materialboxed').materialbox();
  });
</script>
</body>
</html>