<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Shoplada</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <!-- AJAX -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

  <script>
        document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var options = document.querySelectorAll('option');
        var instances = M.FormSelect.init(elems, options);
        });
      </script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems,{format:'dd/mm/yyyy'})});
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
<form action="php/add_promotion.php" method="get">
<div class="card white">
<div class="card-content">
    <div class="row">
      <div class="input-field col s12 m12 l12 xl12">
        <p class="center-align"><span class="flow-text"><b>Promotion</b></span></p>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m12 l12 xl12">
        <input name="promo_name" id="promo_name" type="text" class="validate" required/>
        <label for="promo_name">Promotion Name</label>
      </div>
    </div>
    <div class = "row">
      <div class="input-field col s6 m6 l6 xl6">
        <i class="material-icons prefix">date_range</i>
        <input name="start_date" id="start_date" type="text" class="datepicker" required/>
        <label for="start_date">Start Date</label>
      </div>
      <div class="input-field col s6 m6 l6 xl6">
        <i class="material-icons prefix">date_range</i>
        <input name="expire_date" id="expire_date" type="text" class="datepicker" required/>
        <label for="expire_date">Expire Date</label>
      </div>
    </div> 
    <div class="row">
      <div class="input-field col s6 m6 l6 xl6">
        <input name="condition" id="discount" type="text" class="validate" value ="0" required/>
        <label for="condition">Condition</label>
      </div>
      <div class="input-field col s6 m6 l6 xl6">
        <input name="discount" id="discount" type="text" class="validate" required/>
        <label for="discount">Discount</label>
      </div>
    </div>
</div>
</div>

<div class="card white">
<div class="card-content">
<div class="row">
      <div class="input-field col s12 m12 l12 xl12">
        <p class="center-align"><span class="flow-text"><b>Voucher</b></span></p>
      </div>
    </div>
<div class="row"> <button type="button" name="add" id="add" class="btn btn-success card-panel green">Add Voucher</button>   </div>
  <div id="voucher">
  </div>
</div>  
</div>
<button class="btn waves-light card-panel green" type="submit" name="action">Submit<i class="material-icons right">send</i></button>
</form>
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
var i=0;

$(document).ready(function(){
  $('#add').click(function(){
    i++;
    $('#voucher').append('<div class="row" id="catvoucher'+i+'"><div class="input-field col s5 m5 l5 xl5">  <select name="cat[]" id="cat'+i+'" class="validate" required> <option value="" disabled selected>Choose Category</option><option value="CAT-01">Electronic</option>    <option value="CAT-02">TV & Home Apilances</option>    <option value="CAT-03">Health Beauty</option>    <option value="CAT-04">Babies & Toys</option>    <option value="CAT-05">Groceries & Pets</option>    <option value="CAT-06">Home & Lifestyle</option>    <option value="CAT-07">Women\'s Fashion</option><option value="CAT-08">Men\'s Fashion</option><option value="CAT-09">Fashion Accessories</option>    <option value="CAT-10">Sport & Travel</option>  </select>  <label for="cat'+i+'">Category</label></div><div class="input-field col s5 m5 l5 xl5">  <input type="text" name="amount[]"placeholder = "Amount" class="validate" required/> </div><div class="input-field col s2 m2 l2 xl2">  <button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove card-panel green">X</button></div></div>');
    $(document).ready(function(){
      $('select').formSelect();
    });
  });
});

  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $("div").remove('#catvoucher'+button_id);
  });
</script>