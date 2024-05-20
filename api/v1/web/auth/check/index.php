<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

	if(isset($_POST["ajax"]) && $_POST["ajax"] == 45){
		require("$_SERVER[DOCUMENT_ROOT]/connect.php");
		$accessToken = isset($_COOKIE["user_access"]) && $_COOKIE["user_access"] ? addslashes($_COOKIE["user_access"]) :  false;
		if(!$accessToken){
			echo json_encode(["status"=>"error", "message"=>"Please Login To Continue"]); exit;
		}
		$userID = explode(".", decrypt($accessToken))[0];
		$check = $connect->query("SELECT id FROM users WHERE id=$userID") OR die($connect->error);
		if($check->num_rows == 0){
			echo json_encode(["status"=>"error", "message"=>"Please Login To Continue"]); exit;
		}
		echo json_encode(["status"=>"success", "message"=>"Auth Okay !"]); exit;
		//Getting Temp Data :: End
	}else{
		echo "Invalid Action"; exit;
	}
?>