/*$("form").submit((event) => {
	event.preventDefault();
	alert(); return false;
	var frm = document.getElementById("mainFormId");
	var formData = new FormData(frm);
	formData.append("ajax", 45); 	
	$.ajax({
		url: '/api/v1/web/delivery-boy/booking/checklist/start.php',
		type: 'POST',
		data: formData,
		processData: false,
		contentType: false,
		dataType: 'json',
		success: function(response){
			if(response.status == "success"){
				location.reload();
			}else{
				alert("Something went wrong, try again later !"); return false;
			}
		},
		
	});
});*/



function checking(){
	var frm = document.getElementById("demoForm");
	var formData = new FormData(frm);
	formData.append("ajax", 45); 	
	$.ajax({
		url: '/tripeasy/api/v1/delivery-boy/profile/update.php',
		type: 'POST',
		data: formData,
		processData: false,
		contentType: false,
		dataType: 'json',
		success: function(response){
			if(response.status == "success"){
				location.reload();
			}else{
				alert("Something went wrong, try again later !"); return false;
			}
		},
		
	});
}