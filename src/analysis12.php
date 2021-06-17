<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Shoplada</title>

 <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
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
  <div class="card white">
  <div class="card-content">
    <?php
    $con=mysqli_connect("localhost","root","password","shoplada");
     //Check Connection
     if(mysqli_connect_errno())
     {
       echo"Failed to connect to mySQL:".mysqli_connect_error();
     }
      $sql = "SELECT s.shopname AS shop, COUNT(r.reviewid) AS count, avg(r.star) AS star
             FROM shop s, product p, review r, subcustomerorder sod
             WHERE s.shopid = p.shopid AND p.productid = sod.productid AND sod.suborderid = r.suborderid
             GROUP BY shop
             ORDER BY star DESC,count DESC";
      $result = mysqli_query($con,$sql);
      if(mysqli_num_rows($result) != 0)
        {
           echo '<table>
                  <thead>
                    <tr>
                      <th>Shop Name</th>
                      <th>Amount</th>
                      <th>Star</th>
                    </tr>
                  </thead>
                  <tbody>';
             for($i=0; $i<10 && $data=mysqli_fetch_row($result); $i++)
             {
               echo '<tr>
                 <td>'.$data[0].'</td>
                 <td>'.$data[1].'</td>
                 <td>'.$data[2].'</td>
               </tr>';
             }
           echo '  </tbody>
           </table>';

         }
       else
       {
        echo "<p class='center-align'>Don't have any data</p>";
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
    <!-- AJAX -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var options = document.querySelectorAll('option');
        var instances = M.FormSelect.init(elems, options);
        });
      </script>
  <script> //Script
function(){
  $('#month').on('change',function(e){
      e.preventDefault();
  var month = $('#month').val();
  var year = $('#year').val();
  if(month && year){
    $.ajax({
        type: "POST",
        dataType: 'json',
        cache: false,
        url: "php/analysis_1.php",
        data: { month: month,
                year: year},
        success:function(html){
          $('tbody').html(html);
        }
    }); 
  }
  else{
      $('tbody').html('<p class="center-align">No Data</p>');
      }
  });
};
</script>
</body>
</html>