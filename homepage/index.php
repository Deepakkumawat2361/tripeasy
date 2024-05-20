<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
//include_once "$_SERVER[DOCUMENT_ROOT]/user_auth.php";
$path = $_SERVER["DOCUMENT_ROOT"];
$desk_navbar = $mob_navbar= '';
if(isset($_COOKIE['seller_auth']) && $_COOKIE['seller_auth'])
{
	$desk_navbar .= '<a href="/signup/vendor/" class="navbar-cta"><span>My Florist Account</span></a>';
	
	$mob_navbar .= '<li class="navbar-menu-item"><a href="/signup/vendor/" class="navbar-cta"><span>My Florist Account</span></a></li>';
 
}else{
	$desk_navbar .= '<a href="/add-business/" class="navbar-cta"><span>Add business</span></a>';
	
	$mob_navbar .= '<li class="navbar-menu-item"><a href="/add-business/" class="navbar-cta"><span>Add business</span></a></li>';
 
}
 

if(isset($_COOKIE['user_access']) && $_COOKIE['user_access'])
{
	$desk_navbar .= '<a href="/signup/customer/" class="navbar-cart">Account</a>';
	$desk_navbar .= '<a href="#" class="navbar-cart" data-toggle="modal" data-target="#cart-modal"><i class="ri-shopping-cart-2-line"></i></a>';
	
	$mob_navbar = '<li class="navbar-menu-item"><a href="/account/customer/order/" class="navbar-cta"><span>Account</span></a></li>
                   <li class="navbar-menu-item"><a href="#">Logout</a></li>
                   <li class="navbar-menu-item"><a href="#" class="navbar-account" data-toggle="modal" data-target="#cart-modal"><i class="ri-shopping-cart-2-line"></i></a></li>';
}else{
	$desk_navbar .= '<a href="/signup/customer/" id="user_panel" class="navbar-account"><span id="user_panel_text" >For Customers</span></a>';
	$desk_navbar .= '<a href="#" class="navbar-cart" data-toggle="modal" data-target="#cart-modal"><i class="ri-shopping-cart-2-line"></i></a>';
	
	$mob_navbar  .= '<li class="navbar-menu-item"><a href="/account/customer/order/" class="navbar-account"><span>For Customers</span></a </li>
                     <li class="navbar-menu-item"><a href="#" class="navbar-account" data-toggle="modal" data-target="#cart-modal"><i class="ri-shopping-cart-2-line"></i></a></li>';
	 
}
 

$header = file_get_contents($path . "/header-footer/header.php");
$footer = file_get_contents($path . "/header-footer/footer.php");



$output = file_get_contents("index.html");
$out_arr["header"] = $header;
$out_arr["footer"] = $footer;
$out_arr["desk_navbar"] = $desk_navbar;
$out_arr["mob_navbar"] = $mob_navbar;
$out_arr["postcode"] = strtoupper(str_replace("-",' ',$_COOKIE['postcode']));
$out_arr["postcode_value"] = strtolower(str_replace(" ",'-',$_COOKIE['postcode']));

include_once "$path/web_template.php";
//print_R($out_arr);exit;
 
foreach ($out_arr as $outKey => $outVal) {
    $output = str_replace("{" . $outKey . "}", $outVal, $output);
}
echo minifier($output);
function minifier($code)
{
	return $code;
    $search = ["/\>[^\S ]+/s", "/[^\S ]+\</s", "/(\s)+/s", "/<!--(.|\s)*?-->/"];
    $replace = [">", "<", '\\1'];
    $code = preg_replace($search, $replace, $code);
    return $code;
} ?>
 