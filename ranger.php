<!DOCTYPE html>
<html>
<body>

<?php
$ckey = "TripEasySecure%$%k3Y";
echo decrypt("pJB5aZSYvt+owH2svsuojw==");

function cryp(){
	global $ckey;
	$keys = array();
	$c_key = base64_encode(sha1(md5($ckey)));
	$c_key = substr($c_key, 0, round(ord($ckey[0])/5));

	$c2_key = base64_encode(md5(sha1($ckey)));
	$last = strlen($ckey) - 1;
	$c2_key = substr($c2_key, 1, round(ord($ckey[$last])/7));

	$c3_key = base64_encode(sha1(md5($c_key).md5($c2_key)));
	$mid = round($last/2);
	$mid =  $last;
	$c3_key = substr($c3_key, 1, round(ord($ckey[$mid])/9));

	$c_key = $c_key.$c2_key.$c3_key;
	$c_key = base64_encode($c_key);

	for($i = 0; $i < strlen($c_key); $i++){
		$keys[] = $c_key[$i];
	}
	return $keys;
}


function decrypt($string){

	$string = base64_decode($string);

	$keys = cryp();
	

	for($i = 0; $i < strlen($string); $i++){

		$id = $i % count($keys);

		$ord = ord($string[$i]);

		$ord = $ord XOR ord($keys[$id]);

		$id++;

		$ord = $ord AND ord($keys[$id]);

		$id++;

		$ord = $ord OR ord($keys[$id]);

		$id++;

		$ord = $ord - ord($keys[$id]);

		$string[$i] = chr($ord);

	}

	return base64_decode($string);

}

?>

</body>
</html>
