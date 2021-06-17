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
    a:link{color:green;}
    a:visited{color:green;}
    a:hover{color:green;}
    a:active{color:green;}
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
  $con=mysqli_connect("localhost","root","password","shoplada");
  //Check Connection
  if(mysqli_connect_errno())
  {
    echo"Failed to connect to mySQL:".mysqli_connect_error();
  }
  require_once ('auth/auth.database.php');
  require_once ('class/getUserClass.php');
  require_once ('auth/session.php');
  $userClass = new getUserClass();
  $session = new session();
  $userData = $session->insession($_SESSION["user"]);
  if (!$userData)
    header("location: http://e22vvb.asuscomm.com:43221/login.php");
  $con=mysqli_connect("localhost","root","password","shoplada");
  //Check Connection
  if(mysqli_connect_errno())
  {
    echo"Failed to connect to mySQL:".mysqli_connect_error();
  }
  $userid = $_SESSION["user"];
  $sql="SELECT shopid FROM shop WHERE userid = '$userid'";
  $result = mysqli_query($con,$sql);
  if($data = mysqli_fetch_row($result))
    $shopid = $data[0];
  else
    header("location: http://e22vvb.asuscomm.com:43221/login.php");

  echo '<ul class="collapsible white">';
  echo '<li class="collection-header"><p class="center-align"><span class="flow-text"><b>Order Management</b></span></p></li>';

  echo '<li>';
  echo '<div class="collapsible-header">New Order</div>';
  $sql = "SELECT sod.*, p.productname FROM subcustomerorder sod, shop s, product p
  WHERE sod.productid = p.productid AND sod.version = p.version AND p.shopid = s.shopid AND s.shopid = '$shopid' AND sod.status='1'";
  $result = mysqli_query($con,$sql);
  echo '<div class="collapsible-body">';
  $i=1;
  if(mysqli_num_rows($result) !=0){
  while ($data = mysqli_fetch_row($result))
    {
      echo '<table>';
      echo '<thead>';
        echo '<tr>';
          echo '<th>';
            echo 'Order';
          echo '</th>';
          echo '<th>';
            echo 'Product';
          echo '</th>';
          echo '<th>';
            echo 'Amount';
          echo '</th>';
          echo '<th>';
            echo 'Time';
          echo '</th>';
          echo '<th>';
            echo 'Update';
          echo '</th>';
        echo '</tr>';
      echo '</thead>';
      echo '<tbody>';
        echo '<tr>';
          echo '<td>';
            echo $i;
          echo '</td>';
          echo '<td>';
            echo $data[7];
          echo '</td>';
          echo '<td>';
            echo $data[1];
          echo '</td>';
          echo '<td>';
            echo $data[3];
          echo '</td>';
          echo '<td>';
            echo '<a href="/php/update_order.php?suborderid='.$data[0].'">Go to Package</a>';
          echo '</td>';
        echo '</tr>';
      echo '</tbody>';
      echo '</table>';
      $i++;
    }}
    else
      echo '<p class="center-align">Don\'t have any data</p>';
    echo '</div>';
    echo '</li>';


echo '<li>';
  echo '<div class="collapsible-header">Package</div>';
  $sql = "SELECT sod.*, p.productname FROM subcustomerorder sod, shop s, product p
  WHERE sod.productid = p.productid AND sod.version = p.version AND p.shopid = s.shopid AND s.shopid = '$shopid' AND sod.status='2'";
  $result = mysqli_query($con,$sql);
  echo '<div class="collapsible-body">';
  $i=1;
  if(mysqli_num_rows($result) !=0){
  while ($data = mysqli_fetch_row($result))
    {
      echo '<table>';
      echo '<thead>';
        echo '<tr>';
          echo '<th>';
            echo 'Order';
          echo '</th>';
          echo '<th>';
            echo 'Product';
          echo '</th>';
          echo '<th>';
            echo 'Amount';
          echo '</th>';
          echo '<th>';
            echo 'Time';
          echo '</th>';
          echo '<th>';
            echo 'Update';
          echo '</th>';
        echo '</tr>';
      echo '</thead>';
      echo '<tbody>';
        echo '<tr>';
          echo '<td>';
            echo $i;
          echo '</td>';
          echo '<td>';
            echo $data[7];
          echo '</td>';
          echo '<td>';
            echo $data[1];
          echo '</td>';
          echo '<td>';
            echo $data[3];
          echo '</td>';
          echo '<td>';
            echo '<a href="/php/update_order.php?suborderid='.$data[0].'">Go to Shipping</a>';
          echo '</td>';
        echo '</tr>';
      echo '</tbody>';
      echo '</table>';
      $i++;
    }}
    else
      echo '<p class="center-align">Don\'t have any data</p>';
    echo '</div>';
    echo '</li>';
      
      
    echo '<li>';
  echo '<div class="collapsible-header">Shipping</div>';
  $sql = "SELECT sod.*, p.productname FROM subcustomerorder sod, shop s, product p
  WHERE sod.productid = p.productid AND sod.version = p.version AND p.shopid = s.shopid AND s.shopid = '$shopid' AND sod.status='3'";
  $result = mysqli_query($con,$sql);
  echo '<div class="collapsible-body">';
  $i=1;
  if(mysqli_num_rows($result) !=0){
  while ($data = mysqli_fetch_row($result))
    {
      echo '<table>';
      echo '<thead>';
        echo '<tr>';
          echo '<th>';
            echo 'Order';
          echo '</th>';
          echo '<th>';
            echo 'Product';
          echo '</th>';
          echo '<th>';
            echo 'Amount';
          echo '</th>';
          echo '<th>';
            echo 'Time';
          echo '</th>';
        echo '</tr>';
      echo '</thead>';
      echo '<tbody>';
        echo '<tr>';
          echo '<td>';
            echo $i;
          echo '</td>';
          echo '<td>';
            echo $data[7];
          echo '</td>';
          echo '<td>';
            echo $data[1];
          echo '</td>';
          echo '<td>';
            echo $data[3];
          echo '</td>';
        echo '</tr>';
      echo '</tbody>';
      echo '</table>';
      $i++;
    }}
    else
      echo '<p class="center-align">Don\'t have any data</p>';
    echo '</div>';
    echo '</li>';
      
      
      echo '</div>';
      echo '</li>';

  echo '</ul>';
  ?>
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
    $('.collapsible').collapsible();
  });
</script>
</body>
</html>