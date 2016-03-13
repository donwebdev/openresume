/*

-------------------------------------------------------

 OPEN RESUME by Don Westendorp
 © 2016 - Released under GPL v3 Licensing

 view/contact.js
 Javascript for controlling the contact form
 Mainly handles the ajax and animations on the contact form

-------------------------------------------------------

*/


// Do animation functions and grab details
function contact_form_toggle(id,get_details) {

	// Show form, get details if we are told
	if($('#contact_form_overlay_'+id).css('display') === 'none') {
				
		$('#contact_form_overlay_'+id).fadeIn(200);$
		$('#contact_form_'+id).css('top','45%');
		$('#contact_form_'+id).css('opacity','0.0');
		$('#contact_form_'+id).show().animate({top: "50%", opacity: "1.0"}, 200);
		
		
		if(get_details === 1) {
		
			contact_get_details(id);
		
		}
		
		
	} else {
		
		$('#contact_form_overlay_'+id).fadeOut(200);
		$('#contact_form_'+id).css('top','50%');
		$('#contact_form_'+id).css('opacity','1.0');
		$('#contact_form_'+id).show().animate({top: "45%", opacity: "0.0"}, 200);
		
	}
	
}

// Ajax to grab details
function contact_get_details(id) {


	
}