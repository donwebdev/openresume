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
	
	public function __construct($resume,$cover_letter,$contact_form) {
		
		global $db;
		global $settings;
		global $cover_letter;
		
		# Make the header
		$this->output = $this->resume_header($resume,$cover_letter);
		
		
		# Iterate the section arrays to make the sections
		foreach($resume->resume_sections as $section) {
			
			$this->output .= $this->resume_section($section); 
			
		}
		
		
		
		# Make the footer
		
	}
	
	
	# Header HTML
	public function resume_header($resume,$cover_letter) {
		
		global $settings;
		
		$output = '
	<header class="row resume_header">';
			
		# Get portrait here		
		if($resume->portrait!='') {			
			
			$output .= '
				<img class="img-responsive pull-right media-object portrait" src="images/'.$resume->portrait.'">
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
		
	
		$output .= '
			</div>';
	
	
		# Contact Button - Runs some AJAX that gets contact details and the contact form
		
		$output .= '
		
			<div class="contact_button_container">
				<a href="javascript:void(0)" class="btn btn-lg contact_button" onclick="">'.CONTACT_ME.' &raquo;</a>';
				
		if($settings->setting['your_location']!='') {		
		
		
				$output .= '
				<span class="well location">'.LOCATED_IN.' '.$settings->setting['your_location'].'</span>';
				
		}
		
		$output .= '
			</div>';	
			
				
		
	$output .= '
	</header>';	
	
		return $output;
		
	}
	
	public function resume_section($section) {
		
		$output = '
	<div class="row">';
	
	
		$output .= '
		<h3 class="section_name">'.$section['title'].'</h3>';
		
		# Section type specific behavior here
		
		if($section['section_type']=='Bullet Points') {
		
			$output .= '
			<ul>';		
		
			# Load all the resume section items normally
			
			foreach($section['section_items'] as $key => $value) {
			
				$output .= $this->resume_item($section,$value);	
				
			}
		
			$output .= '
			</ul>';		
		
		
		# Normal behavior if no type is matched
			
		} else {			
		
			# Load all the resume section items normally
			
			foreach($section['section_items'] as $key => $value) {
			
				$output .= $this->resume_item($section,$value);	
				
			}
			
		}
		
		
		$output .= '
	</div>';
		
		return $output;
		
	}
	
	public function resume_item($section,$item) {
		
		# Text
		if($section['section_type']=='Text') {
		
			$output = '
			<p class="resume_item">'.$item['value'].'</p>';
		
		}
		
	
		# Bullet Points
		if($section['section_type']=='Bullet Points') {
		
			$output = '
				<li class="resume_item_list">'.$item['value'].'</li>';
		
		}
		
	
		
		return $output;
		
	}
	
	public function resume_footer() {
		
	}
	
}


?>