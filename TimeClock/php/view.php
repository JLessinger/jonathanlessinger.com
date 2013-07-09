<?php

	require "filter.php";

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	echo getView($conn, $_GET);


	function getView($conn, $get){

		$result = getRows($conn, $get, FALSE);

		return getTable($result, FALSE);
	}

?>