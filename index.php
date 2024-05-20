<?php 
$_SERVER['DOCUMENT_ROOT']="D:/wamp/www/tripeasy";
require "$_SERVER[DOCUMENT_ROOT]/connect.php";
$path = $_SERVER["DOCUMENT_ROOT"];

$carsHtml='';



//Getting cars Data :: Start
$res = $connect->query("SELECT * FROM cars WHERE status = 1 ORDER BY id DESC") OR die($connect->error);
while($row = $res->fetch_object()){
	$carsHtml.='
			<div class="item">
				<div class="vehicle-content theme-yellow">
					<div class="vehicle-thumbnail">
						<a href="#">
						<img src="/tripeasy/'.$row->image.'" alt="car-item" style="height: 200px; width:300px;" />
						</a>
					</div>
					<div class="vehicle-bottom-content">
						<div class="car-name-rating">
							<h2 class="vehicle-title"><a href="#">'.$row->name.'</a></h2>
							<div class="car-rating">
								<div class="list-rating">
									<i class="fa fa-star filled"></i>
									<i class="fa fa-star filled"></i>
									<i class="fa fa-star filled"></i>
									<i class="fa fa-star filled"></i>
									<i class="fa fa-star filled"></i>
								</div>
							</div>
						</div>
						<div class="listing-details-group">
							<ul>
								<li>
									<span><img src="assets/images/car-item/p-1.svg" alt="car-item" /></span>
									<p>'.ucfirst($row->transmission).'</p>
								</li>
								<li>
									<span><img src="assets/images/car-item/p-2.svg" alt="car-item" /></span>
									<p>22 KM</p>
								</li>
								<li>
									<span><img src="assets/images/car-item/p-3.svg" alt="car-item" /></span>
									<p>'.ucfirst($row->fuel).'</p>
								</li>
							</ul>
							<ul>
								<li>
									<span><img src="assets/images/car-item/p-4.svg" alt="car-item" /></span>
									<p>'.ucfirst($row->fuel).'</p>
								</li>
								<li>
									<span><img src="assets/images/car-item/p-5.svg" alt="car-item" /></span>
									<p>'.$row->model.'</p>
								</li>
								<li>
									<span><img src="assets/images/car-item/p-6.svg" alt="car-item" /></span>
									<p>'.$row->seater.' Persons</p>
								</li>
							</ul>
						</div>
						<div class="car-vehicle-meta">
							<div class="meta-item text-danger">
								<span>Rent: ₹'.$row->price.' / </span>Hr.
							</div>
							<div class="btn-area">
								<a class="button-2 red-bg w-100" href="#">Book Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
	';
}



$regularCars='';
//Getting cars Data :: Start
$res = $connect->query("SELECT * FROM cars WHERE status = 1 ORDER BY id ASC") OR die($connect->error);
while($row = $res->fetch_object()){
	$regularCars.='
			<div class="item">
				<div class="vehicle-content theme-yellow">
					<div class="vehicle-thumbnail">
						<a href="#">
						<img src="/tripeasy/'.$row->image.'" alt="car-item" style="height: 200px; width:300px;" />
						</a>
					</div>
					<div class="vehicle-bottom-content">
						<div class="car-name-rating">
							<h2 class="vehicle-title"><a href="#">'.$row->name.'</a></h2>
							<div class="car-rating">
								<div class="list-rating">
									<i class="fa fa-star filled"></i>
									<i class="fa fa-star filled"></i>
									<i class="fa fa-star filled"></i>
									<i class="fa fa-star filled"></i>
									<i class="fa fa-star filled"></i>
								</div>
							</div>
						</div>
						<div class="listing-details-group">
							<ul>
								<li>
									<span><img src="assets/images/car-item/p-1.svg" alt="car-item" /></span>
									<p>'.ucfirst($row->transmission).'</p>
								</li>
								<li>
									<span><img src="assets/images/car-item/p-2.svg" alt="car-item" /></span>
									<p>22 KM</p>
								</li>
								<li>
									<span><img src="assets/images/car-item/p-3.svg" alt="car-item" /></span>
									<p>'.ucfirst($row->fuel).'</p>
								</li>
							</ul>
							<ul>
								<li>
									<span><img src="assets/images/car-item/p-4.svg" alt="car-item" /></span>
									<p>'.ucfirst($row->fuel).'</p>
								</li>
								<li>
									<span><img src="assets/images/car-item/p-5.svg" alt="car-item" /></span>
									<p>'.$row->model.'</p>
								</li>
								<li>
									<span><img src="assets/images/car-item/p-6.svg" alt="car-item" /></span>
									<p>'.$row->seater.' Persons</p>
								</li>
							</ul>
						</div>
						<div class="car-vehicle-meta">
							<div class="meta-item text-danger">
								<span>Rent: ₹'.$row->price.' / </span>Hr.
							</div>
							<div class="btn-area">
								<a class="button-2 red-bg w-100" href="#">Book Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
	';
}


