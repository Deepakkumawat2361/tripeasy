<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
header('Content-type: application/json; charset=UTF-8');

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

$errors=[];

if(!$name){
	$errors['name'] ="name required";
}

if(!$description){
	$errors['description'] ="description required";
}



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

if(isset($_POST["name"])){
	
   $insert['name']= addslashes($_POST["name"]);
    $insert['description']= addslashes($_POST["description"]);
    
  

   array_walk($insert,function (&$v, $k) {$v = "{$k}='{$v}'";});
    $sql = implode(',',$insert);
   
  $sql = "UPDATE testinomails SET {$sql} WHERE id = '$id'";	
  
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