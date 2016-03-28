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


// Simple post ajax
function ajax_post(form_object,r_id) {
	
	data = $('#'+form_object.name).serialize();
		
	loading_height = $('#'+form_object.name+'_container').css('height');
	
	$('#'+form_object.name+'_container').html('<div id="'+form_object.name+'_loading" class="form_result_loading form_result_loading_1"><div class="uil-ring-css form_result_loading_symbol" style="transform:scale(0.4);"><div></div>');
	
	$('#'+form_object.name+'_loading').css('height',loading_height);
	
	var post_loading = 1;
	animate_loading();
	
	function animate_loading() {
	
		// Animates until it's not sposed to anymore
		if(post_loading == 1) {
	
			$('#'+form_object.name+'_loading').switchClass('form_result_loading_1', 'form_result_loading_2',  500).switchClass('form_result_loading_2', 'form_result_loading_1',  500, '', function() { animate_loading(); });
	
		}
	}
	
	$.ajax({
    
		type : 'POST',
    	url : 'ajax.php?request_type=post&r_id='+r_id,
    	data : data
	
	}).done(function(html) {
		
		// Animation for form result success
		post_loading = 0;	
		$('#'+form_object.name+'_loading').css('height','auto');
		$('#'+form_object.name+'_loading').removeClass('form_result_loading_1');	
		$('#'+form_object.name+'_loading').removeClass('form_result_loading_2');	
		$('#'+form_object.name+'_loading').addClass('form_result_success_1');	
		$('#'+form_object.name+'_loading').switchClass('form_result_success_1', 'form_result_success_2',  1500);
		$('#'+form_object.name+'_loading').html('<div id="'+form_object.name+'_result" class="'+form_object.name+'_result" style="display:none;">'+html+'</div>');	
		$('#'+form_object.name+'_result').fadeIn(1500);
			
	}).fail(function() {
		
		
	});
	
	

			
	console.log();
	
}


