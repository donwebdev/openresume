<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# admin/js/resume_editor.php
# Javascript for using the resume editor
# Everything is built off listeners
# No javascript is present in the resume itself
#
#-------------------------------------------------------


?>

//<script type="text/javascript">


// Parse the DOM and setup edit button listeners
$( document ).ready(function() {
  
  	// Get all resume sections 
 	resume_sections = $('[id^="section_container_"]');
 
	// Apply resume section listener to each section
	$.each(resume_sections, function(key, resume_section) {
		edit_resume_section_listener(resume_section.id);
	});
	
	// Resume items listener
 	resume_items = $('[id^="item_"]');
	
	// Apply resume item listener to each item
	$.each(resume_items, function(key, resume_item) {
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
	
	// Create onclick events for all editable section items
	$('#section_title_'+section_id).click(function() { edit_resume_section(section_id,'title') });
	$('#section_date_'+section_id).click(function() { edit_resume_section(section_id,'title') });
	
	// Create onclick events for section control buttons
	$('#edit_section_delete_'+section_id).click(function() { delete_resume_section(section_id) });
	$('#edit_section_add_'+section_id).click(function() { add_resume_item(section_id) });
	$('#edit_section_up_'+section_id).click(function() { edit_resume_section_order(section_id,'up') });
	$('#edit_section_down_'+section_id).click(function() { edit_resume_section_order(section_id,'down') });
	
	// Grey out the appropriate section controls and disable their functionality
	// Grey out up arrow as this is the highest order
	if(order == '1') {
		$('#edit_section_up_'+section_id).attr('class','admin_edit_icon_disabled');
		$('#edit_section_up_'+section_id).unbind('click');
	}
	
	// Fade in the section controls
	$('#edit_section_'+section_id).fadeIn(1000);
	
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
function edit_resume_section_order(id,type) {
	alert('order '+type);
}

// Displays editing prompts based on this section type
function edit_resume_section(id,section_type) {
	alert(id+' '+section_type);		
}

// Saves the section after its been edited
function save_resume_section_edit(id) {

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