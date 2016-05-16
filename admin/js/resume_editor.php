<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# admin/js/resume_editor.php
# Javascript for using the resume editor
# Everything is built off listeners
# No admin javascript is present in the resume itself
#
#-------------------------------------------------------

# Load the language
require('../../language/'.$_GET['language'].'/frontend.php');

?>

//<script type="text/javascript">


// Parse the DOM and setup edit button listeners
$( document ).ready(function() {
  
  	// Get all resume sections 
 	resume_sections = $('[id^="section_container_"]');
 
 	var i = 0;
 
	// Apply resume section listener to each section
	$.each(resume_sections, function(key, resume_section) {
	
		// Create hover effects and behaviors for sections
	
		// Make a cool cascading slide in effect on the controls	
		setTimeout(function(){
			edit_resume_section_listener(resume_section.id);
		}, i);
		
		i += 100;
	
	});
	
	// Resume items listener
 	resume_items = $('[id^="item_"]');
	
	// Apply resume item listener to each item
	$.each(resume_items, function(key, resume_item) {
		
		// Create hover effects and behaviors for items
	
		// Add listeners to resume items	
		edit_resume_item_listener(resume_item.id)
		
	});
	
  
});
	

// Creates listeners for this section
function edit_resume_section_listener(id) {
	
	// The id of the section, splits section_container_XX
	var section_id = id.split("_");
	var section_id = section_id[2];
	
	// The order and type of the section
	var order = $('#'+id).attr('order');
	var section_type = $('#'+id).attr('type');
	
	// Bind events here
	edit_resume_section_events(id,section_id,order);
	
	// Fade in the section controls
	$('#edit_section_'+section_id).animate({opacity: 1, top: '+=10'},300);
	
}

// Bind all events to the specified section
function edit_resume_section_events(id,section_id,order) {
	
	// Create hover events for this resume section
	$('#section_title_'+section_id).hover(function() { resume_section_hover(section_id,'title') },function() { resume_section_hover_out(section_id,'title') });
	
	// Create onclick events for all editable section items
	$('#section_title_'+section_id).click(function() { edit_resume_section(section_id,'title') });
	
	// Create onclick events for section control buttons
	$('#edit_section_delete_'+section_id).click(function() { delete_resume_section(section_id) });
	$('#edit_section_add_'+section_id).click(function() { add_resume_item(section_id) });
	$('#edit_section_up_'+section_id).click(function() { edit_resume_section_order(section_id,order,'up') });
	$('#edit_section_down_'+section_id).click(function() { edit_resume_section_order(section_id,order,'down') });	
	
	// Grey out the appropriate section controls and disable their functionality
	// Grey out up arrow if first section
	if(order == '1') {
		$('#edit_section_up_'+section_id).attr('class','admin_edit_icon_disabled');
		$('#edit_section_up_'+section_id).unbind('click');
	} else {
		$('#edit_section_up_'+section_id).attr('class','admin_edit_icon');		
	}
	
	//Grey out down arrow if last section
	if($('#'+id).attr('last')=='last') {
		$('#edit_section_down_'+section_id).attr('class','admin_edit_icon_disabled');
		$('#edit_section_down_'+section_id).unbind('click');			
	
	// Insure the arrow is on
	} else {		
		$('#edit_section_down_'+section_id).attr('class','admin_edit_icon');
	}
	
	console.log(id,section_id,order);
	
}

