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
		$this->output = $this->resume_header($resume,$cover_letter,$contact_form);
		
		
		# Iterate the section arrays to make the sections
		foreach($resume->resume_sections as $section) {
			
			$this->output .= $this->resume_section($section); 
			
		}
		
		# Make the footer
		
		
		
		
	}
	
	
	# Header HTML
	public function resume_header($resume,$cover_letter,$contact_form) {
		
		global $settings;
		
		$output = '
	<header class="row resume_header" id="resume_header">';
			
		# Get portrait here		
		if($resume->portrait!='') {			
			
			$output .= '
				<img class="img-responsive media-object portrait" src="images/'.$resume->portrait.'">
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
	
	
	if($settings->setting['fixed_header'] == 1) {
		
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
	<div class="row section">';
		
		# Section type specific behavior here
		
		if($section['section_type']=='Bullet Points') {
			
			$output .= '
		<h3 class="section_name section_bullet_points">'.$section['title'].'</h3>';
			
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
			
			$output .= '
		<h3 class="section_name">'.$section['title'].'</h3>';
			
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
			<p>'.$item['value'].'</p>';
		
		}
		
	
		# Bullet Points
		elseif($section['section_type']=='Bullet Points') {
		
			$output = '
				<li>'.$item['value'].'</li>';
		
		}
		
		else {
		
			$output = '
				'.$item['value'];
			
			
		}		
		
		return $output;
		
	}
	
	public function resume_footer() {
		
	}
	
}


?>