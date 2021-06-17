<?php

$con=mysqli_connect("localhost","root","password","shoplada");
	//Check Connection
	if(mysqli_connect_errno())
	{
		echo"Failed to connect to mySQL:".mysqli_connect_error();
	}

$catid = mysqli_real_escape_string($con,$_GET['catid']);
$sql = "SELECT * FROM subcategory WHERE categoryid = '$catid';";
$result = mysqli_query($con,$sql);

//echo '<option value="" disabled selected>Choose Subcategory</option>';
while($data = mysqli_fetch_row($result))
{
   echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}
mysqli_close($con);
?>