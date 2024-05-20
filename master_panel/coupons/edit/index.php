<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

$path = $_SERVER['DOCUMENT_ROOT'];
include_once("$path/connect.php");
header('Content-Type: text/html; charset=UTF-8');
 
 
//Getting users List :: Start
$userlist='';
$sql = $connect->query("SELECT * FROM users") OR die($connect->error);
while($res = $sql->fetch_object()){
	$userlist.='
		<option value="'.$res->id.'">'.$res->name.'</option>
	';
}

//Getting users List :: End

 
 
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
	'userlist'=>$userlist,
	'footer'=>$footer,
];

foreach($arr as $outKey=>$outVal){
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
	print_r($current_url);die;
}

 
?>