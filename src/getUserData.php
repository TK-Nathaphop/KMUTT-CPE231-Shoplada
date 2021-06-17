<?php 
	require_once ('auth/auth.database.php');
	require_once ('class/getUserClass.php');

	$userClass = new getUserClass();
	$data = $userClass->getUserData("USER-1");

	$address = $userClass->getAddress("USER-1");

	echo "username -> ".$data->UserName."<br>";
	echo "password -> ".$data->Password."<br>";

	echo "province -> ".$address->Address;
?>