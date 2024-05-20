<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
	date_default_timezone_set("Asia/Kolkata");
	$created_at = date("Y-m-d H:i:s");
	require("$_SERVER[DOCUMENT_ROOT]/connect.php");
	if(isset($_POST["ajax"]) && $_POST["ajax"] == 45){
		// echo "<pre>"; print_r([$_POST, count($_POST)]); exit;
		$drinking = $_POST["drinking"] == "on" ? 1 : 0;
		$traffic_rules = $_POST["traffic_rules"] == "on" ? 1 : 0;
		$offroad = $_POST["offroad"] == "on" ? 1 : 0;
		$display_booking = explode("#", $_POST["temp_booking_id"])[1];
		$booking_id = $_POST["booking_id"];
		$km_reading = $_POST["start_km_reading"];
		$fuel_reading = $_POST["start_fuel_reading"];
		$rc = $_POST["rc"];
		$insurance = $_POST["insurance"];
		$pollution = $_POST["pollution"];
		$mobile_charger = $_POST["mobile_charger"];
		$horn = $_POST["horn"];
		$wiper = $_POST["wiper"];
		$ac_heater = $_POST["ac_heater"];
		$head_light = $_POST["head_light"];
		$tail_light = $_POST["tail_light"];
		$music_system = $_POST["music_system"];
		$seat_belts = $_POST["seat_belts"];
		$tool_kit = $_POST["tool_kit"];
		$jack = $_POST["jack"];
		$right_side_front = $_POST["right_side_front"];
		$left_side_front = $_POST["left_side_front"];
		$left_side_rear = $_POST["left_side_rear"];
		$right_side_rear = $_POST["right_side_rear"];
		$spare_tyre = $_POST["spare_tyre"];
		$clean_inside = $_POST["clean_inside"];
		$clean_outside = $_POST["clean_outside"];
		$pending_amount = $_POST["pending_amount"] ?? 0;
		$fastag_balance = $_POST["fastag_balance"];
		$outside_car_video = $_POST["outside_car_video"];
		$staff_id = $_POST["staff_id"];
		$checklist_id = $_POST["checklist_id"] ?? 0;
		//Checking :: Start
		$check = $connect->query("SELECT id FROM staff_start_checklist WHERE booking_id='$booking_id'") OR die($connect->error);
		//Checking :: End
		
		if($check->num_rows > 0){
			$sql = "
				UPDATE staff_start_checklist SET
				checklist_id='$checklist_id',
				display_booking='$display_booking',
				km_reading='$km_reading',
				fuel_reading='$fuel_reading',
				rc='$rc',
				insurance='$insurance',
				pollution='$pollution',
				mobile_charger='$mobile_charger',
				horn='$horn',
				wiper='$wiper',
				ac_heater='$ac_heater',
				head_light='$head_light',
				tail_light='$tail_light',
				music_system='$music_system',
				seat_belts='$seat_belts',
				tool_kit='$tool_kit',
				jack='$jack',
				right_side_front='$right_side_front',
				left_side_front='$left_side_front',
				left_side_rear='$left_side_rear',
				right_side_rear='$right_side_rear',
				spare_tyre='$spare_tyre',
				clean_inside='$clean_inside',
				clean_outside='$clean_outside',
				pending_amount='$pending_amount',
				fastag_balance='$fastag_balance',
				outside_car_video='$outside_car_video',
				drinking='$drinking',
				traffic_rules='$traffic_rules',
				offroad='$offroad'
				WHERE booking_id='$booking_id'
			";
		}else{
			$sql = "
				INSERT INTO staff_start_checklist SET
				booking_id='$booking_id',
				staff_id='$staff_id',
				checklist_id='$checklist_id',
				display_booking='$display_booking',
				km_reading='$km_reading',
				fuel_reading='$fuel_reading',
				rc='$rc',
				insurance='$insurance',
				pollution='$pollution',
				mobile_charger='$mobile_charger',
				horn='$horn',
				wiper='$wiper',
				ac_heater='$ac_heater',
				head_light='$head_light',
				tail_light='$tail_light',
				music_system='$music_system',
				seat_belts='$seat_belts',
				tool_kit='$tool_kit',
				jack='$jack',
				right_side_front='$right_side_front',
				left_side_front='$left_side_front',
				left_side_rear='$left_side_rear',
				right_side_rear='$right_side_rear',
				spare_tyre='$spare_tyre',
				clean_inside='$clean_inside',
				clean_outside='$clean_outside',
				pending_amount='$pending_amount',
				fastag_balance='$fastag_balance',
				outside_car_video='$outside_car_video',
				drinking='$drinking',
				traffic_rules='$traffic_rules',
				offroad='$offroad'
			";
		}
		$connect->query($sql) OR die($connect->error);
		echo json_encode(["status"=>"success"]); exit;
	}else{
		echo "Invalid Action"; exit;
	}
?>