$hotelList='';
for($i=1;$i<4;$i++){
	$hotelList.='
				<div class="item">
					<div class="driver-content vehicle-content theme-yellow">
						<div class="driver-thumb vehicle-thumbnail">
							<a href="#">
							<img src="assets/images/driver/h-'.$i.'.jpg" alt="hotel" />
							</a>
						</div>
						<div class="hotel-card-content">
							<div class="hotel-name-rating">
								<h2 class="hotel-name">
									<a href="#">Ocean View </a>
								</h2>
								<div class="list-rating">
									<i class="fa fa-star filled"></i>
									<i class="fa fa-star filled"></i>
									<i class="fa fa-star filled"></i>
									<i class="fa fa-star filled"></i>
									<i class="fa fa-star filled"></i>
								</div>
							</div>
							<ul class="hotel-blog-meta">
								<li>
									<i class="fa fa-bed"></i>
									<a href="#">Adults : 5</a>
								</li>
								<li>
									<i class="fa fa-square"></i>
									<a href="#">Size : 59ft</a>
								</li>
							</ul>
							<p>Vel minus doloremque deleniti veniam qui praesentium?</p>
							<div class="room-price">
								<h5>Price : $50.00<span>/per night</span></h5>
							</div>

						</div>
					</div>
				</div>
	';
}




$clientReviews='';
for($i=1;$i<20;$i++){
	$clientReviews.='
				<div class="owl-item cloned" style="width: 360px; margin-right: 30px">
					<div class="item">
						<div class="client-detales">
							<h3 class="client-title">Ajay Kumar</h3>
							<p class="discription">
									Hi Friends, I booked a Car Ertiga for Shimla Manali tour & I got very good services.Thanks to all Team for providing us a great memorable Shimla Manali tour.
							</p>
							<div class="star">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star-half-o"></i>
							</div>
							<a href="javascript:void(0)" class="google_rating">
							  View Google Rating
							</a>
						</div>
					</div>
				</div>

				<div class="owl-item cloned" style="width: 360px; margin-right: 30px">
					<div class="item">
						<div class="client-detales">
							<h3 class="client-title"> Ravi Komal</h3>
							<p class="discription">
							It was a wonderful experience to travel with Grand Ride.. We went to Kasauli in Crystal (self-driven). The car was clean. The rates were affordable. I have used this car rental service more than twice and have always found it convenient.
							</p>
							<div class="star">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star-half-o"></i>
							</div>
							<a href="javascript:void(0)" class="google_rating">
								View Google Rating
							</a>
						</div>
					</div>
			 </div>

			 <div class="owl-item cloned" style="width: 360px; margin-right: 30px">
				<div class="item">
					<div class="client-detales">
						<h3 class="client-title">Handcrafts Creations</h3>
						<p class="discription">
						I took the car for 17 days from the Connaught Place location and the service was extremely good. The car was pretty new and ran smoothly. It the second time I took their service and I really appreciate their quality service.</p>
						<div class="star">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-half-o"></i>
						</div>
						<a href="javascript:void(0)" class="google_rating">
							View Google Rating
						</a>
					</div>
			  </div>
		   </div>

			 <div class="owl-item cloned" style="width: 360px; margin-right: 30px">
			 <div class="item">
				 <div class="client-detales">
					 <h3 class="client-title">Gunjan Sony</h3>
					 <p class="discription">
					 I had very good experience self driver I piked the car airport for vacation in Delhi. In fact tried again for same. good customer support and experience. good service for traveler.

					 </p>
					 <div class="star">
						 <i class="fa fa-star"></i>
						 <i class="fa fa-star"></i>
						 <i class="fa fa-star"></i>
						 <i class="fa fa-star"></i>
						 <i class="fa fa-star-half-o"></i>
					 </div>
					 <a href="javascript:void(0)" class="google_rating">
						 View Google Rating
					 </a>
				 </div>
			 </div>
		 </div>

	';
}





$header = file_get_contents($path . "/layouts/header.html");
$footer = file_get_contents($path . "/layouts/footer.html");
$glinks = file_get_contents($path . "/layouts/global-links.html");
$gscripts = file_get_contents($path . "/layouts/global-scripts.html");

$output = file_get_contents("index_tpl.html");
$out_arr["header"] = $header;
$out_arr["footer"] = $footer;
$out_arr["globLinks"] = $glinks;
$out_arr["globalScripts"] = $gscripts;
$out_arr["carsList"] = $carsHtml;
$out_arr["regularCars"] = $regularCars;
$out_arr["hotelList"] = $hotelList;
$out_arr["clientReviews"] = $clientReviews;
$out_arr["version"] = $version;

 
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
 
 <script>
	$(document).ready(function(){

var highestBox = 0;
		$('.client-detales .discription').each(function(){  
						if($(this).height() > highestBox){  
						highestBox = $(this).height();  
		}
});    
$('.client-detales .discription').height(highestBox);

});
 </script>