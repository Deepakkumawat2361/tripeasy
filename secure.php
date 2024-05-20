<?php
	$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
	require("$_SERVER[DOCUMENT_ROOT]/connect.php");
	$accessToken = isset($_COOKIE["user_access"]) && $_COOKIE["user_access"] ? addslashes($_COOKIE["user_access"]) :  false;
	if(!$accessToken){
		header("location:/tripeasy/login"); exit;
	}
	$userID = explode(".", decrypt($accessToken))[0];
	$check = $connect->query("SELECT * FROM users WHERE id=$userID") OR die($connect->error);
	if($check->num_rows == 0){
		header("location:/tripeasy/login"); exit;
	}
	$userData = $check->fetch_object();
	
?>