<?php			
	
	define(LDBNAME, "db1");
	define(RDBNAME, "timeslotdb");
	define(TABLENAME, "Timeslots");
	define(USER, "jlessinger");
	define(LPASS, "pass");
	define(RPASS, "m0NeYdb");
	define(LHOST, "localhost");
	define(RHOST, "mysql.jonathanlessinger.com");
	
	//AmountTime = minutes
	//$fields = " (Name, Date, AmountTime, Account, HourlyRate, JobType, IsPaid) VALUES ";

	//local
	$conn = init_connection_and_table(LHOST, USER, LPASS, LDBNAME, TABLENAME);
	//remote
	//$conn = init_connection_and_table(RHOST, USER, RPASS, RDBNAME, TABLENAME);

	function init_connection_and_table($host, $user, $pass, $dbname, $tablename){
		$conn = mysqli_connect($host, $user, $pass);

		if($conn){
		//	echo "connected successfully as jlessinger<br>";

		} else {
			die("Could not connect: " . mysqli_connect_error());
		}

		//if exists, will not create
		if(mysqli_select_db($conn, $dbname)){
		//	echo "database exists, not creating.<br>";
		} else {
			$sql = "CREATE DATABASE " . $dbname;
			mysqli_query($conn, $sql);
		//	echo "creating database.<br>";
		}

		$conn = mysqli_connect($host, $user, $pass, $dbname);
		
		if($conn){
		//	echo "connected successfully to db1<br>";
		//	$user = mysqli_query($conn, "SELECT CURRENT_USER()");
		//	print_r(mysqli_fetch_assoc($user));
		} else {
			die("Could not connect: " . mysqli_connect_error());
		}

		$sql = "SELECT 1 FROM " . $tablename;
		if(mysqli_query($conn, $sql)){
			//table exists
		//	echo "table exists<br>";
		} else {
			//create table
		//	echo "creating table<br>";
			$sql = "CREATE TABLE " . $tablename . 
			"(id INT NOT NULL AUTO_INCREMENT,
			Name CHAR(32),
			AmountTime INT,
			Account CHAR(64),
			HourlyRate FLOAT(6, 2),
			Date DATE,
			JobType CHAR(32),
			IsPaid BOOL,
			PRIMARY KEY (id))";
		//	echo $sql;
			$result = mysqli_query($conn, $sql);
			if($result){
			//	echo "successfully created table<br>";
			} else {
			//	echo "failed to create table<br>";
			}
		}

		$sql = "SHOW TABLES";
		$result = mysqli_query($conn, $sql);
	//	echo "tables:<br>";
		while($row = mysqli_fetch_array($result)){
	//		echo "Table: " .$row[0]."<br>";
		}
		return $conn; 
	}
?>
