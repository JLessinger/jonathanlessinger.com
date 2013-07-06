<?php

	require "connect.php";

	error_reporting(E_ALL);
	ini_set('display_errors',1);


	function getRows($conn, $get, $isInvoice){
		global $tablename;
		$sql = getFilters($conn, $get, $isInvoice);
		
		//echo $sql;
		$res = mysqli_query($conn, $sql);
		
		return $res;
	}

	//returns sql for filters
	//ranges are NOT filters
	function getFilters($conn, $get, $isInvoice){
		global $tablename;
		$sql = "SELECT * FROM " . $tablename . 
		" WHERE ";

		$filters = 0;

	//	echo "vals: #" . strlen($get['minhours']) . " " . strlen($get['minminutes']) . " " . strlen($get['maxhours']) . " " . strlen($get['maxminutes']) . "#";
		if((strlen($get['minminutes']) > 0) || (strlen($get['minhours']) > 0)){
			$get['mintime'] = $get['minminutes'] + 60 * $get['minhours'];
			unset($get['minhours']);
			unset($get['minminutes']);

		}
		if((strlen($get['maxminutes']) > 0) || (strlen($get['maxhours']) > 0)){
			$get['maxtime'] = $get['maxminutes'] + 60 * $get['maxhours'];			
			unset($get['maxhours']);
			unset($get['maxminutes']);
		}

		foreach($get as $key => $val){
			//cannot use empty, must use string length
			//empty(0) -> true, so IsPaid = false would be ignored
			if(strlen($val)>0){
			//	echo "key/val: " . $key . "/" . $val .  "<br>";
				$operator;
				
				if($key == "mintime"){
					$key = "AmountTime";
					$operator = ">='";
				} else if ($key == "maxtime"){
					$key = "AmountTime";
					$operator = "<='";
				} else if ($key == "startdate") {
					$key = "Date";
					$operator = ">='";
				} else if ($key == "enddate"){
					$key = "Date";
					$operator = ">='";
				} else {  
					$operator = "='";
				}
					$sql .= $key . $operator . $val . "' AND ";
					$filters++;
			}
			if($isInvoice){
				//only return not yet paid entries
				//include the trailing AND for consistency
				$sql .= "IsPaid='0' AND "; 
			}
		}
		if($filters==0){
			//special case = no filters, get all
			$sql = "SELECT * FROM " . $tablename; 
		} else {
			//otherwise, remove the trailing "and"
			$sql = substr($sql, 0, strlen($sql)-5);

		}
		return $sql;
	}	
	function getTable($result, $isInvoice){
		$out = "";
		$out .= "<table border='1'>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Time Worked</th>
				<th>Account</th>
				<th>Rate</th>
				<th>Date</th>
				<th>Job</th>
				<th>Paid?</th>
			</tr>";
		if($result){
			
			$rows = 0;
			$time = 0;
			$owed = 0;

			while($row = mysqli_fetch_assoc($result)){
				$out .= "<tr>";
				$rowTime = 0;
				$rowRate = 0;
				foreach($row as $key => $val){
					if($key=="AmountTime"){
						$rowTime = $val;
						$val = minutes_to_time($val);
					}
					if($key=="HourlyRate"){
						$rowRate = $val;
						$val = "$" . $val;
					}
					if($key=="IsPaid"){
						if($val==0){
							$val = "no";
						} else {
							$val = "yes";
						}
					}
					$out .= "<td>" . $val . "</td>";
				}

				$out .= "</tr>";

				$time += $rowTime;
				$owed += $rowTime * $rowRate / 60; 
				$rows++;

			}
			$out .= "</table></br>";
			if($isInvoice){
				$out .= "Total time: " . minutes_to_time($time) . "</br>";
				$out .= "Amount owed: $" . round($owed, 2);
			}
			if($rows==0){
				$out = "No matching entries";
			}

		} else {
			$out = "Query failed";
		}
		return $out;
	}

	function minutes_to_time($minutes){
		$hours = floor($minutes/60);
		$minutes = $minutes % 60;

	//	echo $minutes . " " . strlen($minutes);
		if(strlen($minutes % 60)==1){
			$minutes = "0" . $minutes;
		//	echo $minutes;
		}

		$time = $hours . ":" . $minutes;

		return $time ;
	}
?>