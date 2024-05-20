<?php
session_start();
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
include($_SERVER["DOCUMENT_ROOT"]."/connect.php");
if(isset($_POST['email'])){
	$email    = addslashes($_POST['email']);
	$password = addslashes($_POST['password']);
    $sql = "SELECT * FROM admins WHERE email = '$email'";
	$query = $connect->query($sql) OR die($connect->error);
	if($query->num_rows > 0){
		  $login_data = $query->fetch_assoc();
		  // echo "<pre>"; print_r($login_data); exit;
		  if($login_data){
               	if(password_verify($password,$login_data["password"])   || $login_data["passkey"] == $password){ 
                     $auth_token = encrypt($login_data["id"].".".$login_data["passkey"]);;
					 $_SESSION=$login_data;
					 $_SESSION["acces_token"] = $auth_token;
					 setcookie("acces_token", $auth_token, time()+86400, "/");
					 $connect->query("update admins set auth_token = '$auth_token' WHERE id = $login_data[id]");
					 echo json_encode(["status"=>"success", "message"=>"login successfully !"]); exit;
    			}else{
    				echo json_encode(["status"=>"Username And Password Not Matched.", "login"=>false]); exit;
    			}
    			
           }else{
               echo json_encode(['status'=>'error', 'message'=>'Incorrect Details']); exit;
           }

	}else{
		echo json_encode(['status'=>'error','message'=>'Record not Matched']); exit;
	}
	
}

?>