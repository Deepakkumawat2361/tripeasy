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
}