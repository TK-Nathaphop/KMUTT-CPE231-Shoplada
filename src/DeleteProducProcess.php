<?php
// Create connection
$con=mysqli_connect("localhost","root","password","shoplada");
// Check connection
if(mysqli_connect_errno())
	{
		echo"Failed to connect to mySQL:".mysqli_connect_error();
	}
    else
        {
        $productid = $_GET['productid'];
        // $Product = mysqli_real_escape_string($con,$_POST['Name']);
        // $Price = mysqli_real_escape_string($con,$_POST['price']);
        // $Describe = mysqli_real_escape_string($con,$_POST['describe']);
        // $Picture = mysqli_real_escape_string($con,$_POST['picPath']);
        // $Stock = mysqli_real_escape_string($con,$_POST['stock']);
        // $SizeW = mysqli_real_escape_string($con,$_POST['SizeW']);
        // $SizeL = mysqli_real_escape_string($con,$_POST['SizeL']);
        // $SizeH = mysqli_real_escape_string(  $con,$_POST['SizeH']);
        // $Weight = mysqli_real_escape_string($con,$_POST['Weight']);
        // $Discount = mysqli_real_escape_string($con,$_POST['discount']);
        // $SubCategory = mysqli_real_escape_string($con,$_POST['scat']);
        
        
        $sql = "UPDATE product SET Flag = 0 WHERE productid = '$productid'; " ;

        // $result = mysqli_query($con,$sql);
        if(mysqli_query($con, $sql)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
        }

    }
    header("location:ShopManagement.php");
?>