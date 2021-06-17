<?php
  $con=mysqli_connect("localhost","root","password","shoplada");
  //Check Connection
  if(mysqli_connect_errno())
  {
    echo"Failed to connect to mySQL:".mysqli_connect_error();
  }
  //escape variables for security 
  $voucheridold = $_GET['action'];
  $voucheridnew = $_GET['voucherid'];
  $promoid = $_GET['promoid'];
  $categoryid = $_GET['categoryid'];
  $sql = "UPDATE `voucher` SET `VoucherID`='$voucheridnew',`PromoID`='$promoid',`CategoryID`= '$categoryid' WHERE voucherid = '$voucheridold'";
   if(!mysqli_query($con,$sql))
   {
    die('Error:'. mysqli_error($con));
   }

  mysqli_close($con);
  echo "<script type='text/javascript'>alert('Update Voucher Success');location= 'http://e22vvb.asuscomm.com:43221/promotion.php';</script>";
?>