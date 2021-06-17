<?php
  $con=mysqli_connect("localhost","root","password","shoplada");
  //Check Connection
  if(mysqli_connect_errno())
  {
    echo"Failed to connect to mySQL:".mysqli_connect_error();
  }
  //escape variables for security 
  $voucherid = $_GET['voucherid'];
  $categoryid = $_GET['categoryid'];
  $sql = "DELETE FROM `voucher` WHERE voucherid = '$voucherid'";
   if(!mysqli_query($con,$sql))
   {
    die('Error:'. mysqli_error($con));
   }

  mysqli_close($con);
  echo "<script type='text/javascript'>alert('Delete Voucher Success');location= 'http://e22vvb.asuscomm.com:43221/promotion.php';</script>";
?>