// Creates listeners for this item
function edit_resume_item_listener(id) {
	
	// The id of the item, splits item_XX
	var item_id = id.split("_");
	var item_id = item_id[1];
	
	// The order and type of the item
	var order = $('#'+id).attr('order');
	var item_type = $('#'+id).parents('div:eq(0)').attr('type');	
	
	// Create onclick events for all editable items
	$('#'+id).click(function() { edit_resume_item(item_id,item_type) });
}
	
	
// Swaps section id with an item above or below it
function edit_resume_section_order(id,order,type) {
	
	// The new order of the item
	if(type == 'up') {
		var new_order = parseInt(order) - 1;
	} else {
		var new_order = parseInt(order) + 1;	
	}
	
	/*
	
	AJAX Request, swaps containers on success	
	
	*/
	
	// Stop function if orders are out of range
	// This should be impossible, but this is a failsafe
	if(new_order < 1 || ( $('#section_container_'+id).attr('last')=='last' && order == 'down')) {
		return;	
	}
	
	// Get section to move
	var section_1 = $('#section_container_'+id);
	
	// Get section to be replaced	
	var section_2 = $( '[order="'+new_order+'"][id^="section_container_"]' );
	var section_2_id = $( '[order="'+new_order+'"][id^="section_container_"]' ).attr('id');
	
	// The id of the 2nd section, splits section_container_XX
	var section_2_id = section_2_id.split("_");
	var section_2_id = section_2_id[2];
	
	// Fade the divs out	
	$('#section_container_'+section_2_id).animate({opacity: 0},200);
	$('#section_container_'+id).animate({opacity: 0},200);
	
	// Clone the first div
	var section_1_clone = section_1.clone();
	var section_2_clone = section_2.clone();
	
	// Replace the divs
	setTimeout(function(){
		section_1.replaceWith(section_2_clone);
		section_2.replaceWith(section_1_clone);
	
	// Update order attributes
	$('#section_container_'+section_2_id).attr('order',order);
	$('#section_container_'+id).attr('order',new_order);
	
	// Move last=last to the right section if necessary 
	if($('#section_container_'+id).attr('last')=='last' || $('#section_container_'+section_2_id).attr('last')=='last') {
	
				
		// Last item was replaced with the one above it
		if($('#section_container_'+section_2_id).attr('last')=='last') {
			
			$('#section_container_'+section_2_id).removeAttr('last');
			$('#section_container_'+id).attr('last','last');		
			
		}	
		
		// Last item was moved up
		else if($('#section_container_'+id).attr('last')=='last') {
			
			$('#section_container_'+id).removeAttr('last');
			$('#section_container_'+section_2_id).attr('last','last');				
			
		}
	}	
	
		$('#section_container_'+section_2_id).css('opacity','0');
		$('#section_container_'+id).css('opacity','0');
		
		// Recreate events
		edit_resume_section_events('section_container_'+id,id,new_order);
		edit_resume_section_events('section_container_'+section_2_id,section_2_id,order);
	
	},199);	
	
	
	// Fade the divs in
	setTimeout( function() {
		$('#section_container_'+section_2_id).animate({opacity: 1},200);
		$('#section_container_'+id).animate({opacity: 1},200);
	},225);
}


// Displays editing prompts based on this section type
function edit_resume_section(id,section_type) {
		
	// Edit a section title with a simple form
	if(section_type=='title') {
	
		$('#section_title_'+id);
		
	}
}

// Saves the section after its been edited
function save_resume_section_edit(id,type) {

}

// Cancels the edit and returns normal html
function cancel_resume_section_edit(id,type) {

}

// Hover effects for the section id
function resume_section_hover(id,type) {
		
	// Edit a section title with a simple form
	if(type=='title') {
	
		// Add the hover out class if not exist
		if(!$('#section_title_'+id).hasClass("admin_hover_out") && !$('#section_title_'+id).hasClass("admin_hover")){
   			$('#section_title_'+id).addClass("admin_hover_out");
 		}
		
		// Animate the class switch
		$('#section_title_'+id).switchClass('admin_hover_out','admin_hover', 300);
		
		console.log('over');
		
	}
	
}

// Effects for when the user stops hovering a section
function resume_section_hover_out(id,type) {
	
	if(type=='title') {

		// Animate switching back after a delay	
		var timeout = setTimeout(function() {
			$('#section_title_'+id).switchClass('admin_hover','admin_hover_out', 200);
		}, 300);
		
		// Stop timeout if hovered
		$('#section_title_'+id).hover(function() { clearTimeout(timeout);}, function() { } );
	}	
}

// Sets a section to deleted status
function delete_resume_section(id) {
	alert('delete');
}


// Swaps item id_1 to id_2's position
function edit_resume_item_order(id,section_id,type) {
	
}

// Adds a new resume item to the specified section id
function add_resume_item(id) {
	alert('add');
}

// Edits a resume item in line
function edit_resume_item(id,section_type) {
	alert(id+' '+section_type)
}

// Saves a resume item after it has been edited
function save_resume_item_edit(id) {
	
}

// Sets a section to deleted status
function delete_resume_item(id) {
	
}

//</script>