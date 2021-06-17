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

      <script>
        document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var options = document.querySelectorAll('option');
        var instances = M.FormSelect.init(elems, {options});
        });
      </script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems,{format:'yyyy-mm-dd'})});
    </script>
    </head>

    <body bgcolor="#eaeaea">
      <?php 
        require_once ('auth/auth.database.php');
        require_once ('auth/session.php');
        require_once ('class/registerClass.php');
        $session = new session();
        if ($session->insession()) {
          ?>
          <script type="text/javascript">swal("Fail to register", "To register please logout", "error")
          .then((value) => {
              window.location = "index.php";
            });
          </script>
        <?php
        }
          if(!empty($_POST["submit_button"])){
            if(isset($_FILES['image'])){
              $errors= array();
              $file_name = $_FILES['image']['name'];
              $file_size = $_FILES['image']['size'];
              $file_tmp = $_FILES['image']['tmp_name'];
              $file_type = $_FILES['image']['type'];
              $tmp = explode('.',$_FILES['image']['name']);
              $file_ext = end($tmp);
              $expensions= array("jpeg","jpg","png");
                
              if(in_array($file_ext,$expensions)=== false){
                  $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                  $regisClass = new regisClass();
                  $countAllUser = $regisClass->getNewUserID();
                  $countAllAddr = $regisClass->getNewAddrID();
                  $newUserID = $countAllUser+1;
                  $newAddrID = $countAllAddr+1;
                  $txtUserID = "USER-".$newUserID;
                  $txtAddrID = "ADDR-".$newAddrID;
                  $filename_user = "NULL";
                  $regisData = $regisClass->registerData($txtUserID,$_POST['UserName'],$_POST['Password'],$_POST['FirstName'],$_POST['LastName'],$_POST['Mail'],$_POST['DOB'],$_POST['Phone'],$filename_user);
                  
                  $regisAddress = $regisClass->registerAddress($_POST['Address'],$_POST['Province'],$_POST['Road'],$_POST['District'],$_POST['Postcode'],$_POST['PhoneNumber'],$txtUserID,$txtAddrID);

                  if($regisData && $regisAddress){
                      ?>
                        <script type="text/javascript">swal("Success", "Data recorded", "success")
                        .then((value) => {
                            window.location = "login.php";
                          });
                        </script>
                      <?php
                      exit();
                  }
                  else{
                    // print_r($errors);
                    ?>
                    <script type="text/javascript">swal("Warning", "Please fill in correctly", "warning");</script>
                    <?php
                    }
              }

              if($file_size > 2097152) {
                 $errors[]='File size must be excately 2 MB';
              }
                
              if(empty($errors)==true) {
                $regisClass = new regisClass();
                $countAllUser = $regisClass->getNewUserID();
                $countAllAddr = $regisClass->getNewAddrID();
                $newUserID = $countAllUser+1;
                $newAddrID = $countAllAddr+1;
                $txtUserID = "USER-".$newUserID;
                $txtAddrID = "ADDR-".$newAddrID;
                $filename_user = $txtUserID.".".$file_ext;

                //defined variable to send to sql and save files
                $regisData = $regisClass->registerData($txtUserID,$_POST['UserName'],$_POST['Password'],$_POST['FirstName'],$_POST['LastName'],$_POST['Mail'],$_POST['DOB'],$_POST['Phone'],$filename_user);
              
                $regisAddress = $regisClass->registerAddress($_POST['Address'],$_POST['Province'],$_POST['Road'],$_POST['District'],$_POST['Postcode'],$_POST['PhoneNumber'],$txtUserID,$txtAddrID);

                $regisUpload = move_uploaded_file($file_tmp,"images/".$filename_user);
                  
                if($regisData && $regisAddress && $regisUpload){
                  ?>
                    <script type="text/javascript">swal("Success", "Data recorded", "success") //พารามิตเตอร์สุดท้ายคือicon
                    .then((value) => {
                        window.location = "login.php";
                      });
                    </script>
                  <?php
                } 
              }else{
                //print_r($errors);
                ?>
                <script type="text/javascript">swal("Warning", "Image errored", "warning");</script>
                <?php
                }
            }
          }
      ?>
      <nav class="green" role="navigation">
        <div class="nav-wrapper container"><a id="logo-container" href="index.php" class="brand-logo"><img src="images/logo.png" width="64" height="62"></a>
        <ul class="right hide-on-med-and-down">
          <li><a href="login.php">Login</a></li>
        </ul>

        <ul id="nav-mobile" class="sidenav">
          <li><a href="login.php">Login</a></li>
        </ul>
        <a href="javascript:void(0)" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
      </nav>
    <!--END HEADER-->
      <div class="container">
        <div class="card-panel white" style="margin-top: 15px;">
          <form name="form1" action="" method="post" id="myform" enctype="multipart/form-data">
            <div class="row">
            <div class="col l12">
              <p class="center-align"><span class="flow-text"><b>Register</b></span></p>
              <div class="row">
                <div class="col l6 m12 s12">
                  <div class="input-field col l12 m12 s12">
                    <i class="material-icons prefix">account_circle</i>
                    <input placeholder="6-16 characters" id="UserName" type="text" class="validate" name="UserName"
                    minlength="6" maxlength="16" required>
                    <label for="UserName">Username</label>
                  </div>
                  <div class="input-field col l12 m12 s12">
                    <i class="material-icons prefix">lock</i>
                    <input placeholder="6-16 characters" id="Password" type="password" name="Password" minlength="6" maxlength="16" required>
                    <label id="lblPassword" for="Password">Password</label>
                    <span class="helper-text" data-error="Password not match" data-success="Password match"></span>
                  </div>
                  <div class="input-field col l12 m12 s12">
                    <i class="material-icons prefix">lock</i>
                    <input placeholder="6-16 characters" id="Re-Password" type="password" name="Re-Password" minlength="6" maxlength="16" required>
                    <label id="lblRe-Password" for="Re-Password">Please retype your password</label>
                    <span class="helper-text" data-error="Password not match" data-success="Password match"></span>
                  </div>
                <div class="input-field col l6 m6 s12">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="FirstName" type="text" class="validate" name="FirstName" required>
                  <label for="FirstName">First name</label>
                </div>
                <div class="input-field col l6 m6 s12">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="LastName" type="text" class="validate" name="LastName" required>
                  <label for="LastName">Last name</label>
                </div>
                <div class="input-field col l6 m6 s12">
                  <i class="material-icons prefix">local_phone</i>
                  <input id="Phone" type="text" class="validate" name="Phone" minlength="9" maxlength="10" required>
                  <label for="Phone">Mobile phone</label>
                </div>
              <div class="input-field col l6 m6 s12">
                <i class="material-icons prefix">date_range</i>
                <input id="DOB" type="text" class="datepicker" name="DOB" required>
                <label for="DOB">Date of birth</label>
              </div>
              <div class="input-field col l12 m12 s12">
                  <i class="material-icons prefix">contact_mail</i>
                  <input id="Mail" type="email" class="validate" name="Mail" required>
                  <label for="Mail">E-mail</label>
                </div>
            </div>
            <div class="col l6 m12 s12">
              <div class="input-field col l12 m12 s12">
                <i class="material-icons prefix">add_location</i>
                <input id="Address" type="text" class="validate" name="Address" required>
                <label for="Address">Address</label>
              </div>
              <div class="input-field col l12 m12 s12">
                <i class="material-icons prefix">add_location</i>
                <input id="Road" type="text" class="validate" name="Road" required>
                <label for="Road">Road</label>
              </div>
              <div class="input-field col l12 m12 s12">
                <i class="material-icons prefix">add_location</i>
                <input id="District" type="text" class="validate" name="District" required>
                <label for="District">District</label>
              </div>
              <div class="input-field col l12 m12 s12">
                <i class="material-icons prefix">add_location</i>
                <input id="Province" type="text" class="validate" name="Province" required>
                <label for="Province">Province</label>
              </div>
              <div class="input-field col l12 m12 s12">
                <i class="material-icons prefix">add_location</i>
                <input id="Postcode" type="text" class="validate" name="Postcode" required>
                <label for="Postcode">Postcode</label>
              </div>
              <div class="input-field col l12 m12 s12">
                <i class="material-icons prefix">call_end</i>
                <input id="PhoneNumber" type="text" class="validate" name="PhoneNumber" required>
                <label for="PhoneNumber">PhoneNumber</label>
              </div>
              <div class="file-field input-field col l12 m12 s12">
                <div class="btn">
                  <span>File</span>
                  <input type="file" name="image">
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text">
                </div>
              </div>
            </div>
          <div class="col l12 m12 s12">
            <div class="center-align">
              <input type="submit" id="submit_button" name="submit_button" style="color:#fff;" class="btn waves-light card-panel green" value="SUBMIT">
            </div>
          </div>
        </div>
        </form>
        </div>
          </div>
        </div>
      </div>
      <!--END BODY-->
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
      
      <script>
        $("#Password").keyup(()=>{
          const password = $("#Password").val()
          const re_password = $("#Re-Password").val()
          if(password !== re_password){
            $("#Password").addClass("invalid").removeClass('valid')
            $("#Re-Password").addClass("invalid").removeClass("valid")
            $("#submit_button").addClass("disabled")
          }else{
            $("#Password").removeClass("invalid").addClass("valid")
            $("#Re-Password").removeClass("invalid").addClass("valid")
            $("#submit_button").removeClass("disabled")
          }
        })
        $("#Re-Password").keyup(()=>{
          const password = $("#Password").val()
          const re_password = $("#Re-Password").val()
          if(password !== re_password){
            $("#submit_button").addClass("disabled")
            $("#Re-Password").addClass("invalid").removeClass("valid")
            $("#Password").addClass("invalid").removeClass('valid')
          }else{
            $("#Re-Password").removeClass("invalid").addClass("valid")
            $("#Password").removeClass("invalid").addClass("valid")
            $("#submit_button").removeClass("disabled")
          }
        })
      </script>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems, {});
        });
      </script>
      <script type="text/javascript" src="./assets/js/sweetalert.js"></script>
    </body>
  </html>