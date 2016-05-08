<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# admin/login.php
# Create the login form here, displays all states of the login form
# Also does forgot password form
#
#-------------------------------------------------------

$admin_output = '';

# Login Form
if(!isset($_GET['forgot_password']) && !isset($_GET['password_reset'])) {
		
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
	
		$admin_output .= '
	<div class="container-fluid login_container">
		
		<h1>'.LANG_LOGIN.'</h1>
		
		';
		
		# Get form fields from form object	
		$admin_output .= $form->form_javascript;		
		$admin_output .= $form->form_header;				
		$admin_output .= $form->fields['email'];
		$admin_output .= $form->fields['password'];
		$admin_output .= $form->submit(LANG_LOGIN_BUTTON);					
		$admin_output .= $form->form_footer;
		
		$admin_output .= '<a href="?forgot_password=1" class="forgot_password right">'.LANG_LOST_PASSWORD.'</a>';
		
		$admin_output .= '
		
		<div id="failure_message" class="failure_message"></div>
		
	</div>
';
		
}

# Forgotten Password Form
elseif(isset($_GET['forgot_password']) && $_GET['forgot_password'] != '') {
		
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
	
		$admin_output .= '
	<div class="container-fluid forgotten_password_container">
		
		<h1>'.LANG_FORGOTTEN_PASSWORD.'</h1>
		
		';
		
		# Get form fields from form object	
		$admin_output .= $form->form_javascript;		
		$admin_output .= $form->form_header;				
		$admin_output .= $form->fields['email'];
		$admin_output .= $form->submit(LANG_RESET_PASSWORD);					
		$admin_output .= $form->form_footer;
		
		$admin_output .= '<a href="'.$settings->setting['admin_url'].'" class="forgot_password right">'.LANG_BACK_TO_LOGIN.'</a>';
		
		$admin_output .= '
		
	</div>
';


}

# Password Reset Notification
elseif(isset($_GET['forgot_password']) && $_GET['password_reset'] != '') {


}


?>
