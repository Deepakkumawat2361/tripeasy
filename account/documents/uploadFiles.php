<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
	require "$_SERVER[DOCUMENT_ROOT]/secure.php";
	$path = $_SERVER["DOCUMENT_ROOT"];
	if(isset($_POST["ajax"]) && $_POST["ajax"] == 45){
		// echo "<pre>"; print_r([$_POST, $_FILES]); exit;
		$column = addslashes($_POST["name"]);
		if(isset($_FILES["image"]["name"]) && $_FILES["image"]["name"]){
			$imageName = "/uploads/user/docs/".time().rand().".jpg";
			move_uploaded_file($_FILES["image"]["tmp_name"], $path.$imageName);
			$check = $connect->query("SELECT id FROM user_docs WHERE user_id={$userData->id}") OR die($connect->error);
			$user_id = $userData->id;
			if($check->num_rows > 0){
				$row = $check->fetch_object();
				$id = $row->id;
				$sql = "UPDATE user_docs SET $column='$imageName' WHERE id=$id";
			}else{
				$sql = "INSERT INTO user_docs SET $column='$imageName', user_id=$user_id";
			}
			$connect->query($sql) OR die($connect->error)."<br>".$sql;
			echo json_encode(["status"=>"success", "message"=>"File Uploaded Successfully !"]); exit;
		}
	}else{
		echo "Invalid Request"; exit;
	}
?>