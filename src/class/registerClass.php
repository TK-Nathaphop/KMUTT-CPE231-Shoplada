<?php 
	class regisClass {

		public function getNewUserID(){
			try {
				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM customer");
				$stmt->execute();
				$count = $stmt->rowCount();
				return $count;
			} catch (Exception $e) {
				echo $e;
			}
		}

		public function getNewAddrID(){
			try {
				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM address");
				$stmt->execute();
				$count = $stmt->rowCount();
				return $count;
			} catch (Exception $e) {
				echo $e;
			}
		}

		public function getNewShopID(){
			try {
				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM shop");
				$stmt->execute();
				$count = $stmt->rowCount();
				return $count;
			} catch (Exception $e) {
				echo $e;
			}
		}

		public function getNewProductID(){
			try {
				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM product");
				$stmt->execute();
				$count = $stmt->rowCount();
				return $count;
			} catch (Exception $e) {
				echo $e;
			}
		}

		public function getNewReportID(){
			try {
				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM report");
				$stmt->execute();
				$count = $stmt->rowCount();
				return $count;
			} catch (Exception $e) {
				echo $e;
			}
		}

		public function registerData($userID,$username,$password,$fisrtN,$lastN,$mail,$DOB,$phone,$image){
			try {
				$db = getDB();
				$stmt = $db->prepare("INSERT INTO customer (UserID,UserName,Password,FirstName,LastName,Mail,DOB,Phone,Picture) VALUES ('$userID','$username','$password','$fisrtN','$lastN','$mail','$DOB','$phone','$image')");
				$send = $stmt->execute();
				if($send){
					return true;
				}else{
					return false;
				}
			} catch (Exception $e) {
				echo $e;
			}
		}

		public function registerAddress($addr,$province,$road,$district,$postcode,$phone,$userID,$addrID){
			try {
				$db = getDB();
				$stmt = $db->prepare("INSERT INTO address (AddressID,Phone,Address,Province,District,Road,Postcode,UserID) 
					VALUES ('$addrID','$phone','$addr','$province','$district','$road','$postcode','$userID')");
				$send = $stmt->execute();
				if($send){
					return true;
				}else{
					return false;
				}
				
			} catch (Exception $e) {
				echo  $e;
			}
		}

		public function registerProduct($ProductID,$version,$shopname,$address,$province,$district,$road,$postcode,$picture,$URL,$mail,$facebook,$storetype,$phone,$ShippingCriteria,$userID){
			try {
				$db = getDB();
				$stmt = $db->prepare("INSERT INTO shop (ProductID, ShopName, Address, Province, District, Road, Postcode, Picture, URL, Mail, Facebook, StoreType, Phone, ShippingCriteria, UserID) VALUES ('$ProductID','$shopname','$address','$province','$district','$road','$postcode','$picture','$URL','$mail','$facebook','$storetype','$phone','$ShippingCriteria','$userID')");
				$send = $stmt->execute();
				if($send){
					return true;
				}else{
					return false;
				}
			} catch (Exception $e) {
				echo $e;
			}
		}

		public function registerShop($shopID,$shopname,$address,$province,$district,$road,$postcode,$picture,$URL,$mail,$facebook,$storetype,$phone,$ShippingCriteria,$userID){
			try {
				$db = getDB();
				$stmt = $db->prepare("INSERT INTO shop (ShopID, ShopName, Address, Province, District, Road, Postcode, Picture, URL, Mail, Facebook, StoreType, Phone, ShippingCriteria, UserID) VALUES ('$shopID','$shopname','$address','$province','$district','$road','$postcode','$picture','$URL','$mail','$facebook','$storetype','$phone','$ShippingCriteria','$userID')");
				$send = $stmt->execute();
				if($send){
					return true;
				}else{
					return false;
				}
			} catch (Exception $e) {
				echo $e;
			}
		}

		public function registerReport($ReportID,$Topic,$Message,$DateTime,$Response,$UserID){
			try {
				$db = getDB();
				$dateTime = date("Y-m-d H:i:s");
				$stmt = $db->prepare("INSERT INTO report (ReportID, Topic, Message, DateTime, Response, UserID) VALUES ('$ReportID','$Topic','$Message',STR_TO_DATE('$dateTime','%Y-%m-%d %H:%i:%s'),'$Response','$UserID')");
				$send = $stmt->execute();
				if($send){
					return true;
				}else{
					return false;
				}
			} catch (Exception $e) {
				echo $e;
			}
		}

	}

?>