<?php
   ob_start();
   session_start();
   if($_SESSION['auth']){
        header("Location: ./TimeClock");
   }
   if($_GET['status'] == 'loggedout'){
       echo "Logged out";
   }
?>
<!DOCTYPE html>
<html>
<head>
    <!--meta http-equiv="refresh" content="0; url=./TimeClock/"-->
</head>
<body>
    <form action='./php/login.php?from=home' method='POST'>
    Password:<input name='password' type='password'>
    <?php 
        if($_GET['status'] == "wrongpass"){
            echo "Incorrect password";
        }
    ?>
    <br>
    <input type='submit' value='Log in'>
    </form>
</body>
</html>
<!--?php

require 'password_compat-master/lib/password.php';
// index.php
define('RUNNING_APP', true);
// 1. place your auth code here, or...
define('PWFILE', "./pw/pw.txt");

function verifyPW($pw){
	$pwfile = fopen(PWFILE, 'r');
	$line = fgets($pwfile);
	fclose(PWFILE);

	//echo "about to hash";
    $lineLessNewLine = trim($line);  
 //   echo "line: '" . $line . "'<br>";
  //  echo "pw: '" . $pw . "'<br>";
    $hash = password_hash($pw, PASSWORD_BCRYPT, array("cost" => 10));
   // echo "hash: '" . $hash . "'";
	return password_verify($pw, $line);
}

$msg = "";
$logged_in;

switch ($_REQUEST['page']) {
    case 'timeclock':
        // 2. or here
    	if(verifyPW($_REQUEST['password'])){
        	include 'TimeClock/index.php';
            $logged_in = true;
    	} else {
    		$msg = "Password incorrect.";
            $logged_in = false;
    	}
    	//echo "tc";
        break;
  /*
    case 'do_register':
        // 2. and here, and before every include.. and so forth.
        include 'inc/do_register.php';
        break;
     */
    default:
    	//echo "bleh";
    	break;
}
// make sure to break direct access
  defined('RUNNING_APP') or die('Cannot access this script directly'); 
 
if(!$logged_in){
    echo "<body>
    <form action='./index.php?page=timeclock' method='POST'>
    Password:<input name='password' type='password'>" . $msg . "<br>
    <input type='hidden' name='page' value='timeclock'>
    <input type='submit' value='Log in'>
    </form>
    </body>
    </html>";
}
?-->
