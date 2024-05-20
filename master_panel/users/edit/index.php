<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

$path = $_SERVER['DOCUMENT_ROOT'];
include_once("$path/connect.php");
header('Content-Type: text/html; charset=UTF-8');
 
if(!isset($_GET["id"])){
	header("Location:/tripeasy/master_panel/users/"); exit;
}
$id = $_GET["id"];


//Submiting User Form :: Start
if(isset($_POST["name"]) && $_POST["name"]){
	// echo "<pre>"; print_r($_POST); exit;
	$name = addslashes($_POST["name"]);
	$email = addslashes($_POST["email"]);
	$address = addslashes($_POST["address"]);
	$dob = date("Y-m-d", strtotime(addslashes($_POST["dob"])));
	$status = addslashes($_POST["status"]);
	
	$connect->query("UPDATE users SET 
					name='$name',  
					email='$email',  
					address='$address',  
					dob='$dob',  
					status='$status' 
					WHERE id=$id") OR die($connect->error);
	header("Location:/tripeasy/master_panel/users/");
} 
//Submiting User Form :: End 

//Getting User Data :: Start
$sql = $connect->query("SELECT * FROM users WHERE id={$id}") OR die($connect->error);
$row = $sql->fetch_object();
//Getting User Data :: End



//Getting Documents Content :: Start
$sql = $connect->query("SELECT * FROM user_docs WHERE user_id={$row->id}") OR die($connect->error);
$res = $sql->fetch_object();


$adhaarStatus = '<button class="btn btn-warning" onclick="makeStatusProper(1,1)">Pending</button>';
if($res->adhaar_status == 1){
	$adhaarStatus = '<button class="btn btn-success" onclick="makeStatusProper(1,0)">Approved</button>';
}
$licenseStatus = '<button class="btn btn-warning" onclick="makeStatusProper(2,1)">Pending</button>';
if($res->license_status == 1){
	$licenseStatus = '<button class="btn btn-success" onclick="makeStatusProper(2,0)">Approved</button>';
}

$html='
	<tr>
		<td>
			Adhaar Card
		</td>
		<td><a target="_blank" href="'.$res->adhaar_front.'"><img src="/tripeasy/'.$res->adhaar_front.'" class="size"/></a></td>
		<td><a target="_blank" href="'.$res->adhaar_back.'"><img src="/tripeasy/'.$res->adhaar_back.'" class="size"/></a></td>
	</tr>
	<tr>
		<td>
			License
		</td>
		<td><a target="_blank" href="'.$res->license_front.'"><img src="/tripeasy/'.$res->license_front.'" class="size"/></a></td>
		<td><a target="_blank" href="'.$res->license_back.'"><img src="/tripeasy/'.$res->license_back.'" class="size"/></a></td>
	</tr>
';

//Getting Documents Content :: End


 
$header = file_get_contents("$path/master_panel/layout/header.html");
$sidebar = file_get_contents("$path/master_panel/layout/sidebar.html");
$navbar = file_get_contents("$path/master_panel/layout/navbar.html");
$output = file_get_contents('index_tpl.html'); 
$footer = file_get_contents("$path/master_panel/layout/footer.html");
$version = 1;

$arr = [
	'header'=>$header,
	'sidebar'=>$sidebar,
	'navbar'=>$navbar,
	'html'=>$html,
	'footer'=>$footer,
];

foreach($arr as $outKey=>$outVal){
	$output = str_replace('{'.$outKey.'}',$outVal,$output);
}
foreach($row as $outKey=>$outVal){
	$output = str_replace('{'.$outKey.'}',$outVal,$output);
}
 
echo ($output); exit;

ob_start("minifier");
function minifier($code) {
	return $code;
    $search = array(
        '/\>[^\S ]+/s',
        '/[^\S ]+\</s',
        '/(\s)+/s',
        '/<!--(.|\s)*?-->/'
    );
    $replace = array('>', '<', '\\1');
    $code = preg_replace($search, $replace, $code);
    return $code;
}

echo minifier($output);

function getCurrentDomainWithHttps() {
    $is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    $domain = $_SERVER['HTTP_HOST'];
    $protocol = $is_https ? 'https://' : 'http://';
    $current_url = $protocol . $domain;
    return $current_url;
}

 
?>