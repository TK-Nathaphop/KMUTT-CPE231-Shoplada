<!DOCTYPE html>
<html>
  <head>
    <title>Register</title>
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
    	<?php 
        require_once ('auth/auth.database.php');
        require_once ('class/getUserClass.php');
        require_once ('auth/session.php');

			$userClass = new getUserClass();
			$userData = $userClass->getUserData($_SESSION['user']);
      echo $_SESSION['user'];
      ?>
      <!-- Header -->
      <nav class="green" role="navigation">
        <div class="nav-wrapper container"><a id="logo-container" href="http://35.240.164.131/index.html" class="brand-logo"><img src="http://35.240.164.131/Logo.png" width="64" height="62"></a>
        <ul class="right hide-on-med-and-down">
          <li><a href=""></a>
          	<img class="brand-logo" width="64" height="62"  src="./images/<?php echo $userData->Picture;?>" class="circle responsive-img">
          	 Welcome, <b><?php echo $userData->UserName;?></b></li>
          <li><a href="edit_profile.php">Edit Profile</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
        <ul id="nav-mobile" class="sidenav">
          <li><a href="register.php">Sign Up</a></li>
          <li><a href="logout.php">Login</a></li>
        </ul>
        <a href="javascript:void(0)" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      </div>
    </nav>
    <!-- Content (Put content below) -->
    
      
      
        <!-- End of Content -->
        <!-- Footer -->
        <footer class="page-footer green" style="position:fixed;bottom:0;left:0;width:100%;">
          <div class="container">
            <h5 class="white-text">Never Slow Down team Bio</h5>
            <p class="grey-text text-lighten-4">We are a team of KMUTT students working on database project. In our team concist of<br>
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