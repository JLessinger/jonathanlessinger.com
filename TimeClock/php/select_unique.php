<?php
	require 'connect.php';

	echo getHTML($_GET, $conn);
//	echo 
	function getHTML($get, $conn){
		
		$field = $get['field'];
		$html = "";

		$sql = "SELECT DISTINCT " . $field . " FROM " . TABLENAME;
	//	$html = "<option value='bleh'>" . $field . "</option>";
		$result = mysqli_query($conn, $sql);
			if($result){
				while($row = mysqli_fetch_assoc($result)){
					$html .= "<option value='" . $row[$field] . "'>" . $row[$field] . "</option>";
				}
				$html .= "<option value='new' selected='selected'>new</option>";
			} else {
				$html = "<option value='failed'>Failed to get accounts</option>";
			}
		return $html;
	}
?>