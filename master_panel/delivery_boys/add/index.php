<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

//echo "sdfs"; exit;
include_once("$_SERVER[DOCUMENT_ROOT]/connect.php");
header('Content-Type: text/html; charset=UTF-8');

$sql = "insert into delivery_boys set name = 0";
$connect->query($sql);
$id = $connect->insert_id;
if($id)
{
	header("location:/tripeasy/master_panel/delivery_boys/edit/?id=".$id);exit;
}else{
	header("location:/tripeasy/master_panel/delivery_boys/");exit;
}

?>