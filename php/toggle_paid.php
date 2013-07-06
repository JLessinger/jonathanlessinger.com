<?php

	require 'connect.php';

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	update_paid($_POST, $conn);
	echo "<a href=\"../index.html\">Back</a>";


	function verify($post){
		$errors = "";
		if(empty($post['id'])){
			$errors .= "No id<br>";
		}
		return $errors;
	}

	function update_paid($post, $conn){
		global $tablename, $fields;
		$msg = verify($post);
		if(empty($msg)){
			//toggle paid by id

			$sql = "UPDATE " . $tablename . " SET isPaid = !isPaid 
			WHERE id='" . $post['id'] . "'"; 
			//echo $sql;
			$result = mysqli_query($conn, $sql);
			if($result){
				echo "Updated.<br>";
			} else {
				echo "Failed<br>";
			}
		} else {
			echo "ERRORS: <br>" . $msg;
		}
	}
?>
