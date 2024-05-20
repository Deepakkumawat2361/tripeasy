<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

include("$_SERVER[DOCUMENT_ROOT]/connect.php");
session_start();

if(!isset($_SESSION["acces_token"]) || !isset($_COOKIE["acces_token"])){
	makeAdminLogout();
	header("location:/tripeasy/master_panel/login");exit;
}

if(isset($_COOKIE["acces_token"])){
	$cook = explode(";",$_COOKIE["acces_token"]);
    $auth_admin_string =  decrypt($_COOKIE["acces_token"]);
	
    if(!$auth_admin_string){
		makeAdminLogout();
		header("location:/tripeasy/master_panel/login");exit;
	}
    
	if(count(explode(".",$auth_admin_string))<2){
		makeAdminLogout();
		header("location:/tripeasy/master_panel/login");exit;
	}
	
	$expocook = explode(".",$auth_admin_string);
	$login_query = $connect->query("select * from admins where id = '".addslashes($expocook[0])."' limit 1");
    if($login_query->num_rows==0){
		makeAdminLogout();
		header("location:/tripeasy/master_panel/login");exit;
	}
	$login_data = $login_query->fetch_object();
	if($login_data->passkey !=$expocook[1]){
		makeAdminLogout();
		header("location:/tripeasy/master_panel/login");exit;	
	}
	
	if($_SESSION['passkey']!=$login_data->passkey){
		makeAdminLogout();
		header("location:/tripeasy/master_panel/login");exit;
	}
	
	if($login_data->role_id != 1){
		makeAdminLogout();
		header("location:/tripeasy/master_panel/login");exit;
	}
	
	
}else{
	makeAdminLogout();
	header("location:/tripeasy/master_panel/login");exit;
}


function makeAdminLogout(){
	session_unset();
	session_destroy();
	setcookie("acces_token", "", time()-1, "/");
	unset($_COOKIE["acces_token"]);
}
?>