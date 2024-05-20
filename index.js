function locations(loc)
{
	 $("input[name='location']").val(loc);
	 $("#myPopup").addClass('hide');
	 
}
$('form').submit(function(event){
	event.preventDefault();
	var formData = new FormData(this);
	$.ajax({
		url: '/tripeasy/api/v1/web/search.php',
		type: 'POST',
		dataType: 'json',
		data: formData,
		processData: false,
		contentType: false,
		success: function(result){
			if(result.status=='success')
			{
				window.location.href = result.redirect; 
			} 
			if(result.status == 'error')
			{
				error_list = result.errors;
				 
				Object.entries(error_list).forEach(entry => {
				  const [key, value] = entry;
				  $("input[name='"+key+"']").css({"border-color": "red"});
				 
				});

		    }
			if(result.status == 'timeing')
			{
				$("#errors").html(result.errors);
			}
		  
		},
				
	});
});