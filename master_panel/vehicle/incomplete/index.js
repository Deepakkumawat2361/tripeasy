$(document).ready(function(){
	
	
	
	var url = window.location.href;
    var urlParams = new URL(url);
    var id = urlParams.searchParams.get("id");
			getlist();
			
		
		function getlist()
		{
			 
			$.ajax({
				url:"/tripeasy/api/v1/admin/cars/incomplete.php?page=1",
				dataType : 'json',
				type : 'get',
				data : { },
					success : function(response){
					  data= response.response;
					 if(data.status == 'success'){
						 res = data.data;
						  var carTableElement = $('#table');
						  
						  res.forEach(function(listing, i){
							  //console.log(listing);
							  
							  var row = $("<tr class='text-center'>");
							   row.append("<td>" + listing.id + "</td>");
							   
							   row.append("<td><img class='size' src='" + listing.image + "'></td>");
							   row.append("<td>" + listing.name + "</td>");
							   
						       row.append("<td class='text-success'>Status</td>");
							   
							row.append('<td>\
										<a href="/master_panel/vehicle/edit/?id='+listing.id+'" class="dropdown-item" >\
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">\
										<path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>\
										<a class="dropdown-item" href="javascript:;">\
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">\
										<polyline points="3 6 5 6 21 6"></polyline>\
										<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>\
										</td>');
        

				/*row.append("<td><a class='table-btn' href='/master_panel/vehicle/view/?id=" + listing.id + "'>View</a></td>");
                row.append("<td><a class='table-btn' href='/master_panel/vehicle/edit/?id=" + listing.id + "'>Edit</a></td>");
                row.append("<td><a class='table-btn' href='/master_panel/vehicle/delete.php/?id=" + listing.id + "'>Delete</a></td>");	 */  
								  carTableElement.append(row);
							  
							  
						  });
					      
					 }
					}
					
			});
		}
	
	});

 