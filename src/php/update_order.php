<?php
	$con=mysqli_connect("localhost","root","password","shoplada");
	//Check Connection
	if(mysqli_connect_errno())
	{
		echo"Failed to connect to mySQL:".mysqli_connect_error();
	}
	//escape variables for security 
    $suborderid = $_GET['suborderid'];
    $sql = "SELECT status FROM subcustomerorder WHERE suborderid = '$suborderid'";
    $result = mysqli_query($con, $sql);
    if($data = mysqli_fetch_row($result))
    	$status = $data[0];
    else
    	die('Error: Can\'t find the suborder');

    if($status == 1 || $status == 2)
    	$status++;
    else
    	die('Error: Can\'t update the order');
    $date = date("d/m/Y H:i:s");

	$sql = "UPDATE `subcustomerorder`
	SET `Status`='$status',`StatusTime`=STR_TO_DATE('$date', '%d/%m/%Y %H:%i:%s') WHERE suborderid = '$suborderid'";
	 if(!mysqli_query($con,$sql))
	 {
	 	die('Error:'. mysqli_error($con));
	 }
	mysqli_close($con);
	echo "<script type='text/javascript'>location= 'http://e22vvb.asuscomm.com:43221/ordermanage.php';</script>";
?>