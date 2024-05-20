<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
require "$_SERVER[DOCUMENT_ROOT]/delivery-boy/secure.php";
$path = $_SERVER["DOCUMENT_ROOT"];
$desk_navbar = $mob_navbar= '';
$html = '';
$id = $_SESSION["id"];
if(!isset($_GET["booking_id"]) && !$_GET["booking_id"]){
	header("Location: /delivery-boy/"); exit;
}
$booking_id = $_GET["booking_id"];

if(isset($_POST) && $_POST){
	echo "<pre>"; print_r($_REQUEST); exit;
}

//Getting Delivery Boy's Delivery Listing :: Start
$pql = "SELECT b.*, c.name as carName,c.vehicle_number, c.image as carImage FROM bookings as b INNER JOIN cars as c ON c.id=b.car_id WHERE b.delivery_boy_id=$id AND b.id={$booking_id}";
// echo $pql; exit;
$sql = $connect->query($pql) OR die($connect->error);
$res = $sql->fetch_object();
$html=$res->carName.' ('.$res->vehicle_number.')';
//Getting Delivery Boy's Delivery Listing :: End

//Cheking Id User Already submit his report :: Start
$prevId = 0;
$startKmReading = 0;
$startFuelReading = 0;


$outside_car_videoYes=$outside_car_videoNo=$drinkingC=$traffic_rulesC=$offroadC="";

$keysArray = ["rc", "insurance", "pollution", "mobile_charger", "horn", "wiper", "ac_heater", "head_light", "tail_light", "music_system", "seat_belts", "tool_kit", "jack", "clean_inside", "clean_outside", "drinking", "drinking", "traffic_rules", "offroad"];

$keysArray2 = ["right_side_front", "left_side_front", "left_side_rear", "right_side_rear", "spare_tyre"];

foreach($keysArray as $keys){
	$out_arr[$keys."Yes"] = "";
	$out_arr[$keys."No"] = "";
}

foreach($keysArray2 as $keys2){
	$out_arr[$keys2."Yes"] = "";
	$out_arr[$keys2."Well"] = "";
	$out_arr[$keys2."No"] = "";
}

$pending_amount = $fastag_balance = 0;

$sql2 = $connect->query("SELECT * FROM staff_start_checklist WHERE booking_id={$res->id}") OR die($connect->error);
if($sql2->num_rows > 0){
	$res2 = $sql2->fetch_object();
	$prevId = $res2->id;
	$startKmReading = $res2->km_reading;
	$startFuelReading = $res2->fuel_reading;
	foreach($keysArray as $keys){
		$res2->$keys == 1 ? $out_arr[$keys."Yes"] = "checked" : $out_arr[$keys."No"] = "checked";
	}
	foreach($keysArray2 as $keys3){
		if($res2->$keys3 == 1){
			$out_arr[$keys3."Yes"] = "checked";
		}
		if($res2->$keys3 == 2){
			$out_arr[$keys3."Well"] = "checked";
		}
		if($res2->$keys3 == 3){
			$out_arr[$keys3."No"] = "checked";
		}
	}
	$pending_amount = $res2->pending_amount;
	$fastag_balance = $res2->fastag_balance;
	$res2->outside_car_video == 1 ? $outside_car_videoYes="selected": $outside_car_videoNo="selected";
}else{
	$sql3 = $connect->query("SELECT * FROM start_checklist WHERE booking_id={$res->id}") OR die($connect->error);
	if($sql3->num_rows > 0){
		$res2 = $sql3->fetch_object();
		$prevId = $res2->id;
		$startKmReading = $res2->km_reading;
		$startFuelReading = $res2->fuel_reading;
		foreach($keysArray as $keys){
			$res2->$keys == 1 ? $out_arr[$keys."Yes"] = "checked" : $out_arr[$keys."No"] = "checked";
		}
		foreach($keysArray2 as $keys3){
			if($res2->$keys3 == 1){
				$out_arr[$keys3."Yes"] = "checked";
			}
			if($res2->$keys3 == 2){
				$out_arr[$keys3."Well"] = "checked";
			}
			if($res2->$keys3 == 3){
				$out_arr[$keys3."No"] = "checked";
			}
		}
		$pending_amount = $res2->pending_amount;
		$fastag_balance = $res2->fastag_balance;
		$res2->outside_car_video == 1 ? $outside_car_videoYes="selected": $outside_car_videoNo="selected";
	}
}
//Cheking Id User Already submit his report :: End

$output = file_get_contents("index_tpl.html");
$out_arr["version"] = time();
$out_arr["loginUserName"] = $_SESSION["name"];
$out_arr["version"] = $version;
$out_arr["carDetailsHere"] = $html;
$out_arr["temp_id"] = $res->temp_id;
$out_arr["booking_id"] = $res->id;
$out_arr["staff_id"] = $res->delivery_boy_id;
$out_arr["prevId"] = $prevId;
$out_arr["startKmReading"] = $startKmReading;
$out_arr["startFuelReading"] = $startFuelReading;

$out_arr["pending_amount"] = $pending_amount;
$out_arr["fastag_balance"] = $fastag_balance;

$out_arr["outside_car_videoYes"] = $outside_car_videoYes;
$out_arr["outside_car_videoNo"] = $outside_car_videoNo;

/*
$out_arr["rcYes"] = $rcYes;
$out_arr["rcNo"] = $rcNo;*/

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
 