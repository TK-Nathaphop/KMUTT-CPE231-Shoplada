<?php
require_once ('auth/auth.database.php');
require_once ('class/getUserClass.php');
require_once ('auth/session.php');
  $userClass = new getUserClass();
  $session = new session();
  $userData = $session->insession($_SESSION["user"]);
  if (!$userData)
    header("location: http://e22vvb.asuscomm.com:43221/login.php");
$userid = $_SESSION["user"];
$productid = $_GET['productid'];
$version = $_GET['version'];
$amount = $_GET['amount'];
$date = date("d/m/Y H:i:s");

$con=mysqli_connect("localhost","root","password","shoplada");
if(mysqli_connect_errno())
    echo"Failed to connect to mySQL:".mysqli_connect_error();
if(!isset($_GET['productid']) || !isset($_GET['version']) || !isset($_GET['amount']))
	echo "Error can't add to cart";

$sql = "SELECT orderid
FROM customerorder
WHERE userid = '$userid' AND
orderid NOT IN(SELECT orderid
				FROM subcustomerorder
				WHERE status != 0)
ORDER BY `Datetime` DESC";
 $result = mysqli_query($con, $sql);
 if($data = mysqli_fetch_row($result))
 	$orderid = $data[0];
 else
 {
 	$sql = "SELECT * FROM customerorder";
	$result = mysqli_query($con,$sql);
	$num = mysqli_num_rows($result);
 	$j=0;
	do
		{
		$j++;
		$orderid = "OD-".($num+$j);
		$sql = "SELECT * FROM customerorder WHERE orderid = '$orderid'";
		$result = mysqli_query($con,$sql);
		}while(mysqli_num_rows($result) != 0);
 	$sql= "INSERT INTO `customerorder`(`OrderID`, `DateTime`, `UserID`) VALUES ('$orderid',STR_TO_DATE('$date', '%d/%m/%Y %H:%i:%s'),'$userid')";
 	if(!mysqli_query($con,$sql))
	 {
	 	die('Error:'. mysqli_error($con));
	 }
 }
 $sql = "SELECT * FROM subcustomerorder WHERE orderid = '$orderid' AND productid ='$productid' AND version = '$version'";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result) != 0)
	echo "<script>
		alert('It\'s already in cart!');
		location= 'http://e22vvb.asuscomm.com:43221/product.php?productid=".$productid."&version=".$version."';</script>";
else
	{
$sql = "SELECT * FROM suborder WHERE orderid = '$orderid'";
$result = mysqli_query($con,$sql);
$num = mysqli_num_rows($result);
$j=0;
do
 {
 $j++;
 $suborderid = "S".$orderid."-".($num+$j);
 $sql = "SELECT * FROM subcustomerorder WHERE suborderid = '$suborderid'";
 $result = mysqli_query($con,$sql);
 }while(mysqli_num_rows($result) != 0);
$sql = "INSERT INTO `subcustomerorder`(`SubOrderID`, `Amount`, `Status`, `StatusTime`, `ProductID`, `Version`, `OrderID`)
 VALUES ('$suborderid','$amount', '0' ,STR_TO_DATE('$date', '%d/%m/%Y %H:%i:%s'),'$productid','$version','$orderid')";
 if(!mysqli_query($con,$sql))
	 {
	 	die('Error:'. mysqli_error($con));
	 }
	 echo "<script type='text/javascript'>alert('Add in cart success');location= 'http://e22vvb.asuscomm.com:43221/product.php?productid=".$productid."&version=".$version."';</script>";
	}
?>