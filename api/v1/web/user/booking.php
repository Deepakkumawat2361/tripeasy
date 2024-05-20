<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

if(!$_POST){
	$_POST =  json_decode( file_get_contents('php://input'),true);
}
header('Content-type: application/json; charset=UTF-8');

if($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(
				[
				"response"=>[
								"data"=>[],
								"status"=>"error",
								"message"=>"Invaild method",
							]
				]
			);exit;
}

$limit  = 10;
$offset = 0;

include_once("$_SERVER[DOCUMENT_ROOT]/connect.php"); 
$page =  $_REQUEST['page'] ?? 1;
 


$result = $connect->query("select b.id as booking_id,b.start_date,b.end_date,c.name,c.image,b.final_fair from bookings b join cars c on c.id = b.car_id order by start_date desc");

if($result->num_rows>0)
{
	while($row = $result->fetch_assoc())
	{
	    $row['start_date'] = date("Y-m-d h:i a",strtotime($row['start_date']));
	    $row['end_date']   = date("Y-m-d h:i a",strtotime($row['end_date']));
	    $row['id']   = encrypt($row['booking_id']);
		$data[] = $row;
	}
}else{
	$data=[];
}


echo json_encode(
			[
			"response"=>[

							"page"=>$page,
							"status"=>"success",
							"message"=>"Succesfully listed",
							"data"=>$data,
							
						]
			]
		);exit;
?>