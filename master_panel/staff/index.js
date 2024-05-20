$(document).ready(function(){
	
	
	
	var url = window.location.href;
    var urlParams = new URL(url);
    var id = urlParams.searchParams.get("id");
			getlist();
			
		
		function getlist()
		{
			 
			$.ajax({
				url:"/tripeasy/api/v1/admin/staff/list.php?page=1",
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
							  var row = $("<tr>");
							   row.append("<td>" + listing.id + "</td>");
							   row.append("<td>" + listing.name + "</td>");
							   row.append("<td>" + listing.email + "</td>");
						       row.append("<td>" + listing.mobile + "</td>");
						       row.append("<td class='text-success'>Status</td>");
							   
							   row.append("<td><a class='table-btn' href='/master_panel/staff/view/?id=" + listing.id + "'>View</a></td>");
                row.append("<td><a class='table-btn' href='/tripeasy/master_panel/staff/edit/?id=" + listing.id + "'>Edit</a></td>");
                row.append("<td><a class='table-btn' href='/tripeasy/master_panel/staff/delete.php/?id=" + listing.id + "'>Delete</a></td>");	
							   
							
									
									 
									   
								  carTableElement.append(row);
							  
							  
						  });
					      
					 }
					}
					
			});
		}
	
	});

 