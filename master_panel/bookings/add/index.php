<?php
//echo "sdfs"; exit;
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
include_once("$_SERVER[DOCUMENT_ROOT]/connect_db.php");
header('Content-Type: text/html; charset=UTF-8');

$sql = "insert into cars set price = 0";
$connect->query($sql);
$id = $connect->insert_id;
if($id)
{
	header("location:/tripeasy/master_panel/vehicle/edit/?id=".$id);exit;
}else{
	header("location:tripeasy/master_panel/vehicle/");exit;
}

?>