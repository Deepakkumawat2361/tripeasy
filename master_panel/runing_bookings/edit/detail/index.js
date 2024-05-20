$(document).ready(function(){
	
	var url = window.location.href;
    var urlParams = new URL(url);
    var id = urlParams.searchParams.get("id");
	
	
	getlist();
		$('form').submit(function(event){
			event.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				url: '/tripeasy/api/v1/admin/cars/update_info.php?id='+id,
				type: 'POST',
				dataType: 'json',
				data: formData,
				processData: false,
				contentType: false,
				success: function(result){
				  data = result.response;
				    
					if(data.status == 'success'){
					   //window.location.href = '/master_panel/vehicle/'; 
					}
					else if(data.status == 'error')
					{
					   error_list = data.errors;
					   Object.entries(error_list).forEach(entry => {
						  const [key, value] = entry;
						  $("input[name='"+key+"']").css({"border-color": "red"});
						  console.log(key, value);
						});

					}else{
					
					}
				},
				
			});
		});
		
		
		function getlist()
		{
			$.ajax({
				url:"/tripeasy/api/v1/admin/cars/edit_info.php?id="+id,
				dataType : 'json',
				type : 'get',
				data : { },
					success : function(response){
					 data= response.response;
					 if(data.status== 'success'){
						 res = data.data;
						 
						  
					      Object.entries(res).forEach(entry => {
						  const [key, value] = entry;
						  
						  //console.log(value);
						  
						  $("input[name='"+key+"']").val(value);
						  $("select[name='"+key+"']").val(value);
						   
						  
						});
						
						imageHTML = '';
						var array = res.images.split(',');
						for (var k = 0; k < array.length; k++) {
							  if(array[k]){
							imageHTML += `
							         <div class="col-md-4">
							           <div class="form-group p-4 bg-border-gray-light d-sm-flex justify-content-between    align-items-center rounded-10">
												
													<div class="d-sm-flex align-items-center mb-3 mb-sm-0 me-lg-3">
														 
														<img id="images_show" src="${array[k]}" class="rounded-4 wh-78 ms-3 ms-lg-0" alt="product">
													</div>

													<div class="d-flex ms-sm-3 ms-md-0">
										<button class="btn btn-danger bg-opacity-10 text-white fw-bold fw-semibold">Delete</button>
														 
													</div>
												</div>
							         </div>`;
							  }
							
						  }
						 // console.log(imageHTML);
					     $('#imageContainer').html(imageHTML);
					 }
					}
			});
		}
		
		
		$('#file-upload').on('change', function () {
			var formData = new FormData();
			formData.append('image', $(this)[0].files[0]);

			$.ajax({
				url:"/tripeasy/api/v1/admin/cars/gallery_update.php?id="+id,
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function (response) {
				  data= response.response;
				   if(data.status== 'success'){
					   
					   //console.log(data);
				   imageHTML = '';   
				   for (var j = 0; j < data.data.length; j++) {
					  if(data.data[j]){
                    imageHTML += `
					        <div class="col-md-4">
							  <div class="form-group p-4 bg-border-gray-light d-sm-flex justify-content-between    align-items-center rounded-10">
										
											<div class="d-sm-flex align-items-center mb-3 mb-sm-0 me-lg-3">
												
												<img id="images_show" src="${data.data[j]}" class="rounded-4 wh-78 ms-3 ms-lg-0" alt="product">
											</div>

											<div class="d-flex ms-sm-3 ms-md-0">
												<button class="btn bg-danger bg-opacity-10 text-danger fw-semibold">Delete</button>
												
											</div>
										</div>
							</div>
					          
							  `;
					  }
                    
				  }  
					$('#imageContainer').html(imageHTML);
					  
					   
					   
				   }
				},
				error: function () {
					alert('Image upload failed. Please try again.');
				}
			});
		});
		
       
 
	});
 