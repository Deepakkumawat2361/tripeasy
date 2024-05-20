$(document).ready(function(){
	var url = window.location.href;
    var urlParams = new URL(url);
    var id = urlParams.searchParams.get("id");
			getlist();
			
		function getlist()
		{ 
			$.ajax({
				url:"/tripeasy/api/v1/admin/documents/list.php?page=1",
				dataType : 'json',
				type : 'get',
				data : { },
					success : function(response){
					  data= response.response;
					 if(data.status == 'success'){
						 res = data.data;
						  var carTableElement = $('#table');
						  var row;
						  res.forEach(function(listing, i){
							  listing.status = listing.status ==1 ? `<span class='text-success'>Approved</span>` : `<span class='text-warning'>Pending</span>`;
							  row+= `<tr>
											<td>${i+1}</td>
											<td><strong>${listing.userName} (${listing.userMobile}) </strong></td>
											<td>${listing.status}</td>
											<td>
												<a class='border-0 btn btn-primary py-2 px-4 text-white fs-14 fw-semibold rounded-3' href='/tripeasy/master_panel/documents/view?id=${listing.id}'>View</a>
											</td>
										</tr>`;
						  });
						  
						  $('#table').html(row); 
						  // carTableElement.html(row); 
						  // console.log(row); return false;
					 }
					}
					
			});
		}
	
	});

 