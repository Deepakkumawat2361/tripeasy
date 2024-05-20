<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

$path = $_SERVER['DOCUMENT_ROOT'];
include_once("$path/connect.php");
header('Content-Type: text/html; charset=UTF-8');
 
 

 
 //Getting Settings Data :: Start
 $sql = $connect->query("SELECT * FROM settings") OR die($connect->error);
 $row = $sql->fetch_object();
 //Getting Settings Data :: End
 
//Submiting User Form :: Start
if(isset($_POST["contact"]) && $_POST["contact"]){
	// echo "<pre>"; print_r($_POST); exit;
	$contact = addslashes($_POST["contact"]);
	$telephone = addslashes($_POST["telephone"]);
	$whatsapp = addslashes($_POST["whatsapp"]);
	
	$logo = $row->logo ?? "";
	$mobile_logo = $row->mobile_logo ?? "";
	
	
	if(isset($_FILES["logo"]["name"]) && $_FILES["logo"]["name"]){
		$logo = "/uploads/settings/".time().rand(555,999).".jpg";
		move_uploaded_file($_FILES["logo"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"].$logo);
	}
	if(isset($_FILES["mobile_logo"]["name"]) && $_FILES["mobile_logo"]["name"]){
		$mobile_logo = "/uploads/settings/".time().rand(111,555).".jpg";
		move_uploaded_file($_FILES["mobile_logo"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"].$mobile_logo);
	}
	$sql = "UPDATE settings SET 
					contact='$contact',  
					whatsapp='$telephone',  
					telephone='$whatsapp',  
					logo='$logo',  
					mobile_logo='$mobile_logo' 
					";
					// echo $sql; exit;
	$connect->query($sql) OR die($connect->error);
	header("Location:/master_panel/settings/");
} 
//Submiting User Form :: End 



 
 
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