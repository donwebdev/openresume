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
	public $validation = 0;
	
	public function __construct($form_name='') {
		
		# Check if a form name is set in get or post
		
		if($form_name == '' && isset($_REQUEST['form_name'])) {
		
			$form_name = $_REQUEST['form_name'];
			
		}
		
		# Act accordingly based on form name
		
		switch($form_name) {
		
			case 'contact_form' :  
			
			break;			
		
			case 'login_form' :  
			
			break;
			
		}
		
			
		
	}
	
	
	
}

?>