<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_admin.php
# Object that loads the right model for the admin page
#
#-------------------------------------------------------


class Admin {
	
	public $output;
	public $require_login = true;
	public $admin_pages = array('resume','coverletter','messages','analytics','settings');
	public $admin_page;
	
	# Check for login, then load the appropriate model
	public function __construct() {
			
		if($this->login_check() === true) {
		
			$this->admin_model();
						
		}			
	}
	
	
	# Check if logged in
	# If not logged in, load the login controller view
	private function login_check() {
	
		global $user;
		
		if($user->logged_in === true) {
			
			$this->require_login = false;
			return true;				
	
		}
	}
	
	# Calls the method to create the appropriate admin model
	private function admin_model() {	
		
		if(isset($_GET['admin_page'])) {
			$admin_page = $_GET['admin_page'];
		} else {
			$admin_page = 'resume';	
		}
		
		$method = $admin_page.'_model';
		$this->admin_page = $admin_page;
		
		if(method_exists($this,$method) && in_array($admin_page,$this->admin_pages)) {
		
		
			$this->$method();	
			
		}		
	}
	
	# Run the correct model and do the correct arguments
	# This is spaghetti so extra conditions can be added later
	
	private function resume_model() {
		
		$this->output = new Admin_Resume($this);
		
	}
	
	
	private function coverletter_model() {
		
		$this->output = new Admin_Coverletter;		
		
	}
	
	
	private function messages_model() {
		
		$this->output = new Admin_Messages;		
		
	}
	
	
	private function analytics_model() {
		
		$this->output = new Admin_Analytics;		
		
	}
	
	
	private function settings_model() {
		
		$this->output = new Admin_Settings;		
		
	}
	
	public function columns_to_array($row,$columns) {
		
		$output = array();
		
		# Iterate through each item in the row
		foreach($row as $field_name => $field_value) {
		
			# Iterate through the columns array to check for matches
			foreach($columns as $column_key => $column) {
			
				# Column matches field name
				if($field_name == $column['field_name']) {
			
					# Add the the value to the output array	
					$output[$field_name] = $field_value;	
					
				}					
			}			
		}
		
		return $output;		
	}		
}



?>