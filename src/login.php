<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
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
    </head>
    <body>
      <!-- Header -->
      <?php
      require_once ('auth/auth.database.php');
      require_once ('auth/session.php');
      require_once ('class/getUserClass.php');
      require_once ('class/registerClass.php');
      require_once ('class/updateClass.php');
      $updateClass = new updateUser();
      $userClass = new getUserClass();
      $session = new session();
      if ($session->insession()) {
        header("location: index.php");
      }
      ?>
      <nav class="green" role="navigation">
        <div class="nav-wrapper container">
          <a id="logo-container" href="index.php" class="brand-logo"><img src="images/logo.png" width="64" height="62"></a>
          <ul class="right hide-on-med-and-down">
            <li><a href="register.php">Register</a></li>
          </ul>
          <ul id="nav-mobile" class="sidenav">
            <li><a href="register.php">Register</a></li>
          </ul>
          <a href="javascript:void(0)" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
      </nav>
    <!-- Content (Put content below) -->
      <br>
      <?php 
        require_once ('auth/auth.database.php');
        require_once ('class/loginClass.php');

        if(!empty($_POST['loginSubmit'])){
          $loginClass = new loginClass();
          $login = $loginClass->userLogin($_POST['username'],$_POST['password']);
            if($login){
              ?>
              <script type="text/javascript">swal("สำเร็จ", "เข้าสู่ระบบสำเร็จ", "success")
              .then((value) => { 
                  window.location = "index.php";
                });
              </script>
              <?php
            }else{
              ?>
              <script type="text/javascript">swal("ผิดพลาด", "ไม่สามารถเข้าสู่ระบบได้", "error")
              .then((value) => {
                  window.location = "login.php";
                });
              </script>
          <?php
            }
        }
      ?>
    
    <!-- Container & Card -->
    <div class="container">
      <div class="card-panel white" style="display: block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">
        <form method="post" action="">
          <div class='row'>
            <div class="col l12 center-align">
              <img src="./images/logo2.png" width="150">
              <p><span class="flow-text"><b>Welcome to ShopLada! Please login.</b></span></p>
              <div class="row">  
                <div class='input-field col l12 m12 s12'>
                  <input class='validate' type="text" name='username' id="username" required />
                  <label for='username'>Username</label>
                </div>
              </div>
              <div class="row">
                <div class='input-field col l12 m12 s12'>
                  <input class='validate' type='password' name='password' id="password" required />
                  <label for='password'>Password</label>
                </div>
              </div>
            </div>
         <div class="row">
           <input type="submit" name="loginSubmit" style="color:#fff; width: 100%;" class="btn waves-light green" value="Login">
        </div>
      </form>
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
        <!--  Scripts -->
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="js/materialize.js"></script>
        <script src="js/init.js"></script>
      </body>
    </html>