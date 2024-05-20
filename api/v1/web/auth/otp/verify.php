<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

	header('Content-type: application/json; charset=UTF-8');
	$post =$_POST;
	if($_SERVER['REQUEST_METHOD'] !== 'POST') {
		echo json_encode(
			[
				"response"=>[
					"data"=>(object)[],
					"status"=>"error",
					"message"=>"Invaild method",
				]
			]
		);exit;
	}
	
	$mobile = isset($post["mobile"]) && $post["mobile"] ? $post["mobile"] : false;
	$otp = isset($post["otp"]) && $post["otp"] ? $post["otp"] : false;
	$errors=[];
	
	if(!$mobile){
		$errors['mobile'] ="mobile required";
	}
	if(!$otp){
		$errors['otp'] ="otp required";
	}
	if($errors){ 
		echo json_encode(
			[
			"response"=>[
					"data"=>(object)[],
					"status"=>"error",
					"message"=>"validation error",
					'errors'=>$errors
				]
			]
		);exit;
	}
	require("$_SERVER[DOCUMENT_ROOT]/connect.php"); 	
	$query = $connect->query("select * from users where mobile = '$mobile' limit 1") OR die($connect->error);
	$user = $query->fetch_object();
	$auth_token = encrypt($user->id.".".$user->passkey);
	if($query->num_rows==0){
		$errors['mobile'] ="mobile not registered";
		echo json_encode(
			[
			"response"=>[
							"data"=>(object)[],
							"status"=>"error",
							"message"=>"validation error",
							'errors'=>$errors
						]
			]
		);exit;
		
	}
	if($otp  != $user->otp){
	   $errors['otp'] ="Invalid otp";
	   echo json_encode(
			[
			"response"=>[
							"data"=>(object)[],
							"status"=>"error",
							"message"=>"validation error",
							'errors'=>$errors
						]
			]
		);exit;
	}
	$name = isset($_POST["name"]) && $_POST["name"] ? addslashes($_POST["name"]) : "";
	$email = isset($_POST["email"]) && $_POST["email"] ? addslashes($_POST["email"]) : "";
	$connect->query("UPDATE users SET auth_token='$auth_token', name='$name', email='$email' WHERE id={$user->id}") OR die($connect->error);
	setcookie('user_access', $auth_token, time() + (86400 * 30),  "/" ,  "".$_SERVER['SERVER_NAME']);
	setcookie('user_email', $user->email, time() + (86400 * 30),   "/" ,  "".$_SERVER['SERVER_NAME']); 
	setcookie('user_mobile', $mobile, time() + (86400 * 30),   "/" ,  "".$_SERVER['SERVER_NAME']); 
	$uSql = $connect->query("SELECT * FROM users WHERE id=$user->id") OR die($connect->error);
	$redirect = isset($_COOKIE["redirect_url"]) && $_COOKIE["redirect_url"] ? 1: 0;
	$link="";
	if($redirect == 1){
		$link = urldecode($_COOKIE["redirect_url"]);
		unset($_COOKIE["redirect_url"]);
		setcookie("redirect_url", "", time()-1, "/");
	}
	$user = $uSql->fetch_object();
	echo json_encode(
		[
		"response"=>[
						"data"=>(object)[],
						"status"=>"success",
						"message"=>"Succesfully login",
						"redirect"=>1,
						"redLink"=>"$link",
						"user"=>$user
					]
		]
	);exit;
?>
