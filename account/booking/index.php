<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

require "$_SERVER[DOCUMENT_ROOT]/secure.php";
$path = $_SERVER["DOCUMENT_ROOT"];
$desk_navbar = $mob_navbar= '';

$start = strtotime(date("Y-m-d H:i:s"));
$end = strtotime(date("Y-m-d H:i:s"));
//print_r($_REQUEST);
$start_date = date("Y-m-d",$start);
$start_time = date("h:00 a",$start);

$location="India";


$end_date = date("Y-m-d",$end);
$end_time = date("h:00 a",$end);

$date1 = new DateTime(date("Y-m-d H:00:00",$start));
$date2 = new DateTime(date("Y-m-d H:00:00",$end));
$interval = $date1->diff($date2);

 

$days = $interval->days;
$hours = $interval->h;

$duration = '';

if($days>0)
{
	$duration .= "$days Day ";
}

if($hours>0)
{
	$duration .= "$hours hours ";
}


$title = "Available for self-drive rental in ".strtoupper($location);

$output = file_get_contents("index_tpl.html");
$header = file_get_contents($path . "/layouts/header.html");
$footer = file_get_contents($path . "/layouts/footer.html");
$glinks = file_get_contents($path . "/layouts/global-links.html");
$gscripts = file_get_contents($path . "/layouts/global-scripts.html");

$out_arr["header"] = $header;
$out_arr["footer"] = $footer;
$out_arr["duration"] = $duration;
$out_arr["start_date"] = $start_date;
$out_arr["start_time"] = $start_time;
$out_arr["end_date"] = $end_date;
$out_arr["end_time"] = $end_time;
$out_arr["location"] = strtoupper($location);
$out_arr["title"] = $title;
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
 