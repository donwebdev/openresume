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
	public $display_type;
	public $style;
	public $name;
	public $address_1;
	public $address_2;
	public $phone;
	public $email;
	public $title;
	public $portrait;

	public function __construct($resume_id='') {
	
		global $db;	
		global $settings;
		
		# If resume id is set we load that resume
		if(isset($_GET['resume_id']) && is_numeric($_GET['resume_id'])) {
			
			$resume_id = $_GET['resume_id'];
			
		}
		
		# If resume isn't set, load the main resume
		if($resume_id=='') {
		
			$resume_row = $db->get_row('SELECT * FROM resumes WHERE display_type = "Main"');
			$resume_id = $resume_row->id;
			
			# Since we're looking at the main resume we load the secondary resumes too.
			$secondary_resumes = $db->get_results('SELECT id FROM resumes WHERE display_type = "Secondary" ORDER BY secondary_resume_order ASC');	
			
			# Create new resume objects here
			# The view will check for these and render them as well
			foreach($secondary_resumes as $key => $value) {
				
				$this->secondary_resumes[$value->id] = new Resume($value->id);	
				
			}
				
		
		# Get one resume by id	
		} else {
		
			$resume_row = $db->get_row('SELECT * FROM resumes WHERE id = '.$resume_id);				
						
		}
		
		# If resume is deleted just return here and don't load anything
		if($resume_row->deleted !== null) {
			
			return;
			
		}
		
		# Set up the needed variables here, lot of text, but convenient later
		$this->display_type = $resume_row->display_type;
		$this->style = $resume_row->style;
		$this->resume_name = $resume_row->name;
		$this->title = $resume_row->title;
		$this->portrait = $resume_row->portrait;	
		
		# Check for resume overrides, kind of a bowl of spaghetti but still simple
		# I would normally put this in a loop, but it's a small amount of functionality
		if($resume_row->override_name!==null) { $this->name = $resume_row->override_name; } else { $this->name = $settings->setting['your_name']; }
		if($resume_row->override_address_1!==null) { $this->address_1 = $resume_row->override_address_1; } else { $this->address_1 = $settings->setting['your_address_1']; }
		if($resume_row->override_address_2!==null) { $this->address_2 = $resume_row->override_address_2; } else { $this->address_2 = $settings->setting['your_address_2']; }
		if($resume_row->override_phone!==null) { $this->phone = $resume_row->override_phone; } else { $this->phone = $settings->setting['your_phone']; }
		if($resume_row->override_email!==null) { $this->email = $resume_row->override_email; } else { $this->email = $settings->setting['your_email']; }
		
		
		# Get resume sections
		
		$resume_sections_results = $db->get_results('SELECT id,item_order FROM resume_sections WHERE resume_id = '.$resume_id.' ORDER BY item_order ASC');	
		
		foreach($resume_sections_results as $row) {
			
			
				$this->resume_sections[$row->item_order] = $this->resume_section($row->id);
				
		}	
	}
	
	# We do the logic here for each section type
	# Load all the sub items for each section
	# Give the view everything it needs to render this section
		
	private function resume_section($section_id) {
		
		global $db;
		
		$output_array = array();
		
		$section = $db->get_row('SELECT * FROM resume_sections WHERE id = '.$section_id);		
	
		$section_items = $db->get_results('SELECT * FROM resume_items WHERE resume_section_id = '.$section->id.' ORDER BY item_order ASC');
		
		$k = $section->item_order;
		
		# Section fields the view needs
		$output_array['title'] = $section->title;
		$output_array['sub_title'] = $section->sub_title;
		$output_array['description'] = $section->description;
		$output_array['section_type'] = $section->section_type;
		
		# Section item array for the view
		$output_array['section_items'] = array();
		
		# Simple resume items that just list in order with no additional behavior
		# These types are mainly differiantiated in the view
		if($section->section_type=='Text' || $section->section_type=='Bullet Points') {
						
			foreach($section_items as $row) {
		
				$output_array['section_items'][$row->item_order]['value'] = $row->value;				
				
	
				# Get item type for this item if it has one
				if($row->resume_item_type_id !== null) {
							
					$item_type = $db->get_row('SELECT * FROM resume_item_types WHERE id = '.$item['resume_item_type_id']);							
					$output_array['section_items'][$row->item_order]['item_type'] = $item_type->name;
				
														
				}
			
			}
			
		}
		
		
		# Next item type will go here
		
		
		
		return $output_array;
		
	}
	
}


?>