<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_ajax.php
# Ajax object that validates that you're okay to receive
# Ajax and then handles ajax requests
#
#-------------------------------------------------------

class Ajax {
	
	public $visitor;
	private $user;
	private $settings;
	private $resume;
	private $cover_letter;
	public $output = '';
	
	public function __construct($login_required = false) {
	
		global $db;
		
		$this->visitor = new Visitor;
		$this->user = new User;
		$this->settings = new Settings;

		# Die if no request type set
		if(!isset($_GET['request_type'])) { die('1'); }	

		# Validate the visitor or die
		if($this->visitor->id == 0) { die('2'); }
		if($this->visitor->visitor['filtered'] == 1) { die('3'); }	
		
		
		# Validate the impression or die
		if(!isset($_GET['r_id'])) { die('4'); } 
		$text_id = $db->real_escape($_GET['r_id']);
		
		if($db->query('SELECT * FROM impressions WHERE visitor_id = '.$this->visitor->id.' AND text_id = "'.$text_id.'"') == 0) { die(); }		
		
		
		# Validate the user or die if login is required
		if($login_required === true && $user->logged_in === false) { die('5'); }		
		

		# Make the objects that are requested		
		$this->instantiate_objects();		
	
		# Handle the requests
		$this->handle_request();
		
	}
	
	# Figure out which objects we need and make them
	private function instantiate_objects() {
	
		global $db;
	
		# Create a resume object
		if(isset($_GET['resume_id']) && is_numeric($_GET['resume_id'])) {
			
			$this->resume = new Resume($_GET['resume_id']);
			
		}
		
		# Create a cover letter object
		if(isset($_GET['cover_letter_id']) && is_numeric($_GET['cover_letter_id'])) {
			
			$this->cover_letter = new Cover_Letter($_GET['cover_letter_id']);
						
		}
		
			    
	}
	
	# Figure out which ajax handler to run and run it
	# Some objects have ajax output built in to grab
	private function handle_request() {
		
		global $db;

		if(method_exists($this,$_GET['request_type'])) {
		
			$this->output = $this->$_GET['request_type']();
			
		}
		
	}
	
		
	# Sanitize output here so it can be returned in the most compatible way
	public function output() {
		 
		# Remove all extra whitespace and line breaks
		$this->output = trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $this->output));	
		
		# Escape all single quotes
		$this->output = str_replace("'", "\\'",$this->output);
		
		return $this->output;
		
	}
	
	
	# The post handler
	private function post() {
	
	
		$form_controller = new Form_Controller($this);
	
		$output = $form_controller->output;
	
		/*
	
		POST INFO DEBUGGER
	
		$output .= '<br>post<br>';
		
		foreach($_POST as $key => $value) {
		
			$output .= $key.' -> '.$value.'<br>';	
			
		}
	
		*/
		
		return $output;
			
		
	}
	
	
	# Get contact details
	private function contact_details() {
	
		$contact_form = new Contact_Form($this->resume,true);
		
		$contact_form->contact_info_ajax_output();
		
		return $contact_form->ajax_output;
			
		
	}
	
	
}

?>