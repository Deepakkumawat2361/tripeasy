<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

include_once("$_SERVER[DOCUMENT_ROOT]/connect_db.php");

if(!$_POST){
	$_POST =  json_decode( file_get_contents('php://input'),true);
}
header('Content-type: application/json; charset=UTF-8');

//print_r($_POST); exit;
//print_r($_FILES); exit;

if(isset($_POST["name"])){
	
  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 1);
  error_reporting(-1);
	
  $name = $_POST["name"];
  $segment = $_POST["segment"];
  $model = $_POST["model"];
  $fuel = $_POST["fuel"];
  $seater = $_POST["seater"];
  $model_month = $_POST["model_month"];
  $model_year = $_POST["model_year"];
  $transmission = $_POST["transmission"];
  $price = $_POST["price"];
  
  $image             =  $_FILES['car_image']['name'];
  $path      = "uploads/cars";
  $image_ext = pathinfo($image , PATHINFO_EXTENSION);
  $filename1  = uniqid().time().'.'.$image_ext;	
  move_uploaded_file($_FILES['car_image']['tmp_name'] , $path.'/'.$filename1);
  
  // image section
  
  
 $sql = "INSERT INTO cars(name,segment,model,fuel,seater,transmission,model_month,
                        model_year,price,image)
						
		VALUES('$name','$segment','$model','$fuel','$seater','$model_month','$model_year','$transmission','$price','$filename1')";
		
  $run_query = $connect->query($sql);
   if($run_query){
	  echo json_encode(['status'=> 'yes' ,'message'=>'Car Add Successfully']);
   }else{
	   echo json_encode(['status'=> 'not_exits']);
   }
} 
?>