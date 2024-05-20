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

if(!$segment){
	$errors['segment'] ="segment required";
}

if(!$model){
	$errors['model'] ="model required";
}

if(!$fuel){
	$errors['fuel'] ="fuel required";
}

if(!$seater){
	$errors['seater'] ="seater required";
}

 

if(!$transmission){
	$errors['transmission'] ="transmission required";
}
if(!$price){
	$errors['price'] ="price required";
}
if(!$extra_km_charge){
	$errors['extra_km_charge'] ="price required";
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

$sql = $connect->query(" select * from cars where id = $id limit  1");

if($sql->num_rows==0)
{
	echo json_encode(
			[
			"response"=>[
							"data"=>[],
							"status"=>"error",
							"message"=>"validation error",
							'errors'=>[]
						]
			]
		);exit;
}
$data = $sql->fetch_object();

if(isset($_POST)){
	
   $insert['name']= addslashes($_POST["name"]);
   $insert['location']= addslashes($_POST["location"]);
   $insert['segment']= addslashes($_POST["segment"]);
   $insert['model']= addslashes($_POST["model"]);
   $insert['fuel']= addslashes($_POST["fuel"]);
   $insert['seater']= addslashes($_POST["seater"]);
   $insert['delivery_boy_id']= addslashes($_POST["delivery_boy_id"]); 
   
   if(!$data->slug)
   {
	   $insert['slug']=slug(addslashes($_POST["name"]));
   }
 
  
   $insert['transmission']= addslashes($_POST["transmission"]);
   $insert['unlimited_price']= addslashes($_POST["unlimited_price"]);
   $insert['price']= addslashes($_POST["price"]);
   $insert['extra_km_charge']= addslashes($_POST["extra_km_charge"]);
   
        if(isset($_FILES['image']['name']) && $_FILES['image']['name']){
			
			$image      =  $_FILES['image']['name'];
			$file_name = "/uploads/vehicle/".time().".jpeg";
			$path     = "$_SERVER[DOCUMENT_ROOT]".$file_name;

			$image_ext  = pathinfo($image , PATHINFO_EXTENSION);
			$filename1  = uniqid().time().'.'.$image_ext;
			$insert['image'] = $file_name;	
			move_uploaded_file($_FILES['image']['tmp_name'] , $path);
			
		}


   array_walk($insert,function (&$v, $k) {$v = "{$k}='{$v}'";});
    $sql = implode(',',$insert);
   
    $sql = "UPDATE cars SET {$sql} WHERE id = '$id'";  
  
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

function slug($string) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    $slug = preg_replace('/-+/', '-', $slug);
    return $slug;
}

?>