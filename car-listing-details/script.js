
     
	 
	 function makeMeVoid2(fare, tp){
		 $.ajax({
                       url: "/tripeasy/api/v1/web/auth/check/index.php",
                       type: "post",
                       data: {ajax: 45},
                       dataType:'json',
                       success: function(d) {
                            if(d.status=='success')
                            {
							 proceddPay(fare, tp);
                            }else{
                                alert(d.message);
							 window.location.href="/tripeasy/login";
                            }
                       }
                   });
     }
	 
	 function proceddPay(fare, tp){
            const rzp_options = {
                key: "rzp_test_M9Wd1KqUEdbs7B",
               // amount: parseInt(fare) * 100,
                amount: parseInt(fare) * 100,
                name: "Tripride",
                description: "Tripride Car Rental Services",
                handler: function(response) {
                    console.log(response);
					var booking_id = document.getElementById("mainBookingId").value;
					var payType = tp == 1 ? "full":"half";

                    $.ajax({
                        url: "/tripeasy/car-listing-details/checkout.php",
                        type: "post",
                        data: {transaction_id : response.razorpay_payment_id, booking_id, payType, ajax: 45},
                        dataType:'json',
                        success: function(d) {
                             if(d.status=='success')
                             {
								 console.log(d);
                                alert(d.message);
                                window.location.href="/tripeasy/account/booking/";
                             }else{
                                 alert(d.message);
                                 location.reload();
                             }
                        }
                    });
                },
                modal: {
                    ondismiss: function() {
                        alert(`Payment Failed or Dismissed`);
                    }
                },
                prefill: {
                    email: 'test@email.com',
                    contact: '+914455667788'
                },
                notes: {
                    name: "Customer Name",
                    item: "Null",
                },
                theme: {
                    color: "#FF6224"
                },
                payment_capture: '1',
                image: 'https://tripeasy.in/assets/images/car-logo.png',
                currency: 'INR',
                methods: {
                    netbanking: true,
                    card: true,
                    wallet: true,
                    upi: true,
                },
                razorpay_payment_id: function(response) {
                    console.log("Payment ID: ", response);
                },
                razorpay_error: function(error) {
                    console.log("Payment Error: ", error);
                },
                razorpay_cancel: function() {
                    alert("Payment Cancelled");
                }
            };
            const rzp1 = new Razorpay(rzp_options);
            rzp1.open();
	 }