<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
header('Content-type: application/json; charset=UTF-8');
$errors =[];
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
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
extract($_POST);
 
 

if($errors){ 
    echo json_encode(
			[
			"response"=>[
							"data"=>[],
							"status"=>"error",
							"message"=>"validation error",
							'errors'=>$errors
						]
			]
		);exit;
}


include_once("$_SERVER[DOCUMENT_ROOT]/connect.php");

if(!$_POST){
	$_POST =  json_decode( file_get_contents('php://input'),true);
}
header('Content-type: application/json; charset=UTF-8');


$id   = addslashes($_GET["id"]);
$result = $connect->query("select images from car_details  WHERE id = '$id' limit  1 ");
$data = $result->fetch_object();

$image = $data->images;
//unset($image[])