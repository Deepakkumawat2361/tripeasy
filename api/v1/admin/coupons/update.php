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

if(!$code){
	$errors['code'] ="Code required";
}
if(!$discount_amount){
	$errors['discount_amount'] ="discount_amount required";
}
if($discount_type == 'percentage'){
	if($discount_amount > 100){
	$errors['discount_amount'] ="Discount Amount Greater-than 100";
	}
}
if(!$discount_type){
	$errors['discount_type'] ="discount_type required";
}
if(!$minimum_amount){
	$errors['minimum_amount'] ="minimum_amount required";
}
if(!$start_date){
	$errors['start_date'] ="start_date required";
}
if(!$discount_amount){
	$errors['end_date'] ="end_date required";
}
if(!$status){
	$errors['status'] ="status required";
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

	if(isset($_POST["code"])){
		$insert['code']= addslashes($_POST["code"]);
		$insert['discount_amount']= addslashes($_POST["discount_amount"]);
		$insert['discount_type']= addslashes($_POST["discount_type"]);
		$insert['minimum_amount']= addslashes($_POST["minimum_amount"]);
		$insert['start_date']= addslashes($_POST["start_date"]);
		$insert['end_date']= addslashes($_POST["end_date"]);
		$insert['status']= addslashes($_POST["status"]);
		$insert['user_id']= addslashes($_POST["user_id"]);
		
		
	   array_walk($insert,function (&$v, $k) {$v = "{$k}='{$v}'";});
	   $sql = implode(',',$insert);
	   
	   $sql = "UPDATE coupons SET {$sql} WHERE id = '$id'";	
	  
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
	}else{
		echo "Invalid Action"; exit;
	}
?>