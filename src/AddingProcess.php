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
            require_once ('auth/auth.database.php');
      require_once ('auth/session.php');
      require_once ('class/getUserClass.php');
      require_once ('class/registerClass.php');
      require_once ('class/updateClass.php');
      $updateClass = new updateUser();
      $userClass = new getUserClass();
      $session = new session();
      if ($session->insession()) {
        $userData = $userClass->getUserData($_SESSION['user']);
        $shopData = $userClass->getShopData($_SESSION['user']);
        $UShopID = $shopData->ShopID;
      }
      else{
        header("location: login.php");
      }
        $Product = mysqli_real_escape_string($con,$_POST['Name']);
        $Price = mysqli_real_escape_string($con,$_POST['price']);
        $Describe = mysqli_real_escape_string($con,$_POST['describe']);
        $Picture = mysqli_real_escape_string($con,$_POST['picPath']);
        $Stock = mysqli_real_escape_string($con,$_POST['stock']);
        $SizeW = mysqli_real_escape_string($con,$_POST['SizeW']);
        $SizeL = mysqli_real_escape_string($con,$_POST['SizeL']);
        $SizeH = mysqli_real_escape_string(  $con,$_POST['SizeH']);
        $Weight = mysqli_real_escape_string($con,$_POST['Weight']);
        $Discount = mysqli_real_escape_string($con,$_POST['discount']);
        $SubCategory = mysqli_real_escape_string($con,$_POST['scat']);
        if(!$Picture)
            {
                $Picture ='NULL';
            }
        $date = new DateTime();
        $realDate =  $date->getTimestamp();
        echo $realDate;
        $sqlGet = "SELECT Max(productid) FROM product";
        $result = mysqli_query($con,$sqlGet); 
        $num = mysqli_num_rows($result);
        $j=0;
        
        do
        {
            $j++;
            $productid = "PD-".($num+$j);
            $sqlGet = "SELECT productID FROM product WHERE productID = '$productid'";
            $result = mysqli_query($con,$sqlGet);
        }while(mysqli_num_rows($result) != 0);
        
        $sql = "INSERT INTO `product`(`ProductID`, `Version`, `ProductName`, `Description`, `Price`, `Discount`, `Picture`, `Stock`, `SizeW`, `SizeL`, `SizeH`, `Weight`, `Timestamp`, `Flag`, `SubCategoryID`, `ShopID`)
        VALUES ('$productid','1','$Product','$Describe','$Price','$Discount','$Picture','$Stock','$SizeW','$SizeL','$SizeH','$Weight',NOW(),'1','$SubCategory','$UShopID')" ;

        // $result = mysqli_query($con,$sql);
        if(mysqli_query($con, $sql)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
        }

    }
    echo "<script>location = 'http://e22vvb.asuscomm.com:43221/ShopManagement.php'</script>";
?>