<?php
	$servername = "localhost";
	
	$username = "root";
	$password = "";
	$databasename = "trip_easy";
	
	
	ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

	$connect = new mysqli($servername, $username, $password, $databasename);
	
	if($connect -> connect_errno){
		echo "Error ".$connect->error; die;
	}
	
	$version = "v1";

?>
