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

if(isset($_FILES)){

	if(isset($_FILES['image']['name']) && $_FILES['image']['name']){
			
		$image      =  $_FILES['image']['name'];
		$file_name  = "/uploads/vehicle/".time().".jpeg";
		$path       = "$_SERVER[DOCUMENT_ROOT]".$file_name;
		$image_ext  = pathinfo($image , PATHINFO_EXTENSION);
		
		move_uploaded_file($_FILES['image']['tmp_name'], $path);
	
   }

  $sql1      = "SELECT images from car_details WHERE id = '$id'"; 
  $runquery1 = $connect->query($sql1);
  $row1      = $runquery1->fetch_object();
  if($row1->images){
	  $image     = $row1->images.",".$file_name;
  }else{
	  $image     = $file_name;
  }
  

  $sql = "UPDATE car_details SET images = '$image' WHERE id = '$id'";
  $run_query = $connect->query($sql);
 

  $data = []; 
  $sql2      = "SELECT images from car_details WHERE id = '$id'"; 
  $runquery2 = $connect->query($sql2);
  $row       = $runquery2->fetch_object();
  
   if($row)
   {
	   $data = explode(",",$row->images);
   }
   
  
	 echo json_encode(
			[
			"response"=>[
							
							 
							"status"=>"success",
							"message"=>"Succesfully Updated",
							"data"=>$data,
							
						]
			]
		);exit;
   }else{
	   echo json_encode(
			[
			"response"=>[
							
							 
							"status"=>"error",
							"message"=>"Something went Wronge",
							"data"=>[],
							
						]
			]
		);exit;
   }  
   
 
?>