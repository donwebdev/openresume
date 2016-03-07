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
	
	public function __construct($resume,$cover_letter) {
		
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
		
		$output = '
	<header class="container">
		<div class="row">
			<div class="col-md-8">';
	
		# Personal Information	
		if($resume->name!='') {
		
			$output .= '
			<h1>'.$resume->name.'</h1>';
			
		}
	
		if($resume->title!='') {
		
			$output .= '
			<h2>'.$resume->title.'</h2>';
			
		}
		
		# Contact Information
		$output .= '';
	
		if($resume->email!='') {
		
			$output .= '
				<h4><a href="mailto:'.$resume->email.'">'.$resume->email.'</a></h4>';
			
		}
	
		if($resume->phone!='') {
		
			$output .= '
				<h4>'.$resume->phone.'</h4>';
			
		}
	
		if($resume->address_1!='') {
		
			$output .= '
				<h4>'.$resume->address_1.'</h4>';
			
		}
	
		if($resume->address_2!='') {
		
			$output .= '
				<h4>'.$resume->address_2.'</h4>';
			
		}
		
		$output .= '
			</div>';
		
		
		# Get portrait here		
		if($resume->portrait!='') {			
			
			$output .= '
			<div class="col-md-4">
				<img class="img-responsive" src="images/'.$resume->portrait.'">
			</div>
			
			';
			
		}
	
		$output .= '
		</div>	
	</header>
	
	
	
	';			
	
		return $output;
		
	}
	
	public function resume_section($section) {
		
		$output = '
	<div class="container">';
	
		$output .= '
		<h3>'.$section['title'].'</h3>';
		
		$output .= '
	</div>';
		
		return $output;
		
	}
	
	public function resume_item() {
		
	}
	
	public function resume_footer() {
		
	}
	
}


?>