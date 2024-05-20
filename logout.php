<?php
unset($_COOKIE["user_access"]);
setcookie("user_access", "", time() -1,  "/" ,  "".$_SERVER['SERVER_NAME']);
unset($_COOKIE["user_mobile"]);
setcookie("user_mobile", "", time() -1,  "/" ,  "".$_SERVER['SERVER_NAME']);
header("location:/tripeasy/login");
?>