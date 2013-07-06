<?php

	require 'connect.php';

	error_reporting(E_ALL);
	ini_set('display_errors',1);


	enter_form($_POST, $conn);
	echo "<a href=\"../index.html\">Back</a>";

	function verify($post){
		$errors = "";
		$hasName = false;
		$hasJob = false;
		foreach($post as $key => $val){

			if(empty($val)){
				$errors .= "Empty field: " . $key . "<br>";
			}
			if($key=='name'){
				$hasName = true;
			}
			if($key=='job'){
				$hasJob = true;
			}
		//	echo $key . "=" . $val . "<br>";
		}
		if(!$hasName){
			$errors .= "Empty field: name<br>";
		}
		if(!$hasJob){
			$errors .= "Empty field: job<br>";
		}
		if($post["rate"] < 0){
			$errors .= "Rate must be positive<br>";
		}
		return $errors;
	}

	function enter_form($post, $conn){
		global $tablename, $fields;
		$msg = verify($post);
		if(empty($msg)){
			//enter into table in order
			$sql = "INSERT INTO " . $tablename . $fields . "(";
			foreach($post as $key => $val){
				//skip hours key. add to minutes key, and include sql for minutes
				$hours;
				if($key == "hours"){
					$hours = $val;
				} else {
					//not hours, add the sql for this kid
					if($key == "minutes"){
						//special case - minutes
						$val = 60 * $hours + $val;	
					}
					$sql .= "'" . $val . "'";
					$sql .= ", ";
				}
			}

			$sql .= "FALSE)";
		//	echo $sql;
			
			$result = mysqli_query($conn, $sql);
			if($result){
				echo "Added.<br>";
			} else {
				echo "Failed<br>.";
			}
		} else {
			echo "ERRORS: <br>" . $msg;
		}
	}



?>
