<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# controller/c_contact_controller.php
# Validates and submits the contact form
#
#-------------------------------------------------------


class Contact_Form_Controller {
	
	public $output = 'Contact Form Output';	
	private $form_controller;	
	private $contact_form;

	public function __construct($form_controller) {
		
		global $visitor;

		# Make a reference to form controller		
		$this->form_controller = &$form_controller;
		
		# Check to make sure resume id is set, if not stop
		if(isset($_POST['resume_id']) && is_numeric($_POST['resume_id'])) {
			
			$resume = new Resume($_POST['resume_id']);
			
		} else {
		
			# Someone is tampering with the form submission, so die.
			die();
			
		}
		
		# Create a contact form object to get the form array
		$this->contact_form = new Contact_Form($resume,true);	
		
		# Check to see if this visitor is spamming
		$this->spam_check();
		
		# Validate the post data based on conditions
		$data = $this->form_controller->validate($this->contact_form->form_fields());
		
		# Post the data into the database
		if($form_controller->valid === true) {
			
			$this->success($data);
			
		}
	
	
	}

	# Check for spam
	private function spam_check() {
	
		global $visitor;
		
		$is_spam = false;
		
		# No spammers here please
		if($is_spam === true) ( die() );
		
	}
	
	# Validate each field to do any special checks we need
	private function validate($form_array) {
  		
		$this->form_controller($form_array);
		
	}
	
	# Insert data into database
	# Send email to site owner
	private function success($data) {	
	
		global $db;
  		
		$this->output = $this->contact_form->success_message();
		
		
	}


}
	


?>