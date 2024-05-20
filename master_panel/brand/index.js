$(document).ready(function(){
	
	
	
	var url = window.location.href;
    var urlParams = new URL(url);
    var id = urlParams.searchParams.get("id");
			getlist();
			
		
		function getlist()
		{
			 
			$.ajax({
				url:"/tripeasy/api/v1/admin/brand/list.php?page=1",
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
							  // row.append("/uploads/brands/<td>" + listing.image + "</td>");
							   row.append("<td><img class='size' src='" + listing.image + "'></td>");
						       row.append("<td class='text-success'>Status</td>");
							   
							   row.append("<td><a class='table-btn' href='/tripeasy/master_panel/brand/view/?id=" + listing.id + "'>View</a></td>");
                row.append("<td><a class='table-btn' href='/tripeasy/master_panel/brand/edit/?id=" + listing.id + "'>Edit</a></td>");
                row.append("<td><a class='table-btn' href='/tripeasy/master_panel/brand/delete.php/?id=" + listing.id + "'>Delete</a></td>");	 
								  carTableElement.append(row);
							  
							  
						  });
					      
					 }
					}
					
			});
		}
	
	});

 