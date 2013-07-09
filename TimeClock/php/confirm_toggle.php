<?php

	require 'connect.php';

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	validateUser($_GET, $conn);

	function validateUser($get, $conn){
		$sql = "SELECT IsPaid FROM " . TABLENAME . " 
		WHERE  id='" . $get['id'] . "'"; 
		$res = mysqli_query($conn, $sql);
		if($res){
			$record = mysqli_fetch_assoc($res);
			if(count($record)==0){
				echo "ID not found";
			} else {
				$ispaid = $record['IsPaid'];
				if($ispaid){
					echo "Record is paid. Toggle off?";
				} else {
					//do nothing
				}
			}
		} else {
			echo "Query failed.<br>";
		}
		
	} 
?>