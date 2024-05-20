<?php
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

	include_once("$_SERVER[DOCUMENT_ROOT]/connect.php"); 
	extract($_REQUEST);
	
	$search = '';
	if(isset($_REQUEST['search_array']))
	{
		$search_array = $_REQUEST['search_array'];
		if(isset($search_array['segment']))
		{
			if(count($search_array['segment'])<3)
			{
					array_walk($search_array['segment'],function (&$v, $k) {$v = " segment ='{$v}'";});
                    $search .= " and  ( ".implode(' or ',$search_array['segment'])." ) ";
				 
			}
		}
		if(isset($search_array['fuel']))
		{
			if(count($search_array['fuel'])<2)
			{
				array_walk($search_array['fuel'],function (&$v, $k) {$v = " fuel ='{$v}'";});
                $search .= " and  ( ".implode(' or ',$search_array['fuel'])." ) ";
			}
		}
		if(isset($search_array['transmission']))
		{
			if(count($search_array['transmission'])<2)
			{
				array_walk($search_array['transmission'],function (&$v, $k) {$v = " transmission ='{$v}'";});
                $search .= " and  ( ".implode(' or ',$search_array['transmission'])." ) ";
			}
		}
		if(isset($search_array['seater']))
		{
			array_walk($search_array['seater'],function (&$v, $k) {$v = " seater ='{$v}'";});
            $search .= " and  ( ".implode(' or ',$search_array['seater'])." ) ";
		}
	}
	 
	
	$time = time();
	$date1 = new DateTime(date("Y-m-d H:00:00",$start));
	$date2 = new DateTime(date("Y-m-d H:00:00",$end));


	$interval = $date1->diff($date2);
	$hours = $interval->h + ($interval->days * 24);
	
	
	
	$sql = "select * FROM cars WHERE status = 1 {$search} ";
	$result = $connect->query($sql);
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
			$row['booking_id'] = $row['id'].$time;
			$row['price'] = $row['price']*$hours;
			$row['unlimited_price'] = $row['unlimited_price']*$hours;
			$data[] = $row;
		}
	}else{
		$data=[];
	}
	echo json_encode(
		[
		"response"=>[

				"page"=>$page??null,
				"status"=>"success",
				"message"=>"Car List Retrived Successfully !",
				"data"=>$data,
				"hours"=>$hours,
			]
		]
	);exit;
?>