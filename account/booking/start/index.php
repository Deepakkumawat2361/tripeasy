<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
require "$_SERVER[DOCUMENT_ROOT]/secure.php";
$path = $_SERVER["DOCUMENT_ROOT"];
$desk_navbar = $mob_navbar= '';

// if(isset($_POST["start_km_reading"]) && $_POST["start_km_reading"]){
	// echo "<pre>"; print_r([$_POST, $_GET, count($_POST)]); exit;
	
// }


$urlId = $_GET["id"];
$temp_id = base64_decode($urlId);


//Sql :: Start
$sql = $connect->query("SELECT id FROM bookings WHERE temp_id='$temp_id'") OR die($connect->error);
$res = $sql->fetch_object();
//Sql :: End



$output = file_get_contents("index.html");
$header = file_get_contents($path . "/layouts/header.html");
$footer = file_get_contents($path . "/layouts/footer.html");
$glinks = file_get_contents($path . "/layouts/global-links.html");
$gscripts = file_get_contents($path . "/layouts/global-scripts.html");

$out_arr["header"] = $header;
$out_arr["footer"] = $footer;
$out_arr["globLinks"] = $glinks;
$out_arr["globalScripts"] = $gscripts;
$out_arr["temp_id"] = $temp_id;
$out_arr["booking_id"] = $res->id;


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
 