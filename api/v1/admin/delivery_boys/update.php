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
		$insert['name']= addslashes($_POST["name"]);
		$insert['email']= addslashes($_POST["email"]);
		$insert['mobile']= addslashes($_POST["mobile"]);
		$insert['address']= addslashes($_POST["address"]);
		$insert['password']= password_hash(addslashes($_POST["password"]), PASSWORD_DEFAULT);
		$insert['pass_code']= addslashes($_POST["password"]);
		if(isset($_FILES["image"]["name"]) && $_FILES["image"]["name"]){
			$insert['image'] = "/uploads/delivery_boy/".time().$insert['name'].".jpg";
			move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].$insert['image']);
		}
		if(isset($_POST["join_date"]) && $_POST["join_date"]){
			$insert["join_date"] = date("Y-m-d H:i:s", strtotime($_POST["join_date"]));
		}
		if(isset($_POST["resign_date"]) && $_POST["resign_date"]){
			$insert["resign_date"] = date("Y-m-d H:i:s", strtotime($_POST["resign_date"]));
		}
		
	   array_walk($insert,function (&$v, $k) {$v = "{$k}='{$v}'";});
	   $sql = implode(',',$insert);
	   
	   $sql = "UPDATE delivery_boys SET {$sql} WHERE id = '$id'";	
	  
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