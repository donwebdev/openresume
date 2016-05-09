<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# view/c_render_admin_login.php
# Create the login and forgotten password forms
# Also does password reset successfully display
#
#-------------------------------------------------------

class Login_Form_Output {
	
	public $output;
	
	# Load the appropriate form based on GET arguments
	public function __construct() {
	
		# Create forgotten password form
		if(isset($_GET['forgotten_password'])) {
			
			$this->output = $this->forgotten_password_form();
		
		# Create reset page	
		} elseif(isset($_GET['password_reset'])) {
			
			$this->output = $this->password_reset();
		
		# Create login form
		} else {
			
			$this->output = $this->login_form();	
		
		}
		
	}

	# Login Form
	public function login_form() {
			
			$form = array();
		
			$i = 0;
							
			$form[$i]['type'] = 'text';
			$form[$i]['name'] = 'email';
			$form[$i]['title'] = LANG_YOUR_EMAIL;
			$form[$i]['validation'] = 'required,email';
			$form[$i]['value'] = '';
			$form[$i]['children'] = '';
			$form[$i]['error_text'] = '';
			$form[$i]['html'] = '';
			$i++;		
							
			$form[$i]['type'] = 'password_field';
			$form[$i]['name'] = 'password';
			$form[$i]['title'] = LANG_YOUR_PASSWORD;
			$form[$i]['validation'] = 'required';
			$form[$i]['value'] = '';
			$form[$i]['children'] = '';
			$form[$i]['error_text'] = '';
			$form[$i]['html'] = '';
			$i++;
		
			$form = new Form('login_form',$form);
		
			$output = '
		<div class="container-fluid login_container">
			
			<h1>'.LANG_LOGIN.'</h1>
			
			';
			
			# Get form fields from form object	
			$output .= $form->form_javascript;		
			$output .= $form->form_header;				
			$output .= $form->fields['email'];
			$output .= $form->fields['password'];
			$output .= $form->submit(LANG_LOGIN_BUTTON);					
			$output .= $form->form_footer;
			
			$output .= '<a href="?forgot_password=1" class="forgot_password right">'.LANG_LOST_PASSWORD.'</a>';
			
			$output .= '
			
			<div id="failure_message" class="failure_message"></div>
			
		</div>
	';
	
		return $output;
			
	}
	
	# Forgotten Password Form
	public function forgotten_password_form() {
			
			$form = array();
		
			$i = 0;
							
			$form[$i]['type'] = 'text';
			$form[$i]['name'] = 'email';
			$form[$i]['title'] = LANG_YOUR_EMAIL;
			$form[$i]['validation'] = 'required,email';
			$form[$i]['value'] = '';
			$form[$i]['children'] = '';
			$form[$i]['error_text'] = '';
			$form[$i]['html'] = '';
			$i++;		
			
			$form = new Form('forgotten_password_form',$form);
		
			$output = '
		<div class="container-fluid forgotten_password_container">
			
			<h1>'.LANG_FORGOTTEN_PASSWORD.'</h1>
			
			';
			
			# Get form fields from form object	
			$output .= $form->form_javascript;		
			$output .= $form->form_header;				
			$output .= $form->fields['email'];
			$output .= $form->submit(LANG_RESET_PASSWORD);					
			$output .= $form->form_footer;
			
			$output .= '<a href="'.$settings->setting['admin_url'].'" class="forgot_password right">'.LANG_BACK_TO_LOGIN.'</a>';
			
			$output .= '
			
		</div>
	';
	
		return $output;
	
	}
	
	# Password Reset Notification
	public function password_reset() {
	
	
	}

}

?>
