<?php
if($_GET['from'] != 'home'){
	header("Location: ../errordocs/404.html");
	die();
}		 
	session_start();
	$password = $_POST['password'];

	$toURL;

	if(verify_login($password)){
		$_SESSION['auth'] = true;
		$toURL = "../TimeClock/";
	} else {
		$toURL = "../index.php?status=wrongpass";
	}
	header("Location: " . $toURL);
	die;

	function verify_login($password){
		return $password == "pass";
	}
?>