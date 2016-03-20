<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# controller/c_form_controller.php
# Spawns the appropriate form controller
#
#-------------------------------------------------------


class Form_Controller {

	public $output = 'form output';
	public $valid = true;
	
	public function __construct($form_name='') {
		
		# Check if a form name is set in get or post
		
		if($form_name == '' && isset($_REQUEST['form_name'])) {
		
			$form_name = $_REQUEST['form_name'];
			
		}
		
		# Act accordingly based on form name
		
		switch($form_name) {
		
			case 'contact_form' :  
	
				$form = new Contact_Form_Controller($this);
			
			break;			
		
			case 'login_form' :  
			
				
			
			break;
			
			
			# Form type was not set, so die			
			default:
			
				die();
			
		}
		
		
		# If valid create output
		
		if($this->valid === true) {
			
			$this->output = $form->output;			
		
		# If not valid return error
			
		} else {
		
			$this->output = $this->error_message();
		
		}
		
		# Since the front end form verification should always be right
		# Return generic error text
			
		
	}
	
	# Do the validation loop here 
	public function validate($form_array) {
		
	}
	
	# Make this prettier later maybe
	public function error_message($text='')  {
		
		$text = 'Error';
		
		return $text;
		 
	}
	
	
}

?>