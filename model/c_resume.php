<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_resume.php
# Load all data and structures to build a resume object
#
#-------------------------------------------------------


class Resume {

	public $secondary_resumes = array();
	public $resume_sections = array();		

	public function __construct($resume_id='') {
	
			global $db;		
		
			# If resume id is set we load that resume
			if(isset($_GET['resume_id']) && is_numeric($_GET['resume_id'])) {
				
				$resume_id = $_GET['resume_id'];
				
			}
		
			# If resume isn't set, load the main resume
			if($resume_id=='') {
		
				$resume_row = $db->get_row('SELECT * FROM resumes WHERE display_type = "Main"');
				$resume_id = $resume_row->id;
				
				# Since we're looking at the main resume we load the secondary resumes too.
				$secondary_resumes = $db->get_results('SELECT id FROM resumes WHERE display_type = "Secondary"');	
				
				# Create new resume objects here
				# The view will check for these and render them as well
				foreach($secondary_resumes as $key => $value) {
					
					$this->secondary_resumes[$value->id] = new Resume($value->id);	
					
				}
					
			
			# Get one resume by id	
			} else {
		
				$resume_row = $db->get_row('SELECT * FROM resumes WHERE id = '.$resume_id);				
							
			}
		
			
			# Get resume sections
		
			$resume_sections = $db->get_results('SELECT id,item_order FROM resume_sections WHERE resume_id = '.$resume_id.' ORDER BY item_order ASC');	
			
			foreach($resume_sections as $row) {
					
					$this->resume_sections[$row->item_order] = new resume_section($row->id);	
				
			}
	
	
	
	}
	
	# We do the logic here for each section type
	# Load all the sub items for each section
	# Give the view everything it needs to render this section
		
	private function resume_section($section_id) {
		
		global $db;
		
		$section = $db->get_row('SELECT * FROM resume_sections WHERE id = '.$section_id);		
	
		$section_items = $db->get_results('SELECT * FROM resume_items WHERE resume_id = '.$resume_id.' ORDER BY item_order ASC');
		
		$k = $section->item_order;
		
		# Section fields the view needs
		$this->resume_sections[$k]['title'] = $section->title;
		$this->resume_sections[$k]['sub_title'] = $section->sub_title;
		$this->resume_sections[$k]['description'] = $section->description;
		
		# Section item array for the view
		$this->resume_sections[$k]['section_items'] = array();
		
		# Simple resume items that just list in order with no additional behavior
		# These types are mainly differiantiated in the view
		if($section->section_type=='Text' || $section->section_type=='Bullet Points') {
		
			foreach($section_items as $row) {
		
				$this->resume_sections[$k]['section_items'][$row->item_order]['value'] = $row->value;				
				
	
				# Get item type for this item if it has one
				if($row->resume_item_type_id !== null) {
							
					$item_type = $db->get_row('SELECT * FROM resume_item_types WHERE id = '.$item['resume_item_type_id']);							
					$this->resume_sections[$k]['section_items'][$row->item_order]['item_type'] = $item_type->name;
				
														
				}
			
			}
			
		}
		
		
		# Next item type will go here
		
		
		
	}
	
}


?>