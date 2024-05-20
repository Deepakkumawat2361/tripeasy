<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
 
include_once "$_SERVER[DOCUMENT_ROOT]/connect_db.php";
$path = $_SERVER["DOCUMENT_ROOT"];
$desk_navbar = $mob_navbar= '';

// Using PHP
$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$canonical = explode('?', $currentURL)[0];
 


extract($_REQUEST);

$date1 = new DateTime(date("Y-m-d H:00:00",$start));
$date2 = new DateTime(date("Y-m-d H:00:00",$end));


$interval = $date1->diff($date2);

$hours = $interval->h + ($interval->days * 24);


$duration = '';

if($interval->days>0)
{
	$duration .= "$interval->days Day ";
}

if($interval->h>0)
{
	$duration .= "$interval->h hours ";
}


 
$slug = addslashes($_GET['slug']);
$query = $connect->query("select * from cars where slug ='$slug'  limit 1 ") OR die($connect->error);
$data = $query->fetch_object();


// echo "<pre>"; print_r($data); exit;


$qry = $connect->query("select * from car_details where id ='$data->id'  limit 1 ") OR die($connect->error);
$detail = $qry->fetch_object();


foreach($data as $d=>$dat)
{    
	 $out_arr[$d] = $dat;
}
foreach($detail as $e=>$da)
{
	 $out_arr[$e] = $da;
}


 


$output = file_get_contents("index.html");
$header = file_get_contents($path . "/layouts/header.html");
$footer = file_get_contents($path . "/layouts/footer.html");
$glinks = file_get_contents($path . "/layouts/global-links.html");
$gscripts = file_get_contents($path . "/layouts/global-scripts.html");

$title = "$data->name $data->model_year available for self-drive rental in $location.";
$description = "Explore $location in style with our self-drive $data->name $data->model_year rentals. Convenient, affordable, and reliable car rental services. Book now!.";
$out_arr["km"] = $km." KM/DAY";
$out_arr["title"] = $title;
$out_arr["canonical"] = $canonical;
$out_arr["description"] = $description;
$out_arr["header"] = $header;
$out_arr["footer"] = $footer;
$out_arr["globLinks"] = $glinks;
$out_arr["globalScripts"] = $gscripts;
$out_arr["display_start"] = date("D, d M Y",$start);
$out_arr["display_end"] = date("D, d M Y",$end);
$out_arr["display_start_time"] = date("h:00 a",$start);
$out_arr["display_end_time"] = date("h:00 a",$end);
$out_arr["duration"] = $duration;
$out_arr["location"] = $location;
$out_arr["kms"] = $km==250 ? '' :'d-none';

$out_arr["booking_fair"] = $data->price*$hours;
$out_arr["discount"] = 0.0;
$out_arr["final_price"] = ($data->price*$hours)+$detail->security_deposite;
$out_arr["half_payment"] = $out_arr["final_price"]/2;

	$sql = "INSERT INTO temp_cart set 
				booking_id = ".addslashes($booking_id)." , 
				start_date = ".addslashes($start)." , 
				end_date = ".addslashes($end)." , 
				created = ".addslashes(time())." , 
				km_plan = '".addslashes($km)."' , 
				car_id = ".$out_arr['id']." ,
				fair = ".$out_arr['booking_fair']." ,
				discount = ".$out_arr['discount']." ,
				final_payment = ".$out_arr['final_price']." ,
				security_deposite = ".$out_arr['security_deposite']." ,
				half_payment = ".$out_arr['half_payment']." 
				ON DUPLICATE KEY UPDATE  
				start_date = ".addslashes($start)." , 
				end_date = ".addslashes($end)." , 
				km_plan = '".addslashes($km)."' , 
				created = ".addslashes(time())." , 
				car_id = ".$out_arr['id']." ,
				fair = ".$out_arr['booking_fair']." ,
				discount = ".$out_arr['discount']." ,
				final_payment = ".$out_arr['final_price']." ,
				security_deposite = ".$out_arr['security_deposite']." ,
				half_payment = ".$out_arr['half_payment']." 
				";
			// echo $sql; exit;
			$connect->query($sql) or die($connect->error);
   


$out_arr["tempCartId"] = $_GET["booking_id"];


foreach ($out_arr as $outKey => $outVal) {
	$outVal = $outVal ? $outVal : '';
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
 