<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "shoplada";
$con = mysqli_connect($hostname,$username,$password,$dbname);
if(mysqli_connect_errno())
{
  echo"Failed to connect to mySQL:".mysqli_connect_error();
}
$userData = $userClass->getUserData($_SESSION["user"]);
$UserID = $_SESSION["user"];
$AddressQuery = "SELECT * FROM address WHERE UserID ='$UserID'";  /* น่าจะต้องแก้เป็น Query จาก OrderID -> UserID -> Address*/
$objQuery = mysqli_query($con,$AddressQuery);
if(!$objQuery)
{
  die("Can't query Address".mysqli_error($con));
}
else {
  while($row=mysqli_fetch_array($objQuery))
  {
    
    array_push($users, $row);

  }
}
echo json_encode(value)
?>