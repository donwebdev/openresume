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
	
	public function __construct($resume,$ajax=false) {

		# Make this a reference to the resume object
		$this->resume = &$resume;	

		# Don't render form if we only need this object for ajax
		if($ajax === false) {
		
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
	}
	
	
	
	# Determines whether to show a "Contact Me" button or Contact info directly on the resume
	public function contact_button() {

		global $settings;		
	
		$output = '';
				
		# Contact Button - Runs some AJAX that gets contact details and the contact form		
		$output .= '		
			<div class="contact_button_container">
				<a href="javascript:void(0)" class="btn btn-lg contact_button" onclick="contact_form_toggle('.$this->resume->id.','.$this->resume->show_contact_details.'); '.$this->contact_info_ajax().'">'.LANG_CONTACT_ME.' &raquo;</a>';
				
		if($settings->setting['your_location']!='') {					
		
				$output .= '
				<span class="well location">'.LANG_LOCATED_IN.' '.$settings->setting['your_location'].'</span>';
				
		}
		
		$output .= '
			</div>';			
						
		return $output;		
				
	}
	
	
	
	# Output a contact form with either the contact information, a contact form, or both
	public function contact_form() {
	
		$output = '';
		
		$form = $this->form_fields();
		
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
			<div class="contact_form contact_form_hidden '.$details_class.'" id="contact_form_'.$this->resume->id.'">
				<div class="contact_form_top"><button class="btn btn-secondary right contact_form_close_button" type="submit" onclick="contact_form_toggle('.$this->resume->id.','.$this->resume->show_contact_details.')">X</button></div>	
		';
		
		
		# Put the contact details at the top of the form if we're supposed to
		# Don't show this if nothing is set to show		
		if($show_details === true) {
			
			$output .= '
				<h2 class="contact_form_header">'.LANG_CONTACT_ME.'</h2>
					<div class="contact_form_details" id="contact_form_details_'.$this->resume->id.'">				
					</div>';
					
		}
		
		
		# Create the contact form		
		$output .= '
				<h2 class="contact_form_header">'.LANG_SEND_ME_A_MESSAGE.'</h2>';
		
		
		# Get form fields from form object	
		$output .= $form->form_javascript;		
		$output .= $form->form_header;				
		$output .= $form->fields['resume_id'];		
		$output .= $form->fields['name'];
		$output .= $form->fields['email'];				
		$output .= $form->fields['message'];		
		$output .= $form->submit(LANG_SEND_MESSAGE);					
		$output .= $form->form_footer;
				
		
		# End form wrapper		
		$output .= '
			</div>';
				
		return $output;		
		
		
	}
	
	# Output list of contact info if the setting is set
	public function contact_info() { 
	
		$output = '';
	
		if($this->resume->show_contact_details==1) {
					
			$output .= '
				<div class="contact_details" id="contact_form_details_'.$this->resume->id.'">';				
				
			$output .= '
					<script type="text/javascript">
						$(function() {
							'.$this->contact_info_ajax().'
						});						
					</script>
					';			
				
			$output .= '
				</div>';
		
		}
		
		return $output;
		
	}
	
	# Build ajax function
	public function contact_info_ajax() { 
	
		global $visitor;
	
		return "ajax_request('contact_details','".$visitor->impression_id."','&resume_id=".$this->resume->id."','contact_form_details_".$this->resume->id."','none','none');";
	
	}
	
	
	# Ajax output
	public function contact_info_ajax_output() { 
	
		# Create a wrapper if email or phone are set
		if($this->resume->show_email == 1 || $this->resume->show_phone == 1) {
	
				
			$this->ajax_output .= '
							<div class="contact_form_email_phone_container">';
	
		
			if($this->resume->show_email == 1) {
				
				$this->ajax_output .= '
								<div class="contact_form_email">
									<a href="mailto:'.$this->resume->email.'" class="contact_form_email_link">'.$this->resume->email.'</a>							
								</div>';
					
				}
				
			
				if($this->resume->show_phone == 1) {
				
				
				$this->ajax_output .= '
								<div class="contact_form_phone">
									'.$this->resume->phone.'
								</div>';
					
				}					
			
			$this->ajax_output .= '
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
	
	
	# Message for when form creation was successful
	public function success_message() {
  		
		# Simple thank you message with a script that automatically closes the dialog		
		return '
			
			<script type="text/javascript">
			
				var contact_countdown = 3;
			
				$( document ).ready(function() {
					
					contact_countdown_interval = setInterval(function() {
						contact_countdown--;
						if(contact_countdown < 1) {
							
							if($("#contact_form_'.$this->resume->id.'").is(":visible")) {
								contact_form_toggle('.$this->resume->id.','.$this->resume->show_contact_details.');
							}							
							
							clearInterval(contact_countdown_interval);
							
							$("#contact_thank_you_message").html("")
							
						} else {
							$("#contact_form_countdown").html(contact_countdown);
						}
						
						
					},1000);
					
				});
				
			</script>
			
			<div class="bs-callout bs-callout-success contact_success_message">
				<h4>
					'.LANG_CONTACT_SUCCESS.'
				</h4>
				<div class="contact_thank_you_message">
					'.LANG_CONTACT_MESSAGE_RECEIVED.'
				</div>
				<div class="contact_thank_you_message" id="contact_thank_you_message">
					<a class="cursor_hand" onclick="contact_form_toggle('.$this->resume->id.','.$this->resume->show_contact_details.');">
						'.LANG_CONTACT_MESSAGE_CLOSE.'
						<span id="contact_form_countdown">3</span>
					</a>
				</div>
			</div>
			
			';
		
	
	}
	
	
	# Create form fields array
	public function form_fields() {
	
		$form = array();
	
		$i = 0;
						
		$form[$i]['type'] = 'hidden';
		$form[$i]['name'] = 'resume_id';
		$form[$i]['title'] = '';
		$form[$i]['validation'] = '';
		
		if(isset($this->resume->id)) {
			$form[$i]['value'] = $this->resume->id;
		} else {
			$form[$i]['value'] = '';			
		}
		
		$form[$i]['children'] = '';
		$form[$i]['error_text'] = '';
		$form[$i]['html'] = '';
		$i++;
						
		$form[$i]['type'] = 'text';
		$form[$i]['name'] = 'name';
		$form[$i]['title'] = LANG_YOUR_NAME;
		$form[$i]['validation'] = 'required,min(3)';
		$form[$i]['value'] = '';
		$form[$i]['children'] = '';
		$form[$i]['error_text'] = '';
		$form[$i]['html'] = '';
		$i++;
						
		$form[$i]['type'] = 'text';
		$form[$i]['name'] = 'email';
		$form[$i]['title'] = LANG_YOUR_EMAIL;
		$form[$i]['validation'] = 'required,email';
		$form[$i]['value'] = '';
		$form[$i]['children'] = '';
		$form[$i]['error_text'] = '';
		$form[$i]['html'] = '';
		$i++;
						
		$form[$i]['type'] = 'textarea';
		$form[$i]['name'] = 'message';
		$form[$i]['title'] = LANG_YOUR_MESSAGE;
		$form[$i]['validation'] = 'required';
		$form[$i]['value'] = '';
		$form[$i]['children'] = '';
		$form[$i]['error_text'] = '';
		$form[$i]['html'] = '';
		
		return $form;
		
	}
	
}

?>