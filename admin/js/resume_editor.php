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
	order = $('#'+id).attr('order');	
}

// Creates listeners for this item
function edit_resume_item_listener(id) {
	order = $('#'+id).attr('order');	
}
	
	
// Swaps section id_1 to id_2's position
// Sends ajax request and logs the change to the change log
function edit_resume_section_order(id_1,id_2) {
	
}

// Swaps item id_1 to id_2's position
function edit_resume_item_order(id_1,id_2) {
	
}

// Displays editing prompts based on this section type
function edit_resume_section(id) {
	
}

// Saves the section after its been edited
function save_resume_section_edit(id) {
	
}

// Adds a new resume item to the specified section id
function add_resume_item(id) {
	
}

// Edits a resume item in line
function edit_resume_item(id) {
	
}

// Saves a resume item after it has been edited
function save_resume_item_edit(id) {
	
}

//</script>