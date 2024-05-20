<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

require "$_SERVER[DOCUMENT_ROOT]/secure.php";
$path = $_SERVER["DOCUMENT_ROOT"];
$desk_navbar = $mob_navbar= '';


// echo "<pre>"; print_r($userData); exit;

if(isset($_POST["update"])){
	$post = $_POST;
	$name = addslashes($post["name"]);
	$email = addslashes($post["email"]);
	$mobile = addslashes($post["mobile"]);
	$address = addslashes($post["address"]);
	$dob = addslashes($post["dob"]);
	$connect->query("UPDATE users SET dob='$dob', name='$name', email='$email', mobile='$mobile', address='$address' WHERE id={$userData->id}") OR die($connect->error);
	header("location:/tripeasy/account/profile"); exit;
}

$output = file_get_contents("index_tpl.html");
$header = file_get_contents($path . "/layouts/header.html");
$footer = file_get_contents($path . "/layouts/footer.html");
$glinks = file_get_contents($path . "/layouts/global-links.html");
$gscripts = file_get_contents($path . "/layouts/global-scripts.html");

$out_arr["header"] = $header;
$out_arr["footer"] = $footer;
$out_arr["globLinks"] = $glinks;
$out_arr["globalScripts"] = $gscripts;
$out_arr["userName"] = $userData->name ?? "";
$out_arr["userEmail"] = $userData->email ?? "";
$out_arr["userMobile"] = $userData->mobile;
$out_arr["userAddress"] = $userData->address ?? "";
$out_arr["dob"] = $userData->dob ?? "";
$out_arr["created"] = date("Y-m-d",$userData->created) ?? "";
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
 