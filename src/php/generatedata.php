<?php

//For random
//PHP array containing forenames.
$names = array(
    'Christopher',
    'Ryan',
    'Ethan',
    'John',
    'Zoey',
    'Sarah',
    'Michelle',
    'Samantha',
    'Jack',
    'Note',
    'Tong',
    'Bright',
    'TK',
    'Ohio',
    'Yamada',
    'Ari',
    'Leona',
    'Rengar',
    'Annie',
    'Jax',
    'Fizz',
    'Khazix',
    'Kaisa',
    'Pyke',
    'Zyra'
);
 
//PHP array containing surnames.
$surnames = array(
    'Walker',
    'Thompson',
    'Anderson',
    'Johnson',
    'Tremblay',
    'Peltier',
    'Cunningham',
    'Simpson',
    'Mercado',
    'Sellers',
    'Winnie',
    'Rungchai',
    'Chawakorn',
    'Saiwongse',
    'Toshiba',
    'Naruto',
    'Mitsubishi',
    'Arigato',
    'God',
    'Get',
    'Cage'
);

$products = array(
'Ipad','Macbook','Coat','Trousers','Oishi','Fish','Chair','Cable','Solar Cell','Phone','Tag','Wallet','Coffee','Water','Ice','Fan','Pen','Pencil','Paper','Table','Board','Snack','Lipstick','Brush','Shoes','Earphone','Outlet','Rubic','Stereo','PC','Notebook');

$shops = array(
'Shop',
'Lazada',
'Rally',
'Smart',
'Thailand',
'America',
'Germany',
'Rubic',
'Goat',
'Simulator',
'Somsai',
'Samaii',
'Operation',
'Oishi',
'Overwatch',
'Apple',
'Orange',
'Strawberry',
'Tea',
'Unzip',
'Baggy',
'Ironman',
'Adidas',
'Nike');

$reviews = array(
'Good','Fast','Amazing','Bad services','Bad package','Very good','Excellent','That is the best ever','That is great','That is very much better','Good job','Cannot agree to take it','It is broken before I received it','Poorly','Badly','Not satisfied');

$storetypes = array('Personal','Bussiness');
$paymethods = array('Credit','Debit');

function random_username($string) {
$firstPart = strtolower($string);
$secondPart = substr(strtolower($string), 0,3);
$nrRand = rand(0, 100);

$username = trim($firstPart).trim($secondPart).trim($nrRand);
return $username;
}

function randomDateInRange($start, $end) {
$datestart = strtotime($start);//you can change it to your timestamp; Ex:
$dateend = strtotime($end);//you can change it to your timestamp; Ex:

$daystep = 86400;

$datebetween = abs(($dateend - $datestart) / $daystep);

$randomday = rand(0, $datebetween);

$date = $datestart + ($randomday * $daystep);
return date("d/m/Y", $date);
}
//End

