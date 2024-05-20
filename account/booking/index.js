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
		url:"/tripeasy/api/v1/web/user/booking.php?page=1",
		dataType : 'json',
		type : 'get',
		data : {search_array },
			success : function(response){
			     data= response.response;
				 if(data.status == 'success'){
					 res = data.data;
					 console.log(res);
					 var html = '';
					 res.forEach(function(listing, i){
						 
					     html +=`
								
								   <tr>
									  <td>
										 <div class="badge bg-gray-100 text-dark" style="background-size: 100%; background-repeat: no-repeat;">#0${listing.booking_id}</div>
										 <img src="${listing.image}" style="height: 100px;width: 120px;"/>
										 <br>
										 <span class="bold">${listing.name}</span>
									  </td>
									  
									  <td>${listing.start_date}</td>
									  <td>${listing.end_date}</td>
									  <td>₹ ${listing.final_fair}</td>
									  
									  <td>
										 <div class="badge rounded-pill bg-success" style="background-size: 100%; background-repeat: no-repeat;"><a href="/tripeasy/account/booking/details?id=${listing.id}">View Detail</a></div>
									  </td>
								   </tr>`;
					});
					$("#bookingListHere").html(html); 
					   
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
		}else{
			$(this).closest('.vehicle-content').find('button.button-2').attr('data-href', newHref);
		}
	});
});

$(document).on("click", ".button-2",  function(){
	window.location.href=$(this).attr("data-href");
});

//For Choose Limited Or Unlimited Plans :: End