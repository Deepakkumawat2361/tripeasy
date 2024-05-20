$('form').submit(function(event){
	event.preventDefault();
	var formData = new FormData(this);
	$.ajax({
		url: '/tripeasy/api/v1/web/search.php',
		type: 'POST',
		dataType: 'json',
		data: formData,
		processData: false,
		contentType: false,
		success: function(result){
			if(result.status=='success')
			{
				window.location.href = result.redirect; 
			} 
			if(result.status == 'error')
			{
				error_list = result.errors;
				 
				Object.entries(error_list).forEach(entry => {
				  const [key, value] = entry;
				  $("input[name='"+key+"']").css({"border-color": "red"});
				 
				});

		    }
			if(result.status == 'timeing')
			{
				$("#errors").html(result.errors);
			}
		  
		},
				
	});
});

var currentURL = window.location.href;
var url = currentURL.split('?')[0];
var query = currentURL.split('?')[1];

/* sagment */
search_array ={};
$('input[type="checkbox"]').click(function() {
	search_array ={};
    $('input[type="checkbox"]').each(function () {
        if(this.checked){
			name = $(this).attr('name');
			if(!search_array[name])
			{
				search_array[name]=[];
			}
			search_array[name].push($(this).val());
			//search_array.push({name:$(this).val()});
		}
		
    });
	 getlist();
});

 

getlist();
function getlist()
{
	 
	$.ajax({
		url:"/tripeasy/api/v1/web/cars/listing/?"+query,
		dataType : 'json',
		type : 'get',
		data : {search_array },
			success : function(response){
			     data= response.response;
				 if(data.status == 'success'){
					 res = data.data;
					 var html = '';
					 res.forEach(function(listing, i){
						 
					     html +=`<div class="col-md-4">
								 <div class="vehicle-content theme-yellow">
									 <div class="vehicle-thumbnail">
										 <a href="#">
										 <img style="height: 150px;" src="/tripeasy/${listing.image}" alt="car-item">
										 </a>
									 </div>
									 <div class="vehicle-bottom-content">
										 <div class="car-name-rating">
											 <h2 class="vehicle-title"><a href="#">${listing.name}</a></h2>
											 <div class="car-rating">
												 <div class="list-rating">
													 
												 </div>
											 </div>
										 </div>
										 <div class="listing-details-group">
											 <ul>
												 <li>
													 <span><img src="/tripeasy/assets/images/car-item/p-1.svg" alt="car-item"></span>
													 <p>${listing.transmission}</p>
												 </li>
												  
												 <li>
													 <span><img src="/tripeasy/assets/images/car-item/p-3.svg" alt="car-item"></span>
													 <p>${listing.fuel}</p>
												 </li>
												 <li>
													 <span><img src="/tripeasy/assets/images/car-item/p-6.svg" alt="car-item"></span>
													 <p>${listing.seater} Persons</p>
												 </li>
											 </ul>
											  
										 </div>
										 <ul class="car_plans_section">
										    
										   <li class="active isSelected" data-type="0" style="cursor: pointer;">
											   <div class="car_plans_inner_section">
                            <span class="day_sec">250Km/day</span>
                            <h4>₹${listing.price}</h4>
                            <span class="km_sec">250 Free Kms</span>
												  </div>
											 </li>												 
										   <li class="isSelected" data-type="1" style="cursor: pointer;">
											   <div class="car_plans_inner_section">
                            <span class="day_sec">Unlimited</span>
                             <h4>₹${listing.unlimited_price}</h4>
                            <span class="km_sec">Unlimited Kms</span>
												  </div>
											 </li>
										 
										</ul>
										 <div class="car-vehicle-meta">
											 <div class="meta-item text-danger">
												 <span class="extra_km_charge">Extra kms charged at ₹${listing.extra_km_charge}/km</span>
											 </div>
											 <div class="btn-area">
												 <button title="${listing.slug}" class="button-2 red-bg w-100" data-href="${url}/${listing.slug}?${query}&booking_id=${listing.booking_id}&km=250">Book Now</button>
											 </div>
										 </div>
									 </div>
								 </div>
							   </div>`;
					});
					$("#list").html(html); 
					   
				 }
			}
			
	});
}



//For Choose Limited Or Unlimited Plans :: Start
$(document).on("click", ".isSelected",  function(){
	$('.car_plans_section li').click(function(){
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		var tp = $(this).attr("data-type");
		var Href = $(this).closest('.vehicle-content').find('button.button-2').attr('data-href');
		newHref = Href;
		
		if(tp == 1){
		 
			newHref = Href.split("&km=")[0];
			newHref = newHref+"&km=unlimited";
			$(this).closest('.vehicle-content').find('button.button-2').attr('data-href', newHref);
			$(this).parent().closest('.vehicle-bottom-content').find(".extra_km_charge").hide()
		}else{
			 
			$(this).closest('.vehicle-content').find('button.button-2').attr('data-href', newHref);
			$(this).parent().closest('.vehicle-bottom-content').find(".extra_km_charge").show()
		}
	});
});

$(document).on("click", ".button-2",  function(){
	window.location.href=$(this).attr("data-href");
});

//For Choose Limited Or Unlimited Plans :: End