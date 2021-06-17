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
  $sql = "SELECT promoid, promoname, DATE_FORMAT(startdate, '%d/%m/%Y'), DATE_FORMAT(expiredate, '%d/%m/%Y'), discountorder,`condition` FROM promotion";
  $resultpromo = mysqli_query($con,$sql);
  echo '<ul class="collapsible white">';
  echo '<li class="collection-header"><p class="center-align"><span class="flow-text"><b>Promotion</b></span></p></li>';
  while ($promotion = mysqli_fetch_row($resultpromo))
    {
      echo '<li>';
      echo '<div class="collapsible-header">Promotion: '.$promotion[1].'</div>';
      echo '<div class="collapsible-body">';
      echo '<p>Start Date: '.$promotion[2].'<br>Expire Date: '.$promotion[3].'<br>Condition to discount: '.$promotion[5].'<br>Discount amount: '.$promotion[4].'<br><a href="http://e22vvb.asuscomm.com:43221/editpromotion.php?promoid='.$promotion[0].'" class="waves-effect waves-light btn green">Edit Promotion</a></p>';

      /*Voucher*/
      $sql = "SELECT DISTINCT c.categoryname AS cat, v.promoid AS promoid, v.categoryid AS categoryid
              FROM voucher v, category c
              WHERE v.categoryid = c.categoryid AND v.promoid = '$promotion[0]'";
      $resultcat = mysqli_query($con,$sql);
      if(mysqli_num_rows($resultcat) != 0)
        {
        echo '<ul class="collapsible white">';
        echo '<li class="collection-header"><p class="center-align"><span class="flow-text">Voucher</span></p></li>';
        while($cat = mysqli_fetch_row($resultcat))
          {
          echo '<li>';
          echo '<div class="collapsible-header">Voucher Category: '.$cat[0];
          $sql = "SELECT * FROM voucher WHERE promoid = '$cat[1]' AND categoryid = '$cat[2]'";
          $resultvoucher = mysqli_query($con, $sql);
          $amount = mysqli_num_rows($resultvoucher);
          echo '<span class="badge">Amount: '.$amount.'</span></div>';
          echo '<div class="collapsible-body">';
          echo '<table><tbody>';
          while ($voucher = mysqli_fetch_row($resultvoucher))
            {
            echo '<tr>
            <td>Voucher ID: '.$voucher[0].'</td>
            <td>Status: ';
            $sql = "SELECT * FROM customerorder WHERE voucherid = '$voucher[0]'";
            $resultstatus = mysqli_query($con, $sql);
            if(mysqli_num_rows($resultstatus) != 0) //Use already
              echo '<i class="large material-icons red-text" style="font-size: 15px">clear</i>';
            else //Available
              echo '<i class="large material-icons green-text" style="font-size: 15px">check</i>';
            echo '</td>';
            if(mysqli_num_rows($resultstatus) != 0)
            echo '<td class = "right-align"><a href="http://e22vvb.asuscomm.com:43221/editvoucher.php?voucherid='.$voucher[0].'" class="waves-effect waves-light btn green disabled">Edit Voucher</a></td>
            </tr>';
            else
            echo '<td class = "right-align"><a href="http://e22vvb.asuscomm.com:43221/editvoucher.php?voucherid='.$voucher[0].'" class="waves-effect waves-light btn green">Edit Voucher</a></td>
            </tr>';
            }
          echo '</tbody></table>';
          echo '</div>';
          echo '</li>';
          }
        
        echo '</ul>';
        }
      else
        {
        echo '<p class="center-align">Don\'t have any voucher</p>';
        }
      
      echo '</div>';
      echo '</li>';

    }
  echo '<li class="green"><a href="http://e22vvb.asuscomm.com:43221/addpromotion.php"><div class="collection"><p class="center-align">Add New Promotion</p></div></a></li>';
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
</body>
</html>
<script>
  $(document).ready(function(){
    $('.collapsible').collapsible();
  });
</script>