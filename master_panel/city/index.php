<?php
//echo "sdfs"; exit;
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

include("$_SERVER[DOCUMENT_ROOT]/connect.php");
header('Content-Type: text/html; charset=UTF-8');

















$header = file_get_contents("../layout/header.html");
$sidebar = file_get_contents("../layout/sidebar.html");
$navbar = file_get_contents("../layout/navbar.html");
$output = file_get_contents('index_tpl.html'); 
$footer = file_get_contents("../layout/footer.html");
$version = 1;

$arr = [
	'header'=>$header,
	'sidebar'=>$sidebar,
	'navbar'=>$navbar,
	'footer'=>$footer
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
}
?>