<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
require "$_SERVER[DOCUMENT_ROOT]/secure.php";
$path = $_SERVER["DOCUMENT_ROOT"];
$desk_navbar = $mob_navbar= '';


$id = decrypt($_GET["id"]);
if(!$id){
	header("Location:/tripeasy/account/booking"); exit;
}

$check = $connect->query("select b.id as booking_id, b.*,c.* from bookings b join cars c on c.id = b.car_id WHERE b.id=$id") OR die($connect->error);

if($check->num_rows == 0){
	header("Location:/tripeasy/account/booking"); exit;
}
$row = $check->fetch_object();

// echo"<pre>"; print_r($row); exit;



$start = strtotime(date("Y-m-d H:i:s", strtotime($row->start_date)));
$end = strtotime(date("Y-m-d H:i:s", strtotime($row->end_date)));
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
//Checking If Listed :: Start

$startCheckList = '
	<a href="/tripeasy/account/booking/start/?id={url_temp_id}" class="button-2 blue-bg ml-2">
         Start Check List
       </a>
';
$bid = $row->booking_id;
$num = $connect->query("SELECT id FROM start_checklist WHERE booking_id={$bid}") OR die($connect->error);
if($num->num_rows > 0){
	$startCheckList = '
		<a href="#" class="button-2 blue-bg ml-2">
          Booking Start
        </a>
	';
}

//Checking If Listed :: Start


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
$out_arr["startCheckList"] = $startCheckList;
$out_arr["location"] = strtoupper($location);
$out_arr["title"] = $title;
$out_arr["globLinks"] = $glinks;
$out_arr["globalScripts"] = $gscripts;
$out_arr["final_fair"] = $row->final_fair;
$out_arr["discount"] = $row->discount;
$out_arr["net_fair"] = ($row->final_fair - $row->discount);
$out_arr["segment"] = ($row->segment);
$out_arr["transmission"] = ($row->transmission);
$out_arr["fuel"] = ($row->fuel);
$out_arr["seater"] = ($row->seater);
$out_arr["name"] = ($row->name);
$out_arr["image"] = ($row->image);
$out_arr["temp_id"] = ($row->temp_id);
$out_arr["url_temp_id"] = base64_encode($row->temp_id);
$out_arr["start_date"] = date("d M Y", strtotime($row->start_date))." @ ".date("H:i a", strtotime($row->start_date));
$out_arr["end_date"] = date("d M Y", strtotime($row->end_date))." @ ".date("H:i a", strtotime($row->end_date));
foreach ($out_arr as $outKey => $outVal){
    $output = str_replace("{" . $outKey . "}", $outVal, $output);
}
echo minifier($output);


function minifier($code){
	return $code;
    $search = ["/\>[^\S ]+/s", "/[^\S ]+\</s", "/(\s)+/s", "/<!--(.|\s)*?-->/"];
    $replace = [">", "<", '\\1'];
    $code = preg_replace($search, $replace, $code);
    return $code;
} ?>
 