$("#makeLogin").on("click", function(){
	$("#showError").text("");
	var email = $("#email").val();
	var password = $("#password").val();
	$.ajax({
	method:"POST",
	url: "/tripeasy/api/v1/delivery-boy/auth/login.php",
	dataType:'json',
	data:{email, password},
	success: function(data){
		 if(data.status == "success"){
			setTimeout(() => {
				window.location.href ='/tripeasy/delivery-boy/';
			}, 1000);
		  }else{
			 $("#showError").text(data.message);
		  }
		}
	});
});