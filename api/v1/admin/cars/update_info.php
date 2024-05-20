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

if(isset($_POST)){
	 //print_r($_FILES); exit;
	 
	foreach($_POST as $k=>$v){
        $insert[$k]= addslashes($v);
	}
    
	if(isset($_FILES['image']['name']) && $_FILES['image']['name']){
			
		$image      =  $_FILES['image']['name'];
		$file_name  = "/uploads/vehicle/".time().".jpeg";
		$path       = "$_SERVER[DOCUMENT_ROOT]".$file_name;
		$image_ext  = pathinfo($image , PATHINFO_EXTENSION);
		$filename1  = uniqid().time().'.'.$image_ext;
		$insert['image'] = $file_name;	
		move_uploaded_file($_FILES['image']['tmp_name'] , $path);
	
   }
	
   array_walk($insert,function (&$v, $k) {$v = "{$k}='{$v}'";});
   $sql = implode(',',$insert);
   
   $sql = "UPDATE car_details SET {$sql} WHERE id = '$id'";
  
  $run_query = $connect->query($sql);
   if($run_query){
	 echo json_encode(
			[
			"response"=>[
							
							 
							"status"=>"success",
							"message"=>"Succesfully Updated",
							"data"=>[],
							
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