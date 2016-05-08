<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# controller/c_login_controller.php
# Processes login information and sends ajax output
# Spawns a user controller to figure out what to do 
#
#
#-------------------------------------------------------


class Login_Form_Controller {
	
	public $output = 'Login Form Output';		
	private $form_controller;	
	
	function __construct($form_controller) {
		
		global $user;
		
		# Make a reference to form controller		
		$this->form_controller = &$form_controller;
		
		# Process a login request and send the appropriate ajax request
		if(isset($_POST['email']) && isset($_POST['password'])) {

			$user->user_login($_POST['email'],$_POST['password']);
			
			# Return whether login failed or not
			if($user->logged_in === true) {
				
				$this->output = 'Login Successful';
				
			} else {
				
				$this->output = 'Login Failed';
				
			}
		}
		
		# Process a forgotten password request
		if(isset($_POST['email']) && $_POST['form_name'] == 'forgotten_password_form') {
			
			
			
		}

	}	
	
}



?>