<?php

	require 'connect.php';

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	delete_entry($_POST, $conn);
	echo "<a href=\"../\">Back</a>";


	function verify($post){
		$errors = "";
		if(empty($post['id'])){
			$errors .= "No id entered<br>";
		} else if(!exists($post)){
			$errors .= "ID not found<br>";
		}
		return $errors;
	}

	function exists($post){
		global $conn;
		$sql = "SELECT * FROM " . TABLENAME . 
		" WHERE  id='" . $post['id'] . "'"; 
		$res = mysqli_query($conn, $sql);
		$record = mysqli_fetch_assoc($res);
		if(count($record)==0){
			return false;
		} else {
			return true;
		}	
	}

	function delete_entry($post, $conn){
		global $fields;
		$msg = verify($post);
		//id is found
	
		if(empty($msg)){

			$sql = "DELETE FROM " . TABLENAME .
			" WHERE id='" . $post['id'] . "'"; 
			//echo $sql;
			$result = mysqli_query($conn, $sql);
			if($result){
				echo "Updated<br>";
			} else {
				echo "Failed<br>";
			}
		} else {
			echo "ERRORS: <br>" . $msg;
		}
		
	}
	
?>