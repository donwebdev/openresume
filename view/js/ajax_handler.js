/*

-------------------------------------------------------

 OPEN RESUME by Don Westendorp
 © 2016 - Released under GPL v3 Licensing

 view/ajax_handler.js
 Javascript for submitting ajax requests

-------------------------------------------------------

*/



function ajax_request(request_type,impression_id,url,container,behavior_loading,behavior_success) {
	
	var ajax_url = 'ajax.php?request_type='+request_type+'&r_id='+impression_id;
	
	if(url != '') {
		ajax_url += '&'+url;
	}

	
	// All the wonderful loading animations here
	switch(behavior_loading) {
		
		case 'none':
		
			break;
		
		case 'text':
		
			break;
		
		case 'bgcolor':
		
			break;
			
		case 'animation':
		
			break;
					
	}
	
	
	$.ajax({
		
			  url: ajax_url,
			  context: document.body
			  
			}).done(function(html) {

				// All the wonderful success animations here
				switch(behavior_success) {
					
					case 'none':
				 
						$('#'+container).html(html);			
							
						break;
					
					case 'text':
					
						break;
					
					case 'bgcolor':
					
						break;
						
					case 'animation':
					
						break;
								
				}
			
			
			}).fail(function() {
			 
			  $('#'.container).html( 'Request Failed' );
			
			});



}


function ajax_post(form_object,r_id) {
	
	$.ajax({
    
		type : 'POST',
    	url : 'ajax.php?request_type=post&r_id='+r_id,
    	data : $('#'+form_object.name).serialize()
	
	}).done(function(html) {
		
		console.log(html);	
			
	}).fail(function() {
		
		
	});
	
	

			
	console.log();
	
}


