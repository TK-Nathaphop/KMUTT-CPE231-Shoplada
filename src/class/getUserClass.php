<?php 
	class getUserClass{

		public function fetchMe($table){
			try {
				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM $table");
				$stmt->execute();
				$data = $stmt->fetchAll();
				return $data;
			} catch (Exception $e) {
				
			}
		}

		public function getUserAll(){
			try {
				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM customer");
				$stmt->execute();
				$data = $stmt->fetchAll();
				return $data;
			} catch (Exception $e) {
				echo $e;
			}
		}

		public function getUserData($userid){
			try {
				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM customer WHERE UserID='$userid'");
				$stmt->execute();
				$data = $stmt->fetch(PDO::FETCH_OBJ);
				return $data;
			} catch (Exception $e) {
				echo $e;
			}
		}

		public function getShopData($userid){
			try {
				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM shop WHERE UserID = '$userid'");
				$stmt->execute();
				$data = $stmt->fetch(PDO::FETCH_OBJ);
				return $data;
			} catch (Exception $e) {
				echo $e;
			}
		}

		public function getNewProductID($productid){
			try {
				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM product WHERE ProducID = '$productid'");
				$stmt->execute();
				$count = $stmt->rowCount();
				return $count;
			} catch (Exception $e) {
				echo $e;
			}
		}

		public function getAddress($userid){
			try {
				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM address WHERE UserID = '$userid'");
				$stmt->execute();
				$data = $stmt->fetch(PDO::FETCH_OBJ);
				return $data;
			} catch (Exception $e) {
				echo $e;
			}
		}
		
		public function getAddressall($userid){
			try {
				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM address WHERE UserID = '$userid'");
				$stmt->execute();
				$data = $stmt->fetchAll();
				return $data;
			} catch (Exception $e) {
				echo $e;
			}
		}
	}
?>