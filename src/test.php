<?php 
	if(!empty($_POST['submit_button'])){
		echo $_POST['username'];
	}
?>
<form method="POST" action="">
	<input type="text" name="username">
	<input type="submit" name="submit_button">
</form>