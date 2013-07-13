<?php
	if($_GET['from'] != 'home'){
		require '../errordocs/404.html';
		die();					 
	}
	session_start();

	$_SESSION['auth'] = false;

	header("Location: ../index.php?status=loggedout");
	die;
?>