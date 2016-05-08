/*

-------------------------------------------------------

 OPEN RESUME by Don Westendorp
 © 2016 - Released under GPL v3 Licensing

 admin/js/ajax_handler.js
 Javascript for submitting ajax requests on the admin
 panel

-------------------------------------------------------

*/


function ajax_post(form_object,r_id) {
	
	ajax_handlers[form_object.name](form_object,r_id);
	
}


var ajax_handlers = {
	
	login_form: function(form_object,r_id) {
			
		data = $('#login_form').serialize();
		var login_loading = 1;	
		
		//Loading Animation Function
		
		
		$.ajax({
		
			type : 'POST',
			url : 'ajax.php?request_type=post&r_id='+r_id,
			data : data
		
		}).done(function(html) {
			
			// Animation for form result success
			login_loading = 0;
			
			// Login was successful, refresh the page		
			if(html == 'Login Successful') {

				window.location = window.location.href;
			
			// Login failed, just say it failed			
			} else if(html == 'Login Failed') {

				$('#failure_message').html(html);

			// Login returned custom text, put it in the container			
			} else {
	
	
				
			}
	
				
		}).fail(function() {
			
			
		});	
	}


};