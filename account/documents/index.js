
        $("#doc1Field").on('change', function(e) {
			pressImage(e);
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $("#doc1Preview").attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
				uploadThisFile(this.files[0], "adhaar_front");
				$(this).remove();
            }
        });
		
		
        $("#doc12Field").on('change', function(e) {
			pressImage(e);
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $("#doc12Preview").attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
				uploadThisFile(this.files[0], "adhaar_back");
				$(this).remove();
            }
        });
		
		$("#doc2Field").on('change', function(e) {
			pressImage(e);
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $("#doc2Preview").attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
				uploadThisFile(this.files[0], "license_front");
				$(this).remove();
            }
        });
		
        $("#doc22Field").on('change', function(e) {
			pressImage(e);
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $("#doc22Preview").attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
				uploadThisFile(this.files[0], "license_back");
				$(this).remove();
            }
        });


		function callFormSubmit(){
			if($("input[name='adhar_number']").val()==''){
				alert("Please enter adher number");
				return false; 
			}
			if($("input[name='license_number']").val()==''){
				alert("Please enter license number");
				return false; 
			}
			$('#docForm').submit();
			$(".loader-container").css("display","flex");
			fakeLoading();
		}


		function uploadThisFile(files, tagName){
			var formData = new FormData();
			formData.append("image", files);
			formData.append("name", tagName);
			formData.append("ajax", 45);
			var url = "uploadFiles.php";
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if(this.status == 200 && this.readyState == 4){
					var resp = JSON.parse(this.responseText);
					if(resp.status == "success"){
						console.log(resp);
					}
				}
			}
			xhttp.open("post", url, true);
			xhttp.send(formData);
		}




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
		url:"/tripeasy/api/v1/admin/booking/list.php?page=1",
		dataType : 'json',
		type : 'get',
		data : {search_array },
			success : function(response){
			     data= response.response;
				 if(data.status == 'success'){
					 res = data.data;
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
										 <div class="badge rounded-pill bg-success" style="background-size: 100%; background-repeat: no-repeat;">completed</div>
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

//function for compress image  :: Start
const compressImage = async (file, { quality = 1, type = file.type }) => {
			const imageBitmap = await createImageBitmap(file);
			const canvas = document.createElement('canvas');
			canvas.width = imageBitmap.width;
			canvas.height = imageBitmap.height;
			const ctx = canvas.getContext('2d');
			ctx.drawImage(imageBitmap, 0, 0);
			const blob = await new Promise((resolve) =>
				canvas.toBlob(resolve, type, quality)
			);
			return new File([blob], file.name, {
				type: blob.type,
			});
		};
		
		const input = document.querySelector('.my-image-field');
		const pressImage = async(e) => {
			$(".loader-container").css("display","flex");
			const { files } = e.target;
			if (!files.length) return;
			const dataTransfer = new DataTransfer();
			for (const file of files) {
				if (!file.type.startsWith('image')) {
					dataTransfer.items.add(file);
					continue;
				}
				const compressedFile = await compressImage(file, {
					quality: 0.3,
					type: 'image/jpeg',
				});
				dataTransfer.items.add(compressedFile);
			}
			e.target.files = dataTransfer.files;
			console.log("Image Compressed Successfully !");
			$(".loader-container").css("display","none");
		}
//function for compress image  :: End