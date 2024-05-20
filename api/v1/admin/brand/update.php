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
	
	//print_r($_FILES); exit;
	
   $insert['name']       = addslashes($_POST["name"]);
   //$insert['image_hide'] = addslashes($_POST["image_hide"]);
   
   // image upload
    if($_POST["image_hide"]){
        
        $img = addslashes($_POST["image_hide"]);		
	    $image_array_1 = explode(";", $img);
	    $image_array_2 = explode(",", $image_array_1[1]);
	    $image_name         = base64_decode($image_array_2[1]);
				
				
	    $file_name = "/uploads/brands/".time().".jpeg";
		$imageName     = "$_SERVER[DOCUMENT_ROOT]".$file_name;
		file_put_contents($imageName, $image_name);
		$insert['image'] = $file_name;
		
      }


    array_walk($insert,function (&$v, $k) {$v = "{$k}='{$v}'";});
    $sql = implode(',',$insert);
   
  $sql = "UPDATE brands SET {$sql} WHERE id = '$id'";	
  
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