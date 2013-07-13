<?php
if($_GET['from'] != 'home'){
	require '../errordocs/404.html';
	die();
}		 
	//got here legitimately, continue with login script

	require "./password_compat-master/lib/password.php";
	require '../TimeClock/php/connect.php';

	define(UDBNAME, "users");
	//local
	//$conn = init_connection_and_table(LHOST, USER, LPASS, LDBNAME, UDBNAME);
	//remote
	$conn = init_connection_and_table(RHOST, USER, RPASS, RDBNAME, UDBNAME);
		 
	session_start();
	$password = $_POST['password'];

	$toURL;

	if(verify_login("hrjl", $password, $conn)){
		$_SESSION['auth'] = true;
		$toURL = "../TimeClock/";
	} else {
		$toURL = "../index.php?status=wrongpass";
	}
	header("Location: " . $toURL);
	die;

  
	function verify_login($user, $password, $conn){
		 $sql = "SELECT password from " . UDBNAME . " WHERE user='" . $user . "'";
//		 echo $sql;
		 $result = mysqli_query($conn, $sql);
		 if($result){
			$record = mysqli_fetch_assoc($result);
                        if(count($record)==0){
                                echo "User not found.<br>";
                        } else {
                                $hash = $record['password'];
                                return password_verify($password, $hash);
                        }
		 } else {
		   	echo "Failed to authenticate.<br>";
		 }
		 //return $password == "pass";
	}
?>