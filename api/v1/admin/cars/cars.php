<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
include_once("$_SERVER[DOCUMENT_ROOT]/connect_db.php");

$sql = "SELECT * FROM cars";
$query = $connect->query($sql);
//print_r($query); exit;

if($query->num_rows > 0){
	$i=1;
	while( $fetch_data = $query->fetch_object())
	{
		//echo "<pre>";
		//print_r($fetch_data); exit;
		
	   $data[] = $fetch_data;
	}
	$i++;
	echo json_encode([
				'status'=>'success',
				'data'=>$data,
				'message'=>'Data fetch Successfully',
				
		]); exit;
	
}else{
	echo json_encode(['status'=>'not_exits','message'=>'No Record Found']);
}

?> 