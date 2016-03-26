/*

-------------------------------------------------------

 OPEN RESUME by Don Westendorp
 © 2016 - Released under GPL v3 Licensing

 view/contact.js
 Javascript for controlling the contact form
 Mainly handles the ajax and animations on the contact form

-------------------------------------------------------

*/


// Do animation functions for the contact form
function contact_form_toggle(id,get_details) {	
	
	// Show form, get details if we are told
	if($('#contact_form_overlay_'+id).css('display') === 'none') {
		
		$('#contact_form_'+id).css('display','block');		
		$('#contact_form_overlay_'+id).fadeIn(200);
		$('#contact_form_'+id).switchClass('contact_form_hidden', 'contact_form_visible', 200);
		
	} else {
		
		$('#contact_form_overlay_'+id).fadeOut(200);
		$('#contact_form_'+id).switchClass('contact_form_visible', 'contact_form_hidden', 200, '', $(this).css('display','none'));
	}
	
}