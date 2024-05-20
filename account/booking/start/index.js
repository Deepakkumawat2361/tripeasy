$("form").submit((event) => {
	$("input[name='fastag_balance']").removeClass("is-invalid");
	event.preventDefault();
	var fastag = $("input[name='fastag_balance']").val();
	if(fastag < 500){
		$("input[name='fastag_balance']").addClass("is-invalid");
		$("input[name='fastag_balance']").focus();
		return false;
	}
	var frm = document.getElementById("mainFormId");
	var formData = new FormData(frm);
	formData.append("ajax", 45); 	
	$.ajax({
		url: '/tripeasy/api/v1/web/user/checklist/start.php',
		type: 'POST',
		data: formData,
		processData: false,
		contentType: false,
		dataType: 'json',
		success: function(response){
			if(response.status == "success"){
				window.location.href="/tripeasy/account/booking/";
			}else{
				alert("Something went wrong, try again later !"); return false;
			}
		},
		
	});
});


$("#nextButton").on("click", function(){
	var currActive = $("#currMenu").val();
	$("#"+currActive).addClass("d-none");
	var nextNum = parseInt(currActive)+1;
	$("#"+nextNum).removeClass("d-none");
	var lastChap = $("#finalChap").val();
	if(lastChap == nextNum){
		$("#nextButton").addClass("d-none");
		$("#finalSubmit").removeClass("d-none");
	}else{
		$("#prevButton").removeClass("d-none");
	}
	$("#currMenu").val(nextNum);
});


$("#prevButton").on("click", function(){
	var currActive = $("#currMenu").val();
	var nextNum = parseInt(currActive)-1;
	$("#"+currActive).addClass("d-none");
	$("#"+nextNum).removeClass("d-none");
	var lastChap = $("#finalChap").val();
	if(lastChap > nextNum){
		$("#nextButton").removeClass("d-none");
		$("#finalSubmit").addClass("d-none");
	}else{
		$("#nextButton").removeClass("d-none");
	}
	if(nextNum == 1){
		$("#prevButton").addClass("d-none");
	}else{
		$("#prevButton").removeClass("d-none");
	}
	$("#currMenu").val(nextNum);
});