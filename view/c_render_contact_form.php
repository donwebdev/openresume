<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# view/c_render_contact_form.php
# Builds contact form based on visitor data
# Also displays contact data depending on resume information
#
#-------------------------------------------------------



class Contact_Form {
	
	private $resume;
	public $output = '';
	
	public function __construct($resume) {

		global $settings;

		# Make this a reference to the resume object instead of a copy
		$this->resume = &$resume;	
		
		# Render contact form
		if($this->resume->show_contact_form==1) {
		
			# Create the contact button
	
			$output .= $this->contact_button();
	
			# Create the contact form
	
			$output .= $this->contact_form();
			
			
		} elseif($this->resume->show_contact_details==1) {
			
			
			# Show contact details at the top of the resume
	
			$output .= $this->contact_info();
			
		}
								
		
	}
	
	
	
	# Determines whether to show a "Contact Me" button or Contact info directly on the resume
	public function contact_button() {

		global $settings;		
				
		# Contact Button - Runs some AJAX that gets contact details and the contact form
		
		$output = '		
			<div class="contact_button_container">
				<a href="javascript:void(0)" class="btn btn-lg contact_button" onclick="">'.CONTACT_ME.' &raquo;</a>';
				
		if($settings->setting['your_location']!='') {					
		
				$output .= '
				<span class="well location">'.LOCATED_IN.' '.$settings->setting['your_location'].'</span>';
				
		}
		
		$output .= '
			</div>';			
						
		return $output;		
				
	}
	
	
	
	# Output a contact form with either the contact information, a contact form, or both
	public function contact_form() {
		
		global $settings;
		$form = new Form;
		
		$output = 'form top';
		
		# Put the contact details at the top of the form
		if($this->resume->show_contact_details==1) {
			$output .= 'contact details';		
		}
				
		return $output;		
		
		
	}
	
	
}

?>