$con=mysqli_connect("localhost","root","password","shoplada");
//Check Connection
if(mysqli_connect_errno())
{
	echo"Failed to connect to mySQL:".mysqli_connect_error();
}
$number = $_GET['number'];
$tb = $_GET['tb'];
if($tb == 'customer')
{
for($k=0;$k<$number;$k++)
	{
	$sql = "SELECT * FROM customer";
	$result = mysqli_query($con,$sql);
	$num = mysqli_num_rows($result);
	$j=0;

	do
		{
		$j++;
		$userid = "USER-".($num+$j);
		$sql = "SELECT userid FROM customer WHERE userid = '$userid'";
		$result = mysqli_query($con,$sql);
		}while(mysqli_num_rows($result) != 0);
	//Generate a random forename.
	$name = $names[mt_rand(0, sizeof($names) - 1)];
 	//Generate a random surname.
	$surname = $surnames[mt_rand(0, sizeof($surnames) - 1)];
	//Generate a random username
	$username = random_username($name.$surname);
	$mail = $username.'@somewhere.com';
	$date=randomDateInRange('1950-01-01', '2010-12-31');
	$phone = rand(1111111111,9999999999);
	$sql = "INSERT INTO `customer`(`UserID`, `Username`, `Password`, `FirstName`, `LastName`, `Mail`, `DOB`, `Phone`, `Picture`)
			VALUES('$userid','$username', '123456','$name','$surname','$mail', STR_TO_DATE('$date', '%d/%m/%Y'),'$phone','')";
	if(!mysqli_query($con,$sql))
	 	{
	 	die('Error:'. mysqli_error($con));
	 	}
	echo 'Success<br>';
	echo 'Name: '.$name.'  Surname:'.$surname;
	echo '<br>Username: '.$Username;
	echo '<br>Email: '.$mail;
	echo '<br>DOB: '.$date;
	echo '<br>Phone: '.$phone;
	echo '<br>================================<br>';
	}
}
else if($tb == 'shop')
{
for($k=0;$k<$number;$k++)
	{
	$sql = "SELECT * FROM shop";
	$result = mysqli_query($con,$sql);
	$num = mysqli_num_rows($result);
	$j=0;
	do
		{
		$j++;
		$shopid = "SHOP-".($num+$j);
		$sql = "SELECT shopid FROM shop WHERE shopid = '$shopid'";
		$result = mysqli_query($con,$sql);
		}while(mysqli_num_rows($result) != 0);
	$shop = $shops[mt_rand(0, sizeof($shops) - 1)].rand(1,99).$num;
	$address = rand(1,99)." Address".($num+$j);
	$province = "Province ".($num+$j);
	$district = "District ".($num+$j);
	$road = "Road ".($num+$j);
	$postcode = rand(10000,99999);
	$mail = $shop."@somewhere.com";
	$type = $storetypes[rand(0,1)];
	$phone = rand(1111111111,9999999999);
	$criteria = rand(0,1000);
	do
		{
		$sql = "SELECT * FROM customer";
		$result = mysqli_query($con,$sql);
		$count = mysqli_num_rows($result);
		$userid = "USER-".rand(1,$count);
		$sql = "SELECT userid FROM shop WHERE userid = '$userid'";
		$result = mysqli_query($con,$sql);
		}while(mysqli_num_rows($result) != 0);
	$sql = "INSERT INTO `shop`(`ShopID`, `ShopName`, `Address`, `Province`, `District`, `Road`, `Postcode`,  `Mail`, `StoreType`, `Phone`, `ShippingCriteria`, `UserID`)
			VALUES('$shopid','$shop', '$address','$province','$district','$road', '$postcode', '$mail','$type','$phone','$criteria','$userid')";
	if(!mysqli_query($con,$sql))
	 	{
	 	die('Error:'. mysqli_error($con));
	 	}
	echo 'Success<br>';
	echo 'Shop: '.$shop;
	echo '<br>Address: '.$Address.' '.$road.' '.$district.' '.$province.' '.$postcode;
	echo '<br>Email: '.$mail;
	echo '<br>type: '.$type;
	echo '<br>Criteria: '.$criteria;
	echo '<br>UserID:'.$userid;
	echo '<br>================================<br>';
	}
}
else if($tb == 'product')
{
for($k=0; $k<$number; $k++)
	{
	$sql = "SELECT * FROM product";
	$result = mysqli_query($con,$sql);
	$num = mysqli_num_rows($result);
	$j=0;
	do
		{
		$j++;
		$productid = "PD-".($num+$j);
		$sql = "SELECT productid FROM product WHERE productid = '$productid'";
		$result = mysqli_query($con,$sql);
		}while(mysqli_num_rows($result) != 0);
	$desc = "Describtion".($num+$j);
	$product = $shops[mt_rand(0, sizeof($shops) - 1)].' '.$products[mt_rand(0, sizeof($products) - 1)];
	$road = "Road ".($num+$j);
	$price = rand(100,999);
	do{
	$discount = rand(0,900);
	}while($discount>=$price);
	$stock = rand(0,999);
	$sizew = rand(1,50);
	$sizel = rand(1,50);
	$sizeh = rand(1,50);
	$weight = rand(1,20);
	$date = randomDateInRange('1950-01-01', '2010-12-31');
	$hour = rand(0,23);
	$minute = rand(0,59);
	$second = rand(0,59);
	$datetime = $date.' '.$hour.':'.$minute.':'.$second;
	$sql = "SELECT * FROM shop";
	$result = mysqli_query($con,$sql);
	$count = mysqli_num_rows($result);
	$shopid = "SHOP-".rand(1,$count);
	$subcat = "SCAT-".rand(10,80);
	$sql = "INSERT INTO `product`(`ProductID`, `Version`, `ProductName`, `Description`, `Price`, `Discount`, `Stock`, `SizeW`, `SizeL`, `SizeH`, `Weight`, `Timestamp`, `Flag`, `SubCategoryID`, `ShopID`)
			VALUES('$productid', '1', '$product', '$desc', '$price', '$discount', '$stock','$sizew','$sizel','$sizeh','$weight', STR_TO_DATE('$datetime', '%d/%m/%Y %H:%i:%s'),'1','$subcat', '$shopid')";
	if(!mysqli_query($con,$sql))
	 	{
	 	die('Error:'. mysqli_error($con));
	 	}
	echo 'Success<br>';
	echo 'Shop: '.$shopid;
	echo '<br>Product: '.$product;
	echo '<br>ProductID: '.$productid;
	echo '<br>Size(w l h): '.$sizew.' '.$sizel.' '.$sizeh;
	echo '<br>Weight: '.$weight;
	echo '<br>Date: '.$date;
	echo '<br>Subcat:'.$subcat;
	echo '<br>================================<br>';
	}
}
else if($tb == 'order')
{
for($k=0;$k<$number;$k++)
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
	do
	{
		$sql = "SELECT * FROM customer";
		$result = mysqli_query($con,$sql);
		$count = mysqli_num_rows($result);
		$userid = "USER-".rand(1,$count);
		$sql = "SELECT * FROM customer WHERE userid IN (SELECT userid FROM customerorder WHERE orderid IN (SELECT orderid FROM subcustomerorder WHERE status = '0'))";
		$result = mysqli_query($con,$sql);
		}while(mysqli_num_rows($result) != 0);
	$date = randomDateInRange('2015-01-01', '2019-12-31');
	$hour = rand(0,23);
	$minute = rand(0,59);
	$second = rand(0,59);
	$datetime = $date.' '.$hour.':'.$minute.':'.$second;
	$sql = "INSERT INTO `customerorder`(`OrderID`, `DateTime`, `UserID`)
			VALUES('$orderid', STR_TO_DATE('$datetime', '%d/%m/%Y %H:%i:%s'),'$userid')";
	if(!mysqli_query($con,$sql))
	 	{
	 	die('Error:'. mysqli_error($con));
	 	}
	echo 'Success<br>';
	echo 'Order: '.$orderid;
	echo '<br>Date '.$date;
	echo '<br>UserID: '.$userid;
	echo '<br>================================<br>';
	}
}
else if($tb == 'suborder1-3')
{
for($k=0;$k< $number;$k++)
	{
	$sql = "SELECT orderid FROM customerorder WHERE orderid NOT IN (SELECT orderid FROM subcustomerorder WHERE status=0) ORDER BY RAND() LIMIT 1";
	$result = mysqli_query($con,$sql);
	$data = mysqli_fetch_row($result);
	$orderid = $data[0];
	$sql = "SELECT * FROM subcustomerorder WHERE orderid = $orderid";
	$result = mysqli_query($con,$sql);
	$num = mysqli_num_rows($result);
	$j=0;
	do
 		{
 		$j++;
 		$suborderid = "S".$orderid."-".($num+$j);
 		$sql = "SELECT * FROM subcustomerorder WHERE suborderid = '$suborderid' AND orderid = '$orderid'";
 		$result = mysqli_query($con,$sql);
 		}while(mysqli_fetch_row($result));

 	do
 		{
 		$sql = "SELECT * FROM product";
		$result = mysqli_query($con,$sql);
		$count = mysqli_num_rows($result);
		$productid = "PD-".rand(1,$count);
		$sql = "SELECT * FROM subcustomerorder WHERE orderid = '$orderid' AND productid = '$productid'";
 		$result = mysqli_query($con,$sql);
 		}while(mysqli_num_rows($result) != 0);
	$amount = rand(1,20);
	$sql = "SELECT status FROM subcustomerorder WHERE orderid ='$orderid'";
	$result = mysqli_query($con,$sql);
	if($data = mysqli_fetch_row($result))
		{
		$status = $data[0];
		}
	else
		$status = rand(1,3);
	$date = randomDateInRange('2015-01-01', '2019-12-31');
	$hour = rand(0,23);
	$minute = rand(0,59);
	$second = rand(0,59);
	$datetime = $date.' '.$hour.':'.$minute.':'.$second;
	$sql = "INSERT INTO `subcustomerorder`(`SubOrderID`, `Amount`, `Status`, `StatusTime`, `ProductID`, `Version`, `OrderID`)
			VALUES('$suborderid', '$amount','$status',STR_TO_DATE('$datetime', '%d/%m/%Y %H:%i:%s'),'$productid','1','$orderid')";
	if(!mysqli_query($con,$sql))
	 	{
	 	die('Error:'. mysqli_error($con));
	 	}
	echo 'Success<br>';
	echo '<br>Order: '.$orderid;
	echo '<br>Suborder: '.$suborderid;
	echo '<br>Amount '.$amount;
	echo '<br>Status: '.$status;
	echo '<br>Date: '.$date;
	echo '<br>Product: '.$productid;
	echo '<br>================================<br>';
	}
}
/*else if($tb == 'suborder0')
{
for($k=0;$k<$number;$k++)
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

		$sql = "SELECT userid FROM customer WHERE userid IN (SELECT userid FROM customerorder WHERE orderid IN (SELECT orderid FROM subcustomerorder WHERE status != '0')) ORDER BY RAND() LIMIT 1";
		$result = mysqli_query($con,$sql);
		$data = mysqli_fetch_row($result);
		$userid = $data[0];
	$sql = "SELECT MAX(`DateTime`) FROM customerorder WHERE userid = '$userid'";
	$result = mysqli_query($con, $sql);
	if($data = mysqli_fetch_row($result))
		{
		$date = date_create($data[0]);
		$mindate = date_format($date, 'Y-m-d');
		$date = randomDateInRange($mindate, '2019-12-31');
		}
	else
		$date = randomDateInRange('2015-01-01', '2019-12-31');
	$hour = rand(0,23);
	$minute = rand(0,59);
	$second = rand(0,59);
	$datetime = $date.' '.$hour.':'.$minute.':'.$second;
	$sql = "INSERT INTO `customerorder`(`OrderID`, `DateTime`, `UserID`)
			VALUES('$orderid', STR_TO_DATE('$datetime', '%d/%m/%Y %H:%i:%s'),'$userid')";
	if(!mysqli_query($con,$sql))
	 	{
	 	die('Error:'. mysqli_error($con));
	 	}
	echo 'Success<br>';
	echo 'Order: '.$orderid;
	echo '<br>Date '.$date;
	echo '<br>UserID: '.$userid;
	echo '<br>================================<br>';
	$max = rand(0,10);
	for($l=0; $l < $max; $l++)
		{
		$sql = "SELECT * FROM subcustomerorder WHERE orderid = '$orderid'";
		$result = mysqli_query($con,$sql);
		$num = mysqli_num_rows($result);
		$j=0;
		do
 			{
 			$j++;
 			$suborderid = "S".$orderid."-".($num+$j);
 			$sql = "SELECT * FROM subcustomerorder WHERE suborderid = '$suborderid' AND orderid = '$orderid'";
 			$result = mysqli_query($con,$sql);
 			}while(mysqli_num_rows($result) != 0);
	
 		do
 			{
 			$sql = "SELECT * FROM product";
			$result = mysqli_query($con,$sql);
			$count = mysqli_num_rows($result);
			$productid = "PD-".rand(1,$count);
			$sql = "SELECT * FROM subcustomerorder WHERE orderid = '$orderid' AND productid = '$productid'";
 			$result = mysqli_query($con,$sql);
 			}while(mysqli_num_rows($result) != 0);
		$amount = rand(1,20);
		$sql = "SELECT status FROM subcustomerorder WHERE orderid ='$orderid'";
		$result = mysqli_query($con,$sql);
		$status = 0;

		$datesub = randomDateInRange($mindate, '2019-12-31');
		$hour = rand(0,23);
		$minute = rand(0,59);
		$second = rand(0,59);
		$datetimesub = $datesub.' '.$hour.':'.$minute.':'.$second;
		$sql = "INSERT INTO `subcustomerorder`(`SubOrderID`, `Amount`, `Status`, `StatusTime`, `ProductID`, `Version`, `OrderID`)
				VALUES('$suborderid', '$amount','$status',STR_TO_DATE('$datetimesub', '%d/%m/%Y %H:%i:%s'),'$productid','1','$orderid')";
		if(!mysqli_query($con,$sql))
		 	{
		 	die('Error:'. mysqli_error($con));
		 	}
		echo 'Success<br>';
		echo '<br>Order: '.$orderid;
		echo '<br>Suborder: '.$suborderid;
		echo '<br>Amount '.$amount;
		echo '<br>Status: '.$status;
		echo '<br>Date: '.$datesub;
		echo '<br>Product: '.$productid;
		echo '<br>================================<br>';
		}
	}
}*/
else if ($tb == 'review')
{
	for($k=0; $k<$number; $k++)
	{
	$sql = "SELECT * FROM review";
	$result = mysqli_query($con,$sql);
	$num = mysqli_num_rows($result);
	$j=0;
	do
 		{
 		$j++;
 		$reviewid = "RV-".($num+$j);
 		$sql = "SELECT * FROM review WHERE reviewid = '$reviewid'";
 		$result = mysqli_query($con,$sql);
 		}while(mysqli_num_rows($result) != 0);
 	
	$sql = "SELECT suborderid
	FROM subcustomerorder
	WHERE suborderid NOT IN (SELECT suborderid FROM review) AND status = 3
	ORDER BY RAND()
	LIMIT 1";
	$result = mysqli_query($con,$sql);
	$data = mysqli_fetch_row($result);
	$suborderid = $data[0];

  	$message = $reviews[mt_rand(0, sizeof($reviews) - 1)];
	$star = rand(1,5);
	$sql = "SELECT `StatusTime` FROM subcustomerorder WHERE suborderid = '$suborderid'";
	$result = mysqli_query($con, $sql);
	if($data = mysqli_fetch_row($result))
		{
		$date = date_create($data[0]);
		$mindate = date_format($date, 'Y-m-d');
		$date = randomDateInRange($mindate, '2019-12-31');
		}
	$hour = rand(0,23);
	$minute = rand(0,59);
	$second = rand(0,59);
	$datetime = $date.' '.$hour.':'.$minute.':'.$second;

	$sql = "INSERT INTO `review`(`ReviewID`, `Message`, `Star`, `DateTime`, `SubOrderID`)
			VALUES('$reviewid', '$message','$star', STR_TO_DATE('$datetime', '%d/%m/%Y %H:%i:%s'), '$suborderid')";
	if(!mysqli_query($con,$sql))
	 	{
	 	die('Error:'. mysqli_error($con));
	 	}
	echo 'Success<br>';
	echo '<br>Review: '.$reviewid;
	echo '<br>Star: '.$star;
	echo '<br>Message: '.$message;
	echo '<br>Date: '.$datetime;
	echo '<br>Suborder: '.$suborderid;
	echo '<br>================================<br>';
	}
}
else if ($tb == 'voucher')
{
	for($k=0; $k<$number; $k++)
	{
	$sql = "SELECT orderid FROM customerorder WHERE voucherid IS NULL ORDER BY RAND() LIMIT 1";
	$result = mysqli_query($con,$sql);
	$data = mysqli_fetch_row($result);
	$orderid = $data[0];
	$sql = "SELECT voucherid FROM voucher
	WHERE voucherid NOT IN (SELECT voucherid FROM customerorder WHERE voucherid IS NOT NULL) AND
	categoryid IN (SELECT categoryid
					FROM subcategory
					WHERE SubCategoryID IN (SELECT SubCategoryID
											FROM subcustomerorder
											WHERE orderid = 'OD-1'))
                                            ORDER BY RAND() LIMIT 1";
 	$result = mysqli_query($con,$sql);
	$data = mysqli_fetch_row($result);  
	$voucherid = $data[0];
	$sql = "UPDATE `customerorder` SET `VoucherID`='$voucherid' WHERE orderid = '$orderid'";
	if(!mysqli_query($con,$sql))
	 	{
	 	die('Error:'. mysqli_error($con));
	 	}
	echo 'Success<br>';
	echo '<br>Order: '.$orderid;
	echo '<br>Voucher: '.$voucherid;
	echo '<br>================================<br>';
	}
}
else if ($tb == 'paymethod')
{
	$sql = "SELECT orderid FROM customerorder WHERE paymethod IS NULL";
	$result = mysqli_query($con,$sql);
	while($data = mysqli_fetch_row($result))
	{
 	$address = rand(1,99)." Address".($num+$j);
	$province = "Province ".($num+$j);
	$district = "District ".($num+$j);
	$road = "Road ".($num+$j);
	$postcode = rand(10000,99999);
	$phone = rand(1111111111,9999999999);
	$paymentno = rand(1111111111111,9999999999999);
	$paymethod = $paymethods[rand(0,1)];
	$name = $names[mt_rand(0, sizeof($names) - 1)];
	$surname = $surnames[mt_rand(0, sizeof($surnames) - 1)];
	$payer = $name.' '.$surname;
	$creditno = rand(1111111111111,9999999999999);
	$sql = "UPDATE `customerorder` SET `Phone`='$phone',`Address`='$address',`PaymentNo`='$paymentno',`Paymethod`='$paymethod',`PayerName`='$payer',`Postcode`='$postcode', `CreditNo`='$creditno',`Province`='$province',`District`='$district',`Road`='$road' WHERE orderid = '$data[0]'";
	if(!mysqli_query($con,$sql))
	 	{
	 	die('Error:'. mysqli_error($con));
	 	}
	echo 'Success<br>';
	echo '<br>Order: '.$data[0];
	echo '<br>================================<br>';
	}
}
else if($tb == 'delorder')
{
	$sql = "SELECT orderid FROM customerorder WHERE orderid NOT IN (SELECT orderid FROM subcustomerorder)";
 	$result = mysqli_query($con, $sql);
 	while($data = mysqli_fetch_row($result))
 		{
 			$sqldel = "DELETE FROM `customerorder` WHERE orderid = '$data[0]'";
 			if(!mysqli_query($con,$sqldel))
	 			{
	 			die('Error:'. mysqli_error($con));
	 			}
	 		echo 'Delete'.$data[0].'<br>';
 		}
}
else
	{
	echo '<html><head></head><body>Create Data';
	echo '<form action="generatedata.php" method="GET">Number of row:<input name="number" type="text" required/><br>Table:
	<select name="tb" required>
	<option value="customer">Customer</option>
	<option value="shop">Shop</option>
	<option value="product">Product</option>
	<option value="order">Order</option>
	<option value="suborder1-3">Suborder Buy</option>
	<!-- <option value="suborder0">Suborder Cart</option> -->
	<option value="review">Review</option>
	<option value="voucher">Update Voucher</option>
	<option value="paymethod">Update Pay method</option>
	<option value="delorder">Delete Order</option>
	</select><br>
	<button class="btn" type="submit" name="action">Submit</button>
	</form></body>';
	}
?>