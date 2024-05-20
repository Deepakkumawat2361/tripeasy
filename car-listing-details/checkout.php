<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

	if(isset($_POST["ajax"]) && $_POST["ajax"] == 45){
		require("$_SERVER[DOCUMENT_ROOT]/connect.php");
		$path = $_SERVER["DOCUMENT_ROOT"];
		
		$post = $_POST;
		$booking_id = $post["booking_id"];
		$paymentType = $post["payType"];
		$transaction_id = $post["transaction_id"];
		$accessToken = $_COOKIE["user_access"];
		$userID = explode(".", decrypt($accessToken))[0];
		
		$connect->query("UPDATE temp_cart SET payment_id='$transaction_id', user_id='$userID' WHERE booking_id='$booking_id'") OR die($connect->error);
		//Getting Temp Data :: Start
		$sql = $connect->query("SELECT * FROM temp_cart WHERE booking_id='$booking_id'") OR die($connect->error);
		if($sql->num_rows == 0){
			echo json_encode(["status"=>"error", "message"=>"No Data Found !"]); exit;
		}
		$data = $sql->fetch_object();
		$data->start_date = date("Y-m-d H:i:s", $data->start_date);
		$data->end_date = date("Y-m-d H:i:s", $data->end_date);
		$insertSql = "INSERT INTO bookings SET 
			car_id='{$data->car_id}',
			start_date='{$data->start_date}',
			end_date='{$data->end_date}',
			plan_id='{$data->km_plan}',
			booking_fair='{$data->fair}',
			security_deposite='{$data->security_deposite}',
			home_delivery_charge=0,
			discount='{$data->discount}',
			final_fair='{$data->final_payment}',
			booking_type='online',
			payment_status	= 1,
			payment_type = 'full',
			transaction_id	= '{$data->payment_id}',
			temp_id	= '{$data->booking_id}',
			user_id='{$userID}'
		";
		// echo $insertSql; exit;
		$connect->query($insertSql) OR die($connect->error);
		echo json_encode(["status"=>"success", "message"=>"Booking Created Successfully !"]); exit;
		//Getting Temp Data :: End
	}else{
		echo "Invalid Action"; exit;
	}
?>