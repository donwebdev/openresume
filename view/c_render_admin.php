<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_render_admin.php
# Object that renders the proper admin page based
# on the model it was supplied
#
#-------------------------------------------------------

class Admin_Output {
	
	public $output;
	public $model;
	
	# Take the model and return the proper output
	public function __construct($model,$show_menu = true) {
		
		global $user;
	
		$this->model = &$model; 
		
		# Load the login form
		if($this->model->require_login === true) {
	 		
			$login_form = new Login_Form_Output;
			
			$this->output = $login_form->output;
		
		# User is logged in, render the model	
		} elseif($user->logged_in === true) {
		
			# Show menu if not overridden
			if($show_menu === true) {
			
				$this->output = $this->admin_menu();	
				
			}
			
			$method = $this->model->admin_page.'_view';
			
			# Render the view based on the model type			
			if(method_exists($this,$method)) {
				
				$this->$method();
				
			}						
		}		
	}
	
	
	# Methods for each view
	# Using spaghetti so special behaviors can be easily created
	private function resume_view() {
		
		$view = new Admin_Resume_Output($this);
		$this->output .= $view->output;
		
	}
	
	
	private function coverletter_view() {
		
		$view = new Admin_Coverletter_Output;		
		
	}
	
	
	private function messages_view() {
		
		$view = new Admin_Messages_Output;		
		
	}
	
	
	private function analytics_view() {
		
		$view = new Admin_Analytics_Output;		
		
	}
	
	
	private function settings_view() {
		
		$view = new Admin_Settings_Output;		
		
	}
	
	
	# Renders page container start
	public function page_container_start() {
	
		$output = '
	<div class="container-fluid admin_page page_width">	
		';
	
		return $output;	
	
	}
	
	# Renders page container end
	public function page_container_end() {
	
		$output = '
	</div>	
		';
		
		return $output;
		
	}
	
	
	# Renders the admin menu	
	public function admin_menu() {
		
		global $user;
	
		$output = '';	
			
		# User is logged in, render the menu
		if($user->logged_in === true) {
			
		# Menu Container
		$output .= '
	<div class="admin_menu page_width">
		<ul>';
		
		foreach($this->model->admin_pages as $key => $value) {
		
			if((isset($_GET['admin_page']) && $_GET['admin_page'] == $value) || (!isset($_GET['admin_page']) && $value == 'resume')) {
		
				$class = ' class="menu_this_page"';					
				
			} else {
		
				$class = '';
						
			}
			
			$output .= '<li'.$class.'><a href="'.$this->url('admin_page='.$value,'admin_page').'">'.constant('LANG_MENU_'.strtoupper($value)).'</a></li>';
			
		}
		
		
		$output .= '<li class="logout_li"><a href="'.$this->url('logout=1','logout').'" class="logout_link">'.LANG_LOGOUT.'</a></li></ul>';
		
		
		# Menu Container Close
		$output .= '
	</div>'; 
		
		}
	
		return $output;
		
	}
	
	
	# Makes a safe link that takes all url variables into account
	public function url($new_url = '', $accepted_arguments = '', $base_url = '') {
	
		# Simple link to base url
		if ($accepted_arguments == 'clear') {
			return $base_url;
		}
		
		
		# Arguments that may be in the url
		# If $acepted_arguments is blank, all arguments are okay 
		if ($accepted_arguments != '') {
			$variables = explode(',', $accepted_arguments);
			unset($accepted_arguments);
			foreach ($variables as $key => $value) {
				$accepted_arguments[$value] = 1;
			}
		}
		
		
		# Get current URL arguments
		$current_url = $_SERVER['REQUEST_URI'];
		$current_url = explode('?', $current_url);
		if(isset($current_url[1])) {
			$current_url = explode('&', $current_url[1]);
		}
		
		
		# Blow up the current URL
		foreach ($current_url as $key => $value) {
			$argument = explode('=', $value);
			if ($accepted_arguments == '') {
				$url[$argument[0]] = $argument[1];
			} elseif (isset($accepted_arguments[$argument[0]]) && $accepted_arguments[$argument[0]] == 1) {
				$url[$argument[0]] = $argument[1];
			}
		}
		
		
		# Blow up the new URL and overwrite arguments in the current URL
		$new_url = explode('&', $new_url);
		foreach ($new_url as $key => $value) {
			$argument = explode('=', $value);
			if (is_array($accepted_arguments)) {
				if ($accepted_arguments[$argument[0]] == 1) {
					$url[$argument[0]] = rawurlencode($argument[1]);
				}
			} elseif (!is_array($accepted_arguments)) {
				$url[$argument[0]] = rawurlencode($argument[1]);
			}
		}
			
		
		# Build the final url
		$return_url  = $base_url . '?';
		$i           = 1;
		foreach ($url as $key => $value) {
			if ($value != '') {
				if ($i > 1) {
					$return_url .= '&';
				}
				$return_url .= $key . '=' . $value;
				$i++;
			}
		}
		
		
		# Output the final url
		return $return_url;
	}


	
}


?>