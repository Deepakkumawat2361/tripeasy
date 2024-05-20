<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";


$path = $_SERVER['DOCUMENT_ROOT'];
include("$path/master_panel/secure.php");
header('Content-Type: text/html; charset=UTF-8');


$id = $_GET['id'];

$check = $connect->query("SELECT * FROM bookings WHERE id =$id LIMIT 1") OR die($connect->error);
if($check->num_rows == 0){
	header("Location:/tripeasy/master_panel/bookings"); exit;
}
$row = $check->fetch_object();
$startTime = strtotime($row->start_date);
$endTime = strtotime($row->end_date);

$date1 = new DateTime(date("Y-m-d H:00:00",$startTime));
$date2 = new DateTime(date("Y-m-d H:00:00",$endTime));
$interval = $date1->diff($date2);
$hours = $interval->h + ($interval->days * 24);
$duration = '';
if($interval->days>0){
	$duration .= "$interval->days Day";
}
if($interval->h>0){
	$duration .= "s $interval->h hours ";
}
$row->booking_duration = $duration;

// echo "<pre>"; print_r($row); exit;

//Getting Car Details :: Start
$carSql = $connect->query("SELECT * FROM cars WHERE id ={$row->car_id} LIMIT 1") OR die($connect->error);
$carRow = $carSql->fetch_object();
//Getting Car Details :: End


//Getting User Details :: Start
$sql = "SELECT * FROM users WHERE id ={$row->user_id}";
// echo $sql; exit;
$userSql = $connect->query($sql) OR die($connect->error);
$userRow = $userSql->fetch_object();
//Getting User Details :: End


// echo "<pre>"; print_r($userRow); exit;


$header = file_get_contents("$path/master_panel/layout/header.html");
$sidebar = file_get_contents("$path/master_panel/layout/sidebar.html");
$navbar = file_get_contents("$path/master_panel/layout/navbar.html");
$output = file_get_contents('index_tpl.html'); 
$footer = file_get_contents("$path/master_panel/layout/footer.html");
$version = 1;

$arr = [
	'id'=>$id,
	'header'=>$header,
	'sidebar'=>$sidebar,
	'navbar'=>$navbar,
	'carName'=>$carRow->name,
	'carSegment'=>$carRow->segment,
	'carBrand'=>$carRow->brand ?? "India Loha",
	'carModel'=>$carRow->model,
	'carFuel'=>$carRow->fuel,
	'carSeater'=>$carRow->seater,
	'carTransmission'=>$carRow->transmission,
	'carPrice'=>$carRow->price,
	'carImage'=>$carRow->image,
	'userName'=>$userRow->name,
	'userMobile'=>$userRow->mobile,
	'userEmail'=>$userRow->email,
	'userAddress'=>$userRow->address,
	'footer'=>$footer
];

foreach($arr as $outKey=>$outVal){
	$outVal = $outVal ?? "";
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