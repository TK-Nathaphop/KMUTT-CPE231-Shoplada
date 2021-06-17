<?php
	$con=mysqli_connect("localhost","root","password","shoplada");
	//Check Connection
	if(mysqli_connect_errno())
	{
		echo"Failed to connect to mySQL:".mysqli_connect_error();
	}
	//escape variables for security 
    $promotion = $_GET['promo_name'];
	$start = mysqli_real_escape_string($con,$_GET['start_date']);
	$expire = mysqli_real_escape_string($con,$_GET['expire_date']);
	$condition = mysqli_real_escape_string($con,$_GET['condition']);
	$discount = mysqli_real_escape_string($con,$_GET['discount']);
	$sql = "SELECT * FROM promotion";
	$result = mysqli_query($con,$sql);
	$num = mysqli_num_rows($result);
	$i=0;
	do
		{
		$i++;
		$promo_id = "PROMO-".($num+$i);
		$sql = "SELECT promoid FROM promotion WHERE promoid = '$promo_id'";
		$result = mysqli_query($con,$sql);
		}while(mysqli_num_rows($result) != 0);
	$sql = "INSERT INTO `promotion`(`PromoID`, `PromoName`, `StartDate`, `ExpireDate`, `DiscountOrder`, `Condition`) VALUES('$promo_id','$promotion', STR_TO_DATE('$start', '%d/%m/%Y'), STR_TO_DATE('$expire', '%d/%m/%Y'), '$discount', '$condition');"; 
	 if(!mysqli_query($con,$sql))
	 {
	 	die('Error:'. mysqli_error($con));
	 }

	/* Function for generate voucher ID */
	function genRandomString() {
    	$length = 10;
    	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$string = '';    
    	for ($p = 0; $p < $length; $p++)
    		{$string .= $characters[mt_rand(0, strlen($characters))];}
    	return $string;
    }

	$number = count($_GET["cat"]);
	if($number > 0)
	{

		for($i = 0; $i < $number; $i++)
		{
			if(trim($_GET["cat"][$i] != ''))
			{
			$cat = $_GET["cat"][$i];
			$amount = $_GET['amount'][$i];
			for($j = 0; $j < $amount; $j++)
				{
				do
					{
					$voucherid = genRandomString();
					$sql = "SELECT voucherid FROM voucher WHERE voucherid = '$voucherid';";
					$result = mysqli_query($con,$sql);
					}while(mysqli_num_rows($result) != 0);

				$sql = "INSERT INTO `voucher`(`VoucherID`, `PromoID`, `CategoryID`) VALUES ('$voucherid','$promo_id','$cat')";
				if(!mysqli_query($con,$sql))
					{
					die('Error:'. mysqli_error($con));
					}
				}
			}
		}
	}
	mysqli_close($con);
	echo "<script type='text/javascript'>alert('Create Promotion Success');location= 'http://e22vvb.asuscomm.com:43221/promotion.php';</script>";
?>