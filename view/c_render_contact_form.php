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
	public $ajax_output = '';
	
	public function __construct($resume) {

		global $settings;

		# Make this a reference to the resume object instead of a copy
		$this->resume = &$resume;	
		
		# Render contact form
		if($this->resume->show_contact_form==1) {
		
			# Create the contact button
	
			$this->output .= $this->contact_button();
	
			# Create the contact form
	
			$this->output .= $this->contact_form();
			
			
		} elseif($this->resume->show_contact_details==1) {
			
			
			# Show contact details at the top of the resume
	
			$this->output .= $this->contact_info();
			
		}
								
		
	}
	
	
	
	# Determines whether to show a "Contact Me" button or Contact info directly on the resume
	public function contact_button() {

		global $settings;		
	
		$output = '';
				
		# Contact Button - Runs some AJAX that gets contact details and the contact form
		
		$output .= '		
			<div class="contact_button_container">
				<a href="javascript:void(0)" class="btn btn-lg contact_button" onclick="contact_form_toggle('.$this->resume->id.','.$this->resume->show_contact_details.')">'.CONTACT_ME.' &raquo;</a>';
				
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
	
		$output = '';
		$i = 0;
						
		$form[$i]['field_type'] = 'text';
		$form[$i]['field_name'] = 'name';
		$form[$i]['field_required'] = true;
		$form[$i]['field_value'] = '';
		$form[$i]['field_children'] = '';
		$form[$i]['field_error_text'] = '';
		$form[$i]['field_error_conditions'] = '';
		$form[$i]['field_html'] = '';
		$i++;
		
		$form = new Form('contact_form',$form);
		
		# Determine if we're showing the Contact Details on the form		
		
		if($this->resume->show_contact_details==1 && ($this->resume->show_phone == 1 || $this->resume->show_email == 1 || $this->resume->show_address == 1)) {
		
			$show_details = true;
			$details_class = 'contact_form_show_details';
		
		} else {
		
			$show_details = false;
			$details_class = 'contact_form_hide_details';
				
		}
		
		
		# Form wrapper starts here
		
		$output .= '
			<div class="overlay" id="contact_form_overlay_'.$this->resume->id.'" onclick="contact_form_toggle('.$this->resume->id.','.$this->resume->show_contact_details.')"></div>
			<div class="contact_form '.$details_class.'" id="contact_form_'.$this->resume->id.'">';
		
		
		# Put the contact details at the top of the form if we're supposed to
		# Don't show this if nothing is set to show
		
		if($show_details === true) {
			
			$output .= '
				<h2 class="contact_form_header">'.CONTACT_ME.'</h2>
					<div class="contact_form_details" id="contact_form_details_'.$this->resume->id.'">				
					</div>';
					
		}
		
		
		# Create the contact form
		
		$output .= '<h2 class="contact_form_header">'.SEND_ME_A_MESSAGE.'</h2>';
		
		
		# End form wrapper
		
		$output .= '
			</div>';
				
		return $output;		
		
		
	}
	
	# Output list of contact info if the setting is set
	public function contact_info() { 
	
		global $settings;
	
		$output = '';
	
		if($this->resume->show_contact_details==1) {
	
	
		}
		
		return $output;
		
	}
	
	# Ajax output
	public function contact_info_ajax() { 
	
		global $settings;
	
		if($this->resume->show_phone == 1) {
		
		$this->ajax_output .= '
						<div class="contact_form_phone">
							'.$this->resume->phone.'
						</div>';
			
		}
		
		if($this->resume->show_email == 1) {
		
		$this->ajax_output .= '
						<div class="contact_form_email">
							<a href="'.$this->resume->email.'" class="contact_form_email_link">'.$this->resume->email.'</a>							
						</div>';
			
		}
		
		if($this->resume->show_address == 1) {
		
		$this->ajax_output .= '
						<div class="contact_form_address">
							<div class="contact_form_address_1">'.$this->resume->address_1.'</div>
							<div class="contact_form_address_2">'.$this->resume->address_2.'</div>		
						</div>';
			
		}
		
	}
	
}

?>