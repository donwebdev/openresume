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

	public $output = 'Form Output';
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
			
			
			# Form type was not set correctly, so die			
			default:
			
				die();
			
		}
		
		
		# If valid create output
		if($this->valid === true) {
			
			$this->output = $form->output;			
		
		
		# If not valid return error
		} else {
		
			# Since the front end form verification should always be right
			# Return generic error text
			$this->output = $this->error_message();
		
		}
	}
	
	
	# Do the validation loop here 
	public function validate($form_array) {
		
		global $db;
		
		foreach ($form_array as $key => $value) {
		
			# Break down the validation string into objects						
			$rules = explode(',',$value['validation']);
			
			$validation = array();
			
			$is_rule_argument = false;
			
			$i = 0;
			$k = 0;
			
			# Break rules into arguments and rule names
			# Put individual arguments into their own array with the rule			
			foreach($rules as $rule_key => $rule) {
				
				# Set array for arguments if it isn't set
				if(!isset($validation[$i]['args'])) {
				
					$validation[$i]['args'] = array();
				
				}
			
				# Check if value is a complete rule with one argument
				if(strpos($rule,'(') !== false && strpos($rule,')') !== false) {
				
					$string = explode('(',$rule);
					
					# Get rid of the trailing parantheses
					$arg = rtrim($string[1],')');
					
					# Only one argument, so add it to the array	as the only element				
					$validation[$i]['args'][$k] = $arg;
					
					$validation[$i]['rule'] = $string[0];
					$i++;
				
				# Check if rule is the start of arguments					
				} elseif(strpos($rule,'(')!== false) {
				
					# This string contains the name of the rule and its first argument
					$string = explode('(',$rule);
				
					$validation[$i]['args'][$k] = $string[1];
					
					$validation[$i]['rule'] = $string[0];
				
					$k++;
				
				# Check if rule is the end of arguments				
				} elseif(strpos($rule,')')!== false) {
					
					# Get rid of the trailing parenthesis				
					$rule = rtrim($rule,')');
					
					$validation[$i]['args'][$k] = $rule;
				
					# No longer in arguments
					$is_rule_argument === false;
					$i++;
					$k = 0;
									
				# Check if rule is in the middle of arguments					
				} elseif($is_rule_argument === true) {
				
					# Value is only the argument					
					$validation[$i]['args'][$k] = $rule;
					
					$k++;				
				
				# Rule doesn't have arguments	
				} else {
					
					$validation[$i]['rule']	= $rule;
									
					$i++;
					
				}
			}
			
			
			
			# Do validation for each validation type supplied
			foreach($validation as $k => $v) {
				
				if(method_exists($this,'validate_'.$v['rule'])) {
					
					$method_name = 'validate_'.$v['rule'];
										
					# Check if post value exists or set a blank string
					if(isset($_POST[$value['name']])) {
						
						$post_value = $_POST[$value['name']];
						
					} else {
						
						$post_value = '';
						
					}
					
					$this->$method_name($post_value,$v['args']);
					
				}				
			}		
		}		
	}
	
	
	# Make this prettier later maybe
	public function error_message($text='')  {
		
		$text = 'Error';
		
		return $text;
		 
	}
	
	
	# Form field must be set
	public function validate_required($value,$conditions) {
				
		if($value=='') {
			
			$this->valid = false;
			
		}			
	}
	
	
	# Form field must have a minimum length
	public function validate_min($value,$conditions) {
		
		$min_length = intval($conditions);
		
		if(strlen($value) < $min_length) {
		
			$this->valid = false;
		
		}		
	}
	
	
	# Form field may not exceed maximum length
	public function validate_max($value,$conditions) {
		
		$max_length = intval($conditions);
		
		if(strlen($value) > $max_length) {
		
			$this->valid = false;
		
		}				
	}
	
	
	# Form field must be a valid email
	public function validate_email($value,$conditions) {
		
		if(filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
			
			$this->valid = false;
			
		}		
	}
	
	
	# 
	public function validate_text($value,$conditions) {
		
		
		
	}
	
}

?>