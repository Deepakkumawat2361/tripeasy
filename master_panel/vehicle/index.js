$(document).ready(function(){
	
	var url = window.location.href;
    var urlParams = new URL(url);
    var id = urlParams.searchParams.get("id");
			getlist();
			
		
		function getlist()
		{
			 
			$.ajax({
				url:"/tripeasy/api/v1/admin/cars/list.php?page=1",
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
							  
							  var row = $("<tr class='text-left'>");
							   row.append("<td>" + (i+1) + "</td>");
							   
							   row.append("<td><img class='size' style='height: 75px;width: 130px;' src='"+/tripeasy/+""+ listing.image + "'></td>");
							   row.append("<td>" + listing.name + "</td>");
							   
						       
							   
							row.append('<td>\
										<a href="/tripeasy/master_panel/vehicle/edit/?id='+listing.id+'" class="border-0 btn btn-primary py-2 px-4 text-white fs-14 fw-semibold rounded-3" >\
											Edit\
										</a>\
										<a class="border-0 btn btn-danger py-2 px-4 text-white fs-14 fw-semibold rounded-3" href="javascript:;">\
											Delete\
										</td>');
        

				 
								  carTableElement.append(row);
							  
							  
						  });
					      
					 }
					}
					
			});
		}
	
	});

 