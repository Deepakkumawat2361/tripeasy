<?php
makeAdminLogout();
header("Location:/tripeasy/delivery-boy");
function makeAdminLogout(){
	session_unset();
	session_destroy();
	setcookie("delivery_acces_token", "", time()-1, "/");
	unset($_COOKIE["delivery_acces_token"]);
}
?>