function sendOtp(){
	var mobile = document.getElementById("mobile").value;
	if(mobile.toString().length < 10){
		document.getElementById("mobile").style.border=("1px solid red");
	}
	if(mobile.toString().length > 10){
		document.getElementById("mobile").style.border=("1px solid red");
	}
	if(mobile.toString().length == 10){
		document.getElementById("mobile").style.border=("1px solid green");
	}
	$.ajax({
		method:"post",
		url:"/tripeasy/api/v1/web/auth/otp/send.php",
		dataType:"json",
		data:{mobile},
		success:function(resp){
			if(resp.response.status == "success"){
				alert(resp.response.message);
				if(resp.response.isNew === 1){
					$("#name").removeClass("d-none");
					$("#email").removeClass("d-none");
				}
				if((resp.response.field).length > 0){
					var elemen = (resp.response.field);
					elemen.forEach((val) => {
						$("#"+val).removeClass("d-none");
					});
				}
				$("#mobileArea").addClass("d-none");
				$("#otpArea").removeClass("d-none");
				
			}
		}
	});
}


function verifyOtp(){
	var otp = document.getElementById("otp").value;
	var mobile = document.getElementById("mobile").value;
	
	if(otp.toString().length < 6){
		document.getElementById("otp").style.border=("1px solid red");
	}
	if(otp.toString().length > 6){
		document.getElementById("otp").style.border=("1px solid red");
	}
	if(otp.toString().length == 6){
		document.getElementById("otp").style.border=("1px solid green");
	}
	var name = $("#name").val();
	var email = $("#email").val();
	$.ajax({
		method:"post",
		url:"/tripeasy/api/v1/web/auth/otp/verify.php",
		dataType:"json",
		data:{mobile, otp, name, email},
		success:function(resp){
			if(resp.response.status == "success"){
				// var currentURL = window.location.href;
				// var query = currentURL.split('?redirect=')[1];
				// var hlink = query;
				var hlink = "";
				if(resp.response.redirect == 1){
					hlink = resp.response.redLink;
				}
				if(hlink.length > 2){
					window.location.href=hlink;
				}else{
					window.location.href="/";					
				}
			}
			if(resp.response.status == "error"){
				alert(resp.response.errors.otp);
				document.getElementById("otp").style.border=("1px solid red");
			}
		}
	});
}