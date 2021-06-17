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
<div class="collection with-header">
  <div class="collection-header"><p class="center-align"><span class="flow-text"><b>Analysis Report</b></span></p></div>
  <div class="collection-item">
  <div class="row">
    <form action="analysis1.php" method="get">
    <div class="input-field col s4 m4 l4 xl4">
      The highest rating product in
    </div>
    <div class="input-field col s3 m3 l3 xl3">
      <select name ="month" id="month" class="validate" required>
          <option value="" disabled selected>Select month</option>
          <option value='01'>January</option>
          <option value='02'>February</option>
          <option value='03'>March</option>
          <option value='04'>April</option>
          <option value='05'>May</option>
          <option value='06'>June</option>
          <option value='07'>July</option>
          <option value='08'>August</option>
          <option value='09'>September</option>
          <option value='10'>October</option>
          <option value='11'>November</option>
          <option value='12'>December</option>
        </select>
      <label for="month">Month</label>
    </div>
    <div class="input-field col s3 m3 l3 xl">
      <select name ="year" id="year" required>
          <option value ="" disabled selected>Select year</option>
          <option value="2015">2015</option>
          <option value="2016">2016</option>
          <option value="2017">2017</option>
          <option value="2018">2018</option>
          <option value="2019">2019</option>
        </select>
      <label for="year">Year</label>
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      <button class="btn waves-light card-panel green" type="submit" name="action">Go</button>  
    </div>
    </form>
  </div>
  </div>
  <div class="collection-item">
  <div class="row">
    <form action="analysis2.php" method="get">
    <div class="input-field col s4 m4 l4 xl4">
      Best seller product in
    </div>
    <div class="input-field col s3 m3 l3 xl3">
      <select name ="month" id="month" class="validate" required>
          <option value="" disabled selected>Select month</option>
          <option value="01">January</option>
          <option value="02">February</option>
          <option value="03">March</option>
          <option value="04">April</option>
          <option value="05">May</option>
          <option value="06">June</option>
          <option value="07">July</option>
          <option value="08">August</option>
          <option value="09">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
      <label for="month">Month</label>
    </div>
    <div class="input-field col s3 m3 l3 xl">
      <select name ="year" id="year" required>
          <option value ="" disabled selected>Select year</option>
          <option value="2015">2015</option>
          <option value="2016">2016</option>
          <option value="2017">2017</option>
          <option value="2018">2018</option>
          <option value="2019">2019</option>
          <option value="2020">2020</option>
        </select>
      <label for="year">Year</label>
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      <button class="btn waves-light card-panel green" type="submit" name="action">Go</button>  
    </div>
    </form>
  </div>
  </div>
  <div class="collection-item">
  <div class="row">
    <form action="analysis3.php" method="get">
    <div class="input-field col s5 m5 l5 xl5">
      The most popular promotion
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      Amount of row:
    </div>
    <div class="input-field col s3 m3 l3 xl3">
        <input type="number" name="amount" value="5" required/>
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      <button class="btn waves-light card-panel green" type="submit" name="action">Go</button>  
    </div>
    </form>
  </div>
  </div>
  <div class="collection-item">
  <div class="row">
    <form action="analysis4.php" method="get">
    <div class="input-field col s4 m4 l4 xl4">
      The best selling category in 
    </div>
    <div class="input-field col s3 m3 l3 xl3">
      <select name ="month" id="month" class="validate" required>
          <option value="" disabled selected>Select month</option>
          <option value="01">January</option>
          <option value="02">February</option>
          <option value="03">March</option>
          <option value="04">April</option>
          <option value="05">May</option>
          <option value="06">June</option>
          <option value="07">July</option>
          <option value="08">August</option>
          <option value="09">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
      <label for="month">Month</label>
    </div>
    <div class="input-field col s3 m3 l3 xl3">
      <select name ="year" id="year" required>
          <option value ="" disabled selected>Select year</option>
          <option value="2015">2015</option>
          <option value="2016">2016</option>
          <option value="2017">2017</option>
          <option value="2018">2018</option>
          <option value="2019">2019</option>
          <option value="2020">2020</option>
        </select>
      <label for="year">Year</label>
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      <button class="btn waves-light card-panel green" type="submit" name="action">Go</button>  
    </div>
    </form>
  </div>
  </div>
  <div class="collection-item">
  <div class="row">
    <form action="analysis5.php" method="get">
    <div class="input-field col s4 m4 l4 xl4">
      The highest spender in
    </div>
    <div class="input-field col s3 m3 l3 xl3">
      <select name ="month" id="month" class="validate" required>
          <option value="" disabled selected>Select month</option>
          <option value="01">January</option>
          <option value="02">February</option>
          <option value="03">March</option>
          <option value="04">April</option>
          <option value="05">May</option>
          <option value="06">June</option>
          <option value="07">July</option>
          <option value="08">August</option>
          <option value="09">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
      <label for="month">Month</label>
    </div>
    <div class="input-field col s3 m3 l3 xl3">
      <select name ="year" id="year" required>
          <option value ="" disabled selected>Select year</option>
          <option value="2015">2015</option>
          <option value="2016">2016</option>
          <option value="2017">2017</option>
          <option value="2018">2018</option>
          <option value="2019">2019</option>
          <option value="2020">2020</option>
        </select>
      <label for="year">Year</label>
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      <button class="btn waves-light card-panel green" type="submit" name="action">Go</button>  
    </div>
    </form>
  </div>
  </div>
  <div class="collection-item">
  <div class="row">
    <form action="analysis6.php" method="get">
    <div class="input-field col s5 m5 l5 xl5">
      The best profit from product
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      Amount of row:
    </div>
    <div class="input-field col s3 m3 l3 xl3">
        <input type="number" name="amount" value="5" required/>
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      <button class="btn waves-light card-panel green" type="submit" name="action">Go</button>  
    </div>
    </form>
  </div>
  </div>
  <div class="collection-item">
  <div class="row">
    <form action="analysis7.php" method="get">
    <div class="input-field col s10 m10 l10 xl10">
      The highest ordered time range
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      <button class="btn waves-light card-panel green" type="submit" name="action">Go</button>  
    </div>
    </form>
  </div>
  </div>
  <div class="collection-item">
  <div class="row">
    <form action="analysis8.php" method="get">
    <div class="input-field col s10 m10 l10 xl10">
      The most popular payment method
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      <button class="btn waves-light card-panel green" type="submit" name="action">Go</button>  
    </div>
    </form>
  </div>
  </div>
  <div class="collection-item">
  <div class="row">
    <form action="analysis9.php" method="get">
    <div class="input-field col s4 m4 l4 xl4">
      The best seller shop in
    </div>
    <div class="input-field col s6 m6 l6 xl6">
      <select name ="year" id="year" required>
          <option value ="" disabled selected>Select year</option>
          <option value="2015">2015</option>
          <option value="2016">2016</option>
          <option value="2017">2017</option>
          <option value="2018">2018</option>
          <option value="2019">2019</option>
          <option value="2020">2020</option>
        </select>
      <label for="year">Year</label>
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      <button class="btn waves-light card-panel green" type="submit" name="action">Go</button>  
    </div>
    </form>
  </div>
  </div>
  <div class="collection-item">
  <div class="row">
    <form action="analysis10.php" method="get">
    <div class="input-field col s10 m10 l10 xl10">
      The most monthly commission free
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      <button class="btn waves-light card-panel green" type="submit" name="action">Go</button>  
    </div>
    </form>
  </div>
  </div>
  <div class="collection-item">
  <div class="row">
    <form action="analysis11.php" method="get">
    <div class="input-field col s4 m4 l4 xl4">
      Top 3 best seller month in
    </div>
    <div class="input-field col s6 m6 l6 xl6">
      <select name ="year" id="year" required>
          <option value ="" disabled selected>Select year</option>
          <option value="2015">2015</option>
          <option value="2016">2016</option>
          <option value="2017">2017</option>
          <option value="2018">2018</option>
          <option value="2019">2019</option>
          <option value="2020">2020</option>
        </select>
      <label for="year">Year</label>
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      <button class="btn waves-light card-panel green" type="submit" name="action">Go</button>  
    </div>
    </form>
  </div>
  </div>
  <div class="collection-item">
  <div class="row">
    <form action="analysis12.php" method="get">
    <div class="input-field col s10 m10 l10 xl10">
      Top 3 highest reviewed shop
    </div>
    <div class="input-field col s2 m2 l2 xl2">
      <button class="btn waves-light card-panel green" type="submit" name="action">Go</button>  
    </div>
    </form>
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
  <script>
        document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var options = document.querySelectorAll('option');
        var instances = M.FormSelect.init(elems, options);
        });
      </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(elems, options);
  });
</script>
</body>
</html>