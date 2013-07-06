<?php

	require "filter.php";

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	echo getInvoice($conn, $_GET);

	function getInvoice($conn, $get){
		$result = getRows($conn, $get, TRUE);		
		
		return getTable($result, TRUE);
	}
?>