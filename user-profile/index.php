<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

//include_once "$_SERVER[DOCUMENT_ROOT]/user_auth.php";
$path = $_SERVER["DOCUMENT_ROOT"];
$desk_navbar = $mob_navbar= '';



$output = file_get_contents("index.html");
$header = file_get_contents($path . "/layouts/header.html");
$footer = file_get_contents($path . "/layouts/footer.html");
$glinks = file_get_contents($path . "/layouts/global-links.html");
$gscripts = file_get_contents($path . "/layouts/global-scripts.html");

$out_arr["header"] = $header;
$out_arr["footer"] = $footer;
$out_arr["globLinks"] = $glinks;
$out_arr["globalScripts"] = $gscripts;
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
 