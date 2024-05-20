<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
require "$_SERVER[DOCUMENT_ROOT]/connect.php";
$path = $_SERVER["DOCUMENT_ROOT"];
$desk_navbar = $mob_navbar= '';


//login functionality start
if(isset($_POST['ajax']) && $_POST['ajax'] == 45){
	//print_r($_POST); exit;
	$username= $_POST['username'];
	$password= $_POST['password'];
	
	$sql="SELECT * FROM delivery_boys WHERE email='$username'";
	$res = $connect->query($sql);
	if($res->num_rows > 0){
		$row = $res->fetch_object();
		if(password_verify($password, $row->password )){
			echo '<script>alert("login successfully")</script>';
		}else{
			echo '<script>alert("invalid username or password")</script>'; 
		}
	}else{
		echo '<script>alert("invalid username or password")</script>';
	}
	
	// echo "<pre>"; print_r($row); exit;
}

//login functionality end


$output = file_get_contents("index_tpl.html");

$out_arr["version"] = 1;


foreach ($out_arr as $outKey => $outVal) {
    $output = str_replace("{" . $outKey . "}", $outVal, $output);
}
echo minifier($output);
function minifier($code)
{
	return $code;
    $search = ["/\>[^\S ]+/s", "/[^\S ]+\</s", "/(\s)+/s", "/<!--(.|\s)*?-->/"];
    $replace = [">", "<", '\\1'];
    $code = preg_replace($search, $replace, $code);
    return $code;
} ?>
 