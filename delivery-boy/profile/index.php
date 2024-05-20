<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
require "$_SERVER[DOCUMENT_ROOT]/delivery-boy/secure.php";
$path = $_SERVER["DOCUMENT_ROOT"];
$desk_navbar = $mob_navbar= '';
$html = '';
$id = $_SESSION["id"];

// echo "<pre>"; print_r($_SESSION); exit;

//Getting Delivery Boy's Delivery Listing :: Start
$pql = "SELECT b.*, c.name as carName, c.image as carImage FROM bookings as b INNER JOIN cars as c ON c.id=b.car_id WHERE b.delivery_boy_id=$id";
// echo $pql; exit;
$sql = $connect->query($pql) OR die($connect->error);
while($res = $sql->fetch_object()){
	$date1 = new DateTime(date("Y-m-d H:00:00",strtotime($res->start_date)));
	$date2 = new DateTime(date("Y-m-d H:00:00",strtotime($res->end_date)));
	$interval = $date1->diff($date2);
	$hours = $interval->h + ($interval->days * 24);
	$duration = '';
	if($interval->days>0){
		$duration .= "$interval->days Day ";
	}
	if($interval->h>0){
		$duration .= "$interval->h hours ";
	}
	$startDate = date("D d M H:i", strtotime($res->start_date));
	$endDate = date("D d M H:i", strtotime($res->end_date));
	$html.='
		  <li>
			<a href="/tripeasy/delivery-boy/booking-details?booking_id='.$res->id.'">
				<div class="car_listing_inner">
				  <div class="car_listing_img">
					<img src="'.$res->carImage.'" alt="img">
				  </div> 
				  <div class="car_listing_inner_right">
					<span class="booking_id">
						#'.$res->temp_id.'
					</span>
					<h5>'.$res->carName.'</h5>
					<div class="booking-detail-car">
					  <div class="time-slection">
						 <div class="time-inner start">'.$startDate.'</div>
						 <div class="time-inner end">'.$endDate.'</div>					
					  </div>
				   </div>
				  </div>
				</div>
			</a>
		  </li>';
}
//Getting Delivery Boy's Delivery Listing :: End

//Getting Profile Data :: Start
$id = $_SESSION["id"];
$uRes = $connect->query("SELECT * FROM delivery_boys WHERE id = $id") OR die($connect->error);
$uRow = $uRes->fetch_object();
//Getting Profile Data :: End

$output = file_get_contents("index_tpl.html");
$sidebar = file_get_contents($path."/tripeasy/delivery-boy/layouts/sidebar.html");
$out_arr["sidebar"] = $sidebar;
$out_arr["version"] = 1;
$out_arr["loginUserName"] = $uRow->name;
$out_arr["email"] = $uRow->email;
$out_arr["mobile"] = $uRow->mobile;
$out_arr["address"] = $uRow->address;
$out_arr["image"] = $uRow->image ?? "/tripeasy/delivery-boy/images/logo.png";
$out_arr["version"] = $version;
$out_arr["listing"] = $html;
foreach ($out_arr as $outKey => $outVal) {
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
 