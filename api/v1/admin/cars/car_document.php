<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
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

$id  = $_GET["id"];
include_once("$_SERVER[DOCUMENT_ROOT]/connect.php"); 

$result = $connect->query("select * from car_details  WHERE id = '$id' limit  1 ");

if($result->num_rows > 0)
{
	 
		$data = $result->fetch_assoc();

} 

echo json_encode(
			[
			"response"=>[
							
							 
							"status"=>"success",
							"message"=>"Succesfully listed",
							"data"=>$data,
							
						]
			]
		);exit;
?>