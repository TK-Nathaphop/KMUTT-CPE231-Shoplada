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
  <div class="card white">
    <div class="card-content">
    <?php
     $con = mysqli_connect('localhost', 'root', 'password', 'shoplada');
     $perpage = 12;
     if (isset($_GET['page']))
      $page = $_GET['page'];
     else
      $page = 1;

      $start = ($page - 1) * $perpage;

      $sql = "SELECT p.`ProductID`, p.`Version`, p.`ProductName`, p.`Description`, p.`Price`, p.`Discount`, p.`Picture`, p.`Stock`, p.`SizeW`, p.`SizeL`, p.`SizeH`, p.`Weight`, p.`Timestamp`, p.`Flag`, p.`SubCategoryID`, p.`ShopID`, s.shopname FROM product p, shop s WHERE flag='1' AND p.shopid=s.shopid LIMIT $start, $perpage";
      $result = mysqli_query($con, $sql);
    ?>

    <?php
    $i=0;
    while ($data = mysqli_fetch_row($result)){
      if($i==0)
      echo '<div class=row>';
    else if($i==2)
      $i=0;
    $i++;
    echo '<div class="col s4 m4 l4 xl4"><a href="http://e22vvb.asuscomm.com:43221/product.php?productid='.$data[0].'&version='.$data[1].'">
    <div class="card green">
      <div class="card-image">';
    if(!is_null($data[6]))
      echo '<img src="images/product/'.$data[6].'">';
    else
      echo '<img src="images/product/null.png">';
    echo '</div>
    <div class="card-content">';
    if($data[5] != 0)
      echo '<h6><strike>'.$data[4].' ฿</strike>     '.($data[4]-$data[5]).' ฿</h6>';
    else
      echo '<h6>'.$data[4].'</h6>';
    echo '<h5>'.$data[2].'</h5>
        <p>Sell by:'.$data[16].'</p>
      </div>
    </div>
    </a></div>';
    if($i==0)
    echo '</div>';
    }
    if($i != 0)
    echo '</div>';?>
  <?php
  $sql2 = "SELECT * FROM product WHERE flag='1' ";
  $result2 = mysqli_query($con, $sql2);
  $total_record = mysqli_num_rows($result2);
  $total_page = ceil($total_record / $perpage);
  ?>
  <div class="row">
    <ul class="pagination col s12 m12 l12 xl12">
      <li>
      <a href="index.php?page=1" aria-label="Previous">
      <span aria-hidden="true">&laquo;</span>
      </a>
      </li>
    <?php for($i=1;$i<=$total_page;$i++){
      echo '<li class="waves-effect"><a href="index.php?page='.$i.'">'.$i.'</a></li>';
      }
      echo '<li>
      <a href="index.php?page='.$total_page.'" aria-label="Next">';
      ?>
    <span aria-hidden="true">&raquo;</span>
    </a>
      </li>
      </ul>
  </div>
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
</body>
</html>