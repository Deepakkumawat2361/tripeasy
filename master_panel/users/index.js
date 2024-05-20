$(document).ready(function(){
	
	
	
	var url = window.location.href;
    var urlParams = new URL(url);
    var id = urlParams.searchParams.get("id");
			getlist();
			
		
		function getlist()
		{
			 
			$.ajax({
				url:"/tripeasy/api/v1/admin/users/list.php?page=1",
				dataType : 'json',
				type : 'get',
				data : { },
					success : function(response){
					  data= response.response;
					 if(data.status == 'success'){
						 res = data.data;
						  var carTableElement = $('#table');
						  res.forEach(function(listing, i){
							  
							  listing.status = listing.status ==1 ? 'Active' : 'inactive';
							  var row = $("<tr>");
							   row.append("<td>" + (i+1) + "</td>");
							   row.append("<td><img src='"+/tripeasy/+""+listing.image+"' style='height: 80px;width: 80px;border-radius: 40%;' /><br><strong>" + listing.name + "</strong></td>");
							   row.append("<td>" + listing.email + "</td>");
							   row.append("<td>" + listing.mobile + "</td>");
							   row.append("<td>" + listing.otp + "</td>");
						       row.append("<td class='text-success'>"+listing.status+"</td>");
							   row.append(`<td>
												<a class='border-0 btn btn-primary py-2 px-4 text-white fs-14 fw-semibold rounded-3' href='/tripeasy/master_panel/users/edit/?id=${listing.id}'>Edit</a>&nbsp;&nbsp;
												<a class='border-0 btn btn-danger py-2 px-4 text-white fs-14 fw-semibold rounded-3' href='/tripeasy/master_panel/users/delete.php/?id=${listing.id}'>Delete</a>
											</td>`);
							   carTableElement.append(row);
						  });
					      
					 }
					}
					
			});
		}
	
	});

 