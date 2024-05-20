<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

	/*ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);*/
		
	
	
header("Content-type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "response" => [
            "data" => [],
            "status" => "error",
            "message" => "Invaild method",
        ],
    ]);
    exit();
}


$post = $_POST;
$mobile = isset($post["mobile"]) && $post["mobile"] ? $post["mobile"] : false;
/*validation start*/


$errors=[];
if(!$mobile){
	$errors['mobile'] ="mobile number required";
}
 

if($errors){ 
    echo json_encode(
			[
				"response"=>[
					"data"=>[],
					"status"=>"error",
					"message"=>"validation error",
					'errors'=>$errors
				]
			]
		);exit;
}


/*validation end*/
require("$_SERVER[DOCUMENT_ROOT]/connect.php"); 

$mobile = addslashes($mobile); 
$otp = rand(111111,999999);
// $otp = 123456;

sendOtp($otp, $mobile);
$query = $connect->query("select * from users where mobile = '$mobile' limit 1");
if($query->num_rows==0){
	$auth_token = bin2hex(random_bytes(16));
	$passkey = substr(md5(microtime()), rand(0, 26), 8);
	$password = password_hash(addslashes($passkey), PASSWORD_DEFAULT);
	$time = time();
	$connect->query("INSERT INTO users SET mobile='$mobile', otp = '$otp', password='$password', passkey='$passkey' , created= '$time'") OR die($connect->error);
	echo json_encode(
		[
			"response"=>[
				"data"=>[],
				"status"=>"success",
				"message"=>"otp sent succesfully",
				"isNew"=>1,
			]
		]
	);exit;
}else{
	$user = $query->fetch_object();
	$connect->query("update users set otp = '$otp' where id  = $user->id");
	$rv = 0;
	$field = [];
	if($user->name == ""){
		$field[] = "name";
	}
	if($user->email == ""){
		$field[] = "email";
	}
	echo json_encode(
		[
			"response"=>[
				"data"=>[],
				"status"=>"success",
				"message"=>"otp succesfully sent",
				"isNew"=>$rv,
				"field"=>$field,
			]
		]
	);exit; 
}

function sendOtp($otp, $mobile){
	$message = 'Dear Customer Your Verification code is '.$otp.'. Please enter this code within 15 minutes to verify your account. Team CAR RENTAL';
	// $url = 'http://46.4.104.219/vb/apikey.php?apikey=vDRbM2Wm8zc61GgB&senderid=CARENT&number='.urlencode($mobile).'&message='.urlencode($message);
	$url = 'http://46.4.104.219/vb/apikey.php?apikey=eU1wSJrKIndtYvKE&senderid=CARENT&templateid=1707171454712237667&number=91'.urlencode($mobile).'&message='.urlencode($message);
	// echo trim(str_replace(" ", "", $url)); exit;
	// file_put_contents($url);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
}
?>
