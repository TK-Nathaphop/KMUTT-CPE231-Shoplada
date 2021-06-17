<?php 
	class loginClass{
		public function userLogin($user,$pwd){
			try{

				$db = getDB();
				$stmt = $db->prepare("SELECT * FROM customer WHERE UserName='$user' AND Password='$pwd'");//stmt = statement
				$stmt->execute();
				$count=$stmt->rowCount();
				$data=$stmt->fetch(PDO::FETCH_OBJ);
				$db = null;
					if($count == 1){
						$_SESSION["user"] = $data->UserID;
						return 1;						
					}else{
						return 0;
					}
			}
			catch(PDOException $e) {
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}

		}
	}
?>