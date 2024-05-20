$(document).ready(function(){
	
	
	
	var url = window.location.href;
    var urlParams = new URL(url);
    var id = urlParams.searchParams.get("id");
			getlist();
			
		
		function getlist()
		{
			 
			$.ajax({
				url:"/tripeasy/api/v1/admin/booking/list.php?page=1",
				dataType : 'json',
				type : 'get',
				data : { },
					success : function(response){
					  data= response.response;
					 if(data.status == 'success'){
						 res = data.data;
						  var carTableElement = $('#table');
						  
						  res.forEach(function(listing, i){
							   var row = $("<tr class='text-center'>");
							   row.append("<td>" + listing.booking_id + "</td>");
							   row.append("<td><img class='size' src='"+/tripeasy/+"" + listing.image + "'><br>" + listing.name + "</td>");
							   row.append("<td>" + listing.start_date + "</td>");
							   row.append("<td>" + listing.end_date + "</td>");
							   row.append("<td>₹" + listing.final_fair + "</td>");
								row.append(`<td>
										<a class='border-0 btn btn-primary py-2 px-4 text-white fs-14 fw-semibold rounded-3' href='/tripeasy/master_panel/bookings/view/?id=${listing.booking_id}'>Edit</a>&nbsp;&nbsp;
										<a class="dropdown-item" href="javascript:;"></a>
										</td>`);
								  carTableElement.append(row);
							  
							  
						  });
					      
					 }
					}
					
			});
		}
	
	});

 