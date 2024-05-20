<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

//echo "sdfs"; exit;
include_once("$_SERVER[DOCUMENT_ROOT]/connect.php");
header('Content-Type: text/html; charset=UTF-8');

$sql = "insert into coupons set code = 0";
$connect->query($sql);
$id = $connect->insert_id;
if($id)
{
	header("location:/tripeasy/master_panel/coupons/edit/?id=".$id);exit;
}else{
	header("location:/tripeasy/master_panel/coupons/");exit;
}

?>