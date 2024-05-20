$(document).ready(function(){
	
	var url = window.location.href;
    var urlParams = new URL(url);
    var id = urlParams.searchParams.get("id");
	
	
	getlist();
		$('form').submit(function(event){
			event.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				url: '/tripeasy/api/v1/admin/cars/update.php?id='+id,
				type: 'POST',
				dataType: 'json',
				data: formData,
				processData: false,
				contentType: false,
				success: function(result){
				  data = result.response;
				    
					if(data.status == 'success'){
					   window.location.href = '/tripeasy/master_panel/vehicle/edit/owner_info/?id='+id; 
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
				url:"/tripeasy/api/v1/admin/cars/car_document.php?id="+id,
				dataType : 'json',
				type : 'get',
				data : { },
					success : function(response){
					 data= response.response;
					 if(data.status== 'success'){
						 res = data.data;
						 
						  //console.log(res);
						  $('#image_show').attr('src',res.registration_certificate);
					      Object.entries(res).forEach(entry => {
						  const [key, value] = entry;
						  
						  //console.log(value);
						  
						  $("input[name='"+key+"']").val(value);
						  $("select[name='"+key+"']").val(value);
						  
						  //$("select[name='segment']").val(value);

						  
						});
					 }
					}
			});
		}
		
		$('#upload_image').on('change', function () {
			var formData = new FormData();
			formData.append('image2', $(this)[0].files[0]);

			$.ajax({
				url:"/tripeasy/api/v1/admin/cars/document_update2.php?id="+id,
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function (response) {
				  data= response.response;
				   if(data.status== 'success'){
					   res = data.data;
					   //console.log(data);
                      $('#car').attr('src',res.paper_verified);
					  //alert(res.registration_certificate);
				   }
				},
				error: function () {
					alert('Image upload failed. Please try again.');
				}
			});
		});
		
		
		
	});

 