<?php
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