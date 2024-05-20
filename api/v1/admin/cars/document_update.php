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
if(isset($_FILES["image"])){

	if(isset($_FILES['image']['name']) && $_FILES['image']['name']){
			
		$image      =  $_FILES['image']['name'];
		$file_name  = "/uploads/documentsrc/".time().".jpeg";
		$path       = "$_SERVER[DOCUMENT_ROOT]".$file_name;
		$image_ext  = pathinfo($image , PATHINFO_EXTENSION);
		
		move_uploaded_file($_FILES['image']['tmp_name'], $path);
	
   }

  $sql = "UPDATE car_details SET registration_certificate = '$file_name' WHERE id = '$id'";
  $run_query = $connect->query($sql);
 

  $data = []; 
  $sql2      = "SELECT registration_certificate from car_details WHERE id = '$id'"; 
  $runquery2 = $connect->query($sql2);
  $data       = $runquery2->fetch_object();
  //$data->registration_certificate = "/uploads/documentsrc/".$data->registration_certificate;
  
  if($data){
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
  }
   
 


   
	
   
 
?>