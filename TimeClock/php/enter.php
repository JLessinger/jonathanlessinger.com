<?php

	require 'connect.php';

	error_reporting(E_ALL);
	ini_set('display_errors',1);


	enter_form($_POST, $conn);
	echo "<a href=\"../\">Back</a>";

	function verify($post){
		$errors = "";
		$hasName = false;
		$hasJob = false;

		//special case for hours/minutes (see form_validation.js)
		$timefilled = false;
		foreach($post as $key => $val){

		//	echo $key . " " . $val;
			//empty field
			if(strlen($val)==0){
				if($key!="hours" && $key!="minutes"){
					//add to errors if empty and NOT (hours or minutes)
					$errors .= "Empty field: " . $key . "<br>";

				} else {
					//empty and (hours or minutes)
					//don't know yet, save that for end
				}
			} else {
				//value filled
				if($key=="hours" || $key=="minutes"){
					$timefilled = true;
				} else {
					//filled and not (hours or minutes)
					//good; leave alone
				}

			}

			if($key=='Name'){
				$hasName = true;
			}
			if($key=='JobType'){
				$hasJob = true;
			}
		//	echo $key . "=" . $val . "<br>";
		}

		if(!$timefilled){
			$errors .= "Empty field: hours<br>";
			$errors .= "Empty field: minutes<br>"; 
		}

		if(!$hasName){
			$errors .= "Empty field: name<br>";
		}
		if(!$hasJob){
			$errors .= "Empty field: job<br>";
		}
		if($post["HourlyRate"] < 0){
			$errors .= "Rate must be positive<br>";
		}
		return $errors;
	}

	function enter_form($post, $conn){
		global $tablename, $fields;
		$msg = verify($post);
		if(empty($msg)){

			$sql = "INSERT INTO " . TABLENAME;
			$fields = " (";
			$values = " VALUES (";
			foreach($post as $key => $val){
			//	echo "<br>key: " . $key . " val: " . $val; 
				//skip hours key. add to minutes key, and include sql for minutes
				$hours;
				if($key == "hours"){
					$hours = $val;
				} else {
					//not hours, add the sql for this kid
					if($key == "minutes"){
						//special case - minutes
						$key = "AmountTime";
						$val = 60 * $hours + $val;	
					}
					$fields .= $key . ", ";
					$values .= "'" . $val . "', ";

				}
			}
			//add on last field not from POST
			$fields .= "IsPaid)";
			$values .= "'FALSE')";
			$sql .= $fields . $values;

			//echo $sql;
			
			$result = mysqli_query($conn, $sql);
			if($result){
				echo "Added.<br>";
			} else {
				echo "Failed.<br>";
			}
		} else {
			echo "ERRORS: <br>" . $msg;
		}
	}



?>
