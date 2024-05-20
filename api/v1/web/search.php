<?php
header("Content-Type: application/json");
$error=[];
if(!$_POST['location'])
{
	$error['location'] = "Location required";
}
if(!$_POST['start_date'])
{
	$error['start_date'] = "start_date required";
}
if(!$_POST['start_time'])
{
	$error['start_time'] = "start_time required";
}
if(!$_POST['end_date'])
{
	$error['end_date'] = "end_date required";
}
if(!$_POST['start_time'])
{
	$error['end_time'] = "end_time required";
}

if($error)
{
	echo json_encode(['status'=>'error','errors'=>$error]);exit;
}


$location  = strtolower($_POST['location']);
$start_time  = strtotime($_POST['start_date'].' '.$_POST['start_time']);
$end_time  = strtotime($_POST['end_date'].' '.$_POST['end_time']);


if($start_time > $end_time)
{
	echo json_encode(['status'=>'timeing','errors'=>"Start time can't be grater to end time."]);exit;
}

$date1 = new DateTime(date("Y-m-d H:00:00",$start_time));
$date2 = new DateTime(date("Y-m-d H:00:00",$end_time));


$interval = $date1->diff($date2);
$hours = $interval->h + ($interval->days * 24);

if($hours < 24)
{
	echo json_encode(['status'=>'timeing','errors'=>"Please select minimum 24 hours booking duration."]);exit;
}
 

echo json_encode(['status'=>'success','redirect'=>"/tripeasy/car-rental-in-{$location}?start=$start_time&end=$end_time"]);exit;
?>