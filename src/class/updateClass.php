<?php
	class updateUser{

		public function updateUserData($userID,$username,$password,$fisrtN,$lastN,$mail,$DOB,$phone,$image){
			try {
				$db = getDB();
				$stmt = $db->prepare("UPDATE customer SET Username = '$username', Password = '$password',FirstName = '$fisrtN',LastName = '$lastN',Mail = '$mail',DOB = '$DOB',Phone = '$phone',Picture = '$image' where UserID = '$userID'");
				$send = $stmt->execute();
				if($send){
					return true;
				}else{
					return false;
				}
			} catch (Exception $e) {

			}
		}

		public function updateShopData($shopID,$shopname,$address,$province,$district,$road,$postcode,$picture,$URL,$mail,$facebook,$storetype,$phone,$ShippingCriteria,$userID){
			try {
				$db = getDB();
				$stmt = $db->prepare("UPDATE shop SET ShopName = '$shopname', Address = '$address', Province = '$province', District = '$district',Road = '$road',Postcode = '$postcode',Picture = '$picture' ,URL = '$URL',Mail = '$mail', Facebook = '$facebook',StoreType = '$storetype',Phone = '$phone', ShippingCriteria = '$ShippingCriteria' where ShopID = '$shopID'");
				$send = $stmt->execute();
				if($send){
					return true;
				}else{
					return false;
				}
			} catch (Exception $e) {

			}
		}
	}
?>