<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
include("$_SERVER[DOCUMENT_ROOT]/connect.php");
session_start();
// echo (1)."<br>".$_SESSION["delivery_acces_token"]; exit;
if(!isset($_SESSION["delivery_acces_token"]) || !isset($_COOKIE["delivery_acces_token"])){
	makeAdminLogout();
	header("location:/tripeasy/delivery-boy-login");exit;
}

if(isset($_COOKIE["delivery_acces_token"])){
	$cook = explode(";",$_COOKIE["delivery_acces_token"]);
    $auth_admin_string =  decrypt($_COOKIE["delivery_acces_token"]);
	
    if(!$auth_admin_string){
		makeAdminLogout();
		header("location:/tripeasy/delivery-boy-login");exit;
	}
    
	if(count(explode(".",$auth_admin_string))<2){
		makeAdminLogout();
		header("location:/tripeasy/delivery-boy-login");exit;
	}
	
	$expocook = explode(".",$auth_admin_string);
	$login_query = $connect->query("select * from delivery_boys where id = '".addslashes($expocook[0])."' limit 1");
    if($login_query->num_rows==0){
		makeAdminLogout();
		header("location:/tripeasy/delivery-boy-login");exit;
	}
	$login_data = $login_query->fetch_object();
	if($login_data->pass_code !=$expocook[1]){
		makeAdminLogout();
		header("location:/tripeasy/delivery-boy-login");exit;	
	}
	
	if($_SESSION['pass_code']!=$login_data->pass_code){
		makeAdminLogout();
		header("location:/tripeasy/delivery-boy-login");exit;
	}
	
	
	
}else{
	makeAdminLogout();
	header("location:/tripeasy/delivery-boy-login");exit;
}


function makeAdminLogout(){
	session_unset();
	session_destroy();
	setcookie("delivery_acces_token", "", time()-1, "/");
	unset($_COOKIE["delivery_acces_token"]);
}
?>