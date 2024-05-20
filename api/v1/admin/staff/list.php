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
 


$result = $connect->query("select * FROM staff");

if($result->num_rows>0)
{
	while($row = $result->fetch_assoc())
	{
	
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