<?php
ob_start();		
session_start();
//echo "auth: " . $_SESSION['auth'];
if(!$_SESSION['auth']){
	header("Location: ../index.php");
	die();
}
	//	error_reporting(E_ALL);
	//	ini_set('display_errors',1);

	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	</head>
	<body>		
		<script type="text/javascript">
			window.viewed = false;
		</script>
		<script type="text/javascript" src="./js/jquery-1.10.1.js"></script>
		<script type="text/javascript" src="./js/paid_toggle_ajax.js"></script>
		<script type="text/javascript" src="./js/event_handlers.js"></script>
		<script type="text/javascript" src="./js/form_validation.js"></script>
		
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<form action="../php/logout.php?from=home" method="POST">
			<input type="submit" value="log out">
		</form>
		<div id="updateSection">
			<h1>Enter Time Slot</h1>
			<form name="EnterForm" id="EnterForm" action="./php/enter.php" method="post" onsubmit="return(validForm(this.id))">
				<ul>
					<li>Name: </br>
						Jonathan<input type="radio" name="Name" value="Jonathan">
						Heath<input type="radio" name="Name" value="Heath"></li>
					<li>Time: <input id="hrs" type="number" name="hours">:<input id="mins" type="number" name="minutes"></li>
					<!--li>Account: <input type="text" name="Account"></li-->
					<li>Account:<select id="accountInput" name="Account"></select>
						<div id="newAccount"></div></li>
					<li>Hourly Rate: $<input type="number" name="HourlyRate"></li>
					<li>Date: <input type="date" name="Date"></li>
					<li>Job Type: </br> 
						Web<input type="radio" name="JobType" value="Web">
						Video<input type="radio" name="JobType" value="Video">
						Audio<input type="radio" name="JobType" value="Audio">
					</li>
					<li><input type="submit" value="Submit"></li>
				</ul>
			</form>
			<h1>Delete Time Slot</h1>
				<form action="./php/delete.php" method="post">
				<ul>
					<li>ID: <input type="number" name="id"></li>
				</ul>
				<li><input type="submit" value="Delete"></li>
				</form>
			<h1>Toggle Slot Paid</h1>
			<h2>Default = unpaid</h2>
				<form action="./php/toggle_paid.php" method="post">
				<ul>
					<li>ID: <input type="number" name="id" onkeyup="confirmToggle(this.value)"></li>
					<span id="usermessage"></span>
				</ul>
				<li><input type="submit" value="Update"></li>
			</form>
		</div>
		<div id="viewSection">
			<h1>View Entries</h1>
			<h2>Fill out any fields to filter results</h2>
			<form id="viewForm" action="">
				<ul>
					<li>ID: <input type="number" name="id"></li>
					<li>Name: </br> 
						Jonathan<input type="radio" name="Name" value="Jonathan">
						Heath<input type="radio" name="Name" value="Heath"></li>
					<li>Start Date: <input type="date" name="startdate">yyyy-mm-dd</li>
					<li>End Date: <input type="date" name="enddate">yyyy-mm-dd</li>
					<li>Min Time: <input type="number" name="minhours">:<input type="number" name="minminutes"></li>
					<li>Max Time: <input type="number" name="maxhours">:<input type="number" name="maxminutes"></li>
					<li>Account: <input type="text" name="Account"></li>
					<li>Hourly Rate: $<input type="number" name="HourlyRate"></li>
					<li>Job Type: </br> 
						Web<input type="radio" name="JobType" value="Web">
						Video<input type="radio" name="JobType" value="Video">
						Audio<input type="radio" name="JobType" value="Audio">
					</li>
					<li>Paid?</br>
						Yes<input type="radio" name="IsPaid" id="paidradio" value="1">
						No<input type="radio" name="IsPaid" value="0">
					</li>
					<li><input class="viewbutton" type="submit" value="View"></li>
					<li><input class="invoicebutton" type="submit" value="Invoice"></li>
				</ul>
			</form>
			<div id="invoiceResponse"></div>
		</div>
		<div id="view"></div>
	</body>
</html>