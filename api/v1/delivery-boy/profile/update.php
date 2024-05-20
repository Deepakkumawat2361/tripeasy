<?php
	session_start();
	$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
	$id = $_SESSION["id"];
	if(isset($_POST["name"]) && $_POST["name"] && $id){
		require("$_SERVER[DOCUMENT_ROOT]/connect.php");
		$post = $_POST;
		$image = $_SESSION["image"];
		$name = addslashes($post["name"]);
		$email = addslashes($post["email"]);
		$mobile = addslashes($post["mobile"]);
		$address = addslashes($post["address"]);
		if(isset($_FILES["image"]["name"]) && $_FILES["image"]["name"]){
			$image = "/uploads/delivery_boy/".time().".jpg";
			move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"].$image);
		}
		$sql = "UPDATE delivery_boys SET 
			name='$name',
			email='$email',
			mobile='$mobile',
			address='$address',
			image='$image'
			WHERE id = $id
		";
		$connect->query($sql) OR die($connect->error);
		echo json_encode(["status"=>"success"]); exit;
	}else{
		echo "Invalid Action"; exit;
	}
?>