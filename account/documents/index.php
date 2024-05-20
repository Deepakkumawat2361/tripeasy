<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";

require "$_SERVER[DOCUMENT_ROOT]/secure.php";
$path = $_SERVER["DOCUMENT_ROOT"];
$desk_navbar = $mob_navbar= '';


// echo "<pre>"; print_r($userData); exit;
$adfr='/tripeasy/assets/images/addhar-front.png';
$adbc='/tripeasy/assets/images/addhar-back.png';
$lcfr='/tripeasy/assets/images/drivingr-front.png';
$lcbc='/tripeasy/assets/images/drivingr-front.png';
$adrBtn = 'block';
$lncBtn = 'block';
$checking = $connect->query("SELECT * FROM user_docs WHERE user_id={$userData->id}") OR die($connect->error);
if($checking->num_rows > 0){
	$row = $checking->fetch_object();
	if($row->adhaar_front){
		$adfr = $row->adhaar_front;
	}
	if($row->adhaar_back){
		$adbc = $row->adhaar_back;
	}
	if($row->license_front){
		$lcfr = $row->license_front;
	}
	if($row->license_back){
		$lcbc = $row->license_back;
	}
	if($row->adhaar_back && $row->adhaar_front){
		$adrBtn = 'none';
	}
	if($row->license_front && $row->license_back){
		$lncBtn = 'none';
	}
}
$userDocs = '
	<div class="col-md-9">
            <div class="dashboard_inner_right">
              <h5>Upload Document
              </h5>
               <div class="document_upload_section">
                  <div class="document_upload_inner_section">
                    <h6>Addhar Card</h6>
                    <input type="text" class="form-control" placeholder="Enter Addhar Number">
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <span>Addhar Card Front</span>
                        <div class="document_upload_inner_section_top">
                          <input type="file" class="d-none" id="doc1Field">
                          <div class="document_upload_img">
                            <img src="/tripeasy/'.$adfr.'" alt="img" id="doc1Preview">
                          </div> 
                          <ul class="image_card_icon" style="display: '.$adrBtn.'">
                            <li>
                              <button class="btn btn-info" onclick="$(\'#doc1Field\').click();">Upload</button>
                            </li>
                         </ul>                          
                        </div>
                        
                     </div>
                     <div class="col-md-6">
                      <span>Addhar Card Back</span>
                      <div class="document_upload_inner_section_top">
                        <input type="file" class="d-none" id="doc12Field">
                        <div class="document_upload_img">
                          <img src="/tripeasy/'.$adbc.'" alt="img" id="doc12Preview">
                        </div>
                        <ul class="image_card_icon" style="display: '.$adrBtn.'">
                          <li>
                             <button class="btn btn-info" onclick="$(\'#doc12Field\').click();">Upload</button>
                          </li>
                       </ul>                        
                      </div>
                   </div>                     
                  </div>

               </div>
                <div class="document_upload_section">
                  <div class="document_upload_inner_section">
                    <h6>License Card</h6>
                    <input type="text" class="form-control" placeholder="Enter License Number">
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <span>License Card Front</span>
                        <div class="document_upload_inner_section_top">
                          <input type="file" class="d-none" id="doc2Field">
                          <div class="document_upload_img">
                            <img src="/tripeasy/'.$lcfr.'" alt="img" id="doc2Preview">
                          </div>
                          <ul class="image_card_icon" style="display: '.$lncBtn.'">
                            <li>
                                <button class="btn btn-info" onclick="$(\'#doc2Field\').click();">Upload</button>
                            </li>
                            <li>
                              <a href="javascript:void(0)">Delete</a>
                          </li>
                        </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <span>License Card Back</span>
                      <div class="document_upload_inner_section_top">
                        <input type="file" class="d-none" id="doc22Field">
                        <div class="document_upload_img">
                          <img src="/tripeasy/'.$lcbc.'" alt="img" id="doc22Preview">
                        </div>
                        <ul class="image_card_icon" style="display: '.$lncBtn.'">
                            <li>
                                <button class="btn btn-info" onclick="$(\'#doc22Field\').click();">Upload</button>
                            </li>
                            <li>
                              <a href="javascript:void(0)">Delete</a>
                          </li>
                        </ul>
                      </div>
                  </div>                     
                </div>
                <div class="document_upload_section">
                  <div class="document_upload_inner_section">
                    <h6>Upload Selfi</h6>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="document_upload_inner_section_top">
                          <input type="file" class="d-none" id="doc2Field">
                          <div class="document_upload_img">
                            <img src="https://tripeasy.in/assets/images/upload_selfi.png" alt="img" id="doc2Preview">
                          </div>
                          <ul class="image_card_icon" style="display: '.$lncBtn.'">
                            <li>
                              <button class="btn btn-info" onclick="$(\'#doc2Field\').click();">Upload</button>
                            </li>
                            <li>
                              <a href="javascript:void(0)">Delete</a>
                          </li>
                        </ul>
                        </div>
                    </div>
                              
                </div>



              </div>
            </div>
          </div>';


if(isset($_POST["update"])){
	$post = $_POST;
	$name = addslashes($post["name"]);
	$email = addslashes($post["email"]);
	$mobile = addslashes($post["mobile"]);
	$address = addslashes($post["address"]);
	$dob = addslashes($post["dob"]);
	$connect->query("UPDATE users SET dob='$dob', name='$name', email='$email', mobile='$mobile', address='$address' WHERE id={$userData->id}") OR die($connect->error);
	header("location:/account/profile"); exit;
}

$output = file_get_contents("index_tpl.html");
$header = file_get_contents($path . "/layouts/header.html");
$footer = file_get_contents($path . "/layouts/footer.html");
$glinks = file_get_contents($path . "/layouts/global-links.html");
$gscripts = file_get_contents($path . "/layouts/global-scripts.html");

$out_arr["header"] = $header;
$out_arr["footer"] = $footer;
$out_arr["userDocs"] = $userDocs;
$out_arr["globLinks"] = $glinks;
$out_arr["globalScripts"] = $gscripts;
$out_arr["userName"] = $userData->name ?? "";
$out_arr["userEmail"] = $userData->email ?? "";
$out_arr["userMobile"] = $userData->mobile;
$out_arr["userAddress"] = $userData->address ?? "";
$out_arr["dob"] = $userData->dob ?? "";
$out_arr["created"] = date("Y-m-d",$userData->created) ?? "";
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
 