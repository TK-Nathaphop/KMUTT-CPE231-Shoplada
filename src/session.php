<?php
	require_once ('auth/auth.database.php');
    require_once ('class/loginClass.php');
	class session{

		public function insession(){
			try{
				if(!isset($_SESSION["user"]) || $_SESSION["user"] == "" || (strlen($_SESSION["user"]) == 0)){ //not in session
					return 0;
				}
				else{
					return 1;
				}
			} catch (Exception $e) {
			}
		}
	}
?>