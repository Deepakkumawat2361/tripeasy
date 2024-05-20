<?php
//echo "sdfs"; exit;
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
include_once("$_SERVER[DOCUMENT_ROOT]/connect_db.php");
header('Content-Type: text/html; charset=UTF-8');
$sql = $connect->query(" select * from cars where status = 0 limit  1");
if($sql->num_rows==0)
{
	$connect->query("insert into cars set price = 0");
	$id = $connect->insert_id;
}else{
	$id  = $sql->fetch_object()->id;
}
 

if($id)
{
	header("location:/tripeasy/master_panel/vehicle/edit/?id=".$id);exit;
}else{
	header("location:/tripeasy/master_panel/vehicle/");exit;
}

?>