<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# view/c_render_resume.php
# Creates all HTML/Javascript needed to render a resume.
# Based off of the resume model object.
#
#-------------------------------------------------------


class Resume_Output {
	
	public $output;
	public $admin;
	
	public function __construct($resume, $cover_letter, $contact_form, $admin = false) {
		
		global $db;
		global $settings;
		
		# Set the boolean if this is on the admin panel or not
		$this->admin = $admin;
		
		# Make the header
		$this->output = $this->resume_header($resume,$cover_letter,$contact_form);		
		
		# Iterate the section arrays to make the sections
		foreach($resume->resume_sections as $section) {
			
			$this->output .= $this->resume_section($section); 
			
		}
				
		# Make the footer		
		$this->output .= $this->resume_footer();				
		
	}
	
	
	# Header HTML
	public function resume_header($resume,$cover_letter,$contact_form) {
		
		global $settings;
		
		$output = '
	<div class="resume_container">
	<div class="container-fluid">	
	<header class="row resume_header" id="resume_header">';
			
		# Get portrait here		
		if($resume->portrait!='') {			
			
			$output .= '
				<img class="img-responsive media-object portrait" src="'.$settings->setting['site_url'].'/images/'.$resume->portrait.'">
			';
			
		}	
			
			$output .= '
			<div class="media-body contact_info_container">
			';
	
		# Personal Information	
		if($resume->name!='') {
		
			$output .= '
				<h1 class="resume_name">'.$resume->name.'</h1>';
			
		}
	
		if($resume->title!='') {
		
			$output .= '
				<h2 class="resume_title">'.$resume->title.'</h2>';
			
		}
		
	
		# Contact Button - Runs some AJAX that gets contact details and the contact form		
		$output .= $contact_form->output;
	
		$output .= '
			</div>';
				
		
	$output .= '
	</header>';	
	
	
	if($settings->setting['fixed_header'] == 1 && $this->admin === false) {
		
		$output .= '
	<div id="resume_fixed_header" class="resume_fixed_header resume_fixed_header_hidden">
		<div class="resume_fixed_header_content">';
	
		# Contact Button - Runs some AJAX that gets contact details and the contact form		
		$output .= $contact_form->output;
	
		# Get portrait here		
		if($resume->portrait!='') {			
			
			$output .= '
			<img class="img-responsive media-object portrait" src="images/'.$resume->portrait.'">
			';
			
		}	
		
		
		# Personal Information	
		if($resume->name!='') {
		
			$output .= '
			<h1 class="resume_name">'.$resume->name.'</h1>';
			
		}
	
		if($resume->title!='') {
		
			$output .= '
			<h2 class="resume_title">'.$resume->title.'</h2>';
			
		}
		
		$output .= '
		</div>
	</div>';
		
		
	}
	
		return $output;
		
	}
	
	
	public function resume_section($section) {
		
		$output = '
	<div class="row section" id="section_container_'.$section['id'].'" order="'.$section['order'].'">';
		
		# Section type specific behavior here
		
		if($section['section_type']=='Bullet Points') {
			
			$output .= '
		<h3 class="section_name section_bullet_points" id="section_title_'.$section['id'].'">'.$section['title'].'</h3>';
			
			$output .= '
			<ul id="section_ul_'.$section['id'].'">';		
		
			# Load all the resume section items normally
			
			foreach($section['section_items'] as $key => $value) {
			
				$output .= $this->resume_item($section,$value);	
				
			}
		
			$output .= '
			</ul>';		
		
		
		# Normal behavior if no type is matched
			
		} else {			
		
			# Load all the resume section items normally			
			$output .= '
		<h3 class="section_name" id="section_title_'.$section['id'].'">'.$section['title'].'</h3>
		';
			
			foreach($section['section_items'] as $key => $value) {
			
				$output .= $this->resume_item($section,$value);	
				
			}			
		}
		
		
		$output .= '
	</div>';
		
		# Load the section edit controls
		if($this->admin === true) {
			
			$output .= $this->edit_section($section['id'],$section['section_type']);
			
		}
		
		return $output;
		
	}
	
	public function resume_item($section,$item) { 
		
		# Text
		if($section['section_type']=='Text') {
		
			$output = '
			<p id="item_'.$item['id'].'" order="'.$item['order'].'" section="'.$section['id'].'">'.$item['value'].'</p>';
		
		}
		
	
		# Bullet Points
		elseif($section['section_type']=='Bullet Points') {
		
			$output = '
				<li id="item_'.$item['id'].'" order="'.$item['order'].'" section="'.$section['id'].'">'.$item['value'].'</li>';
		
		}
		
		else {
		
			$output = '
				'.$item['value'];			
			
		}	
		
		# Load the item edit controls
		if($this->admin === true) {
			
			$output .= $this->edit_item($item['id'],$section['section_type']);
			
		}	
		
		return $output;
		
	}
	
	public function resume_footer() {
	
		$output =  '
	</div></div>';
	
		return $output;
		
	}
	
	# Admin edit functions
	# Most of the editing actually happens in javascript/ajax
	# This just populates the html
	public function edit_section($id,$type) {
	
		$output = '		
	<div class="admin_edit_section" id="edit_section_'.$id.'">Edit Section</div>
	
	';
		
		return $output;
		
	}
	
	public function edit_item($id,$type='') {
		
		$output = '		
			<div class="admin_edit_item" id="edit_item_'.$id.'">Edit Item</div>			
			';
		
		return $output;
		
	}
	
	
}


?>