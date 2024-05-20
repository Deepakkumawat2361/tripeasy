<?php
session_start();
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
include($_SERVER["DOCUMENT_ROOT"]."/connect.php");
if(isset($_POST['email'])){
	$email    = addslashes($_POST['email']);
	$password = addslashes($_POST['password']);
    $sql = "SELECT * FROM delivery_boys WHERE email = '$email'";
	$query = $connect->query($sql) OR die($connect->error);
	if($query->num_rows > 0){
		  $login_data = $query->fetch_assoc();
		  // echo "<pre>"; print_r($login_data); exit;
		  if($login_data){
               	if(password_verify($password,$login_data["password"])   || $login_data["pass_code"] == $password){ 
                     $auth_token = encrypt($login_data["id"].".".$login_data["pass_code"]);;
					 $_SESSION=$login_data;
					 $_SESSION["delivery_acces_token"] = $auth_token;
					 setcookie("delivery_acces_token", $auth_token, time()+86400, "/");
					 $connect->query("update delivery_boys set auth_token = '$auth_token' WHERE id = $login_data[id]");
					 echo json_encode(["status"=>"success", "message"=>"login successfully !"]); exit;
    			}else{
    				echo json_encode(["status"=>"Username And Password Not Matched.", "login"=>false]); exit;
    			}
    			
           }else{
               echo json_encode(['status'=>'error', 'message'=>'Incorrect username or password']); exit;
           }

	}else{
		echo json_encode(['status'=>'error','message'=>'Incorrect username or password']); exit;
	}
	
}

?>