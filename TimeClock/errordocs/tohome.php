<?php
ob_start();
session_start();
if($_SESSION['auth']){
	require("../../errordocs/404.html");
} else {
       header("Location: ../../");
}
?>