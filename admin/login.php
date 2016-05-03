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
	<div class="login_overlay">	
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
		
		$admin_output .= '<a href="?forgot_password=1" class="forgot_password right">'.LANG_FORGOTTEN_PASSWORD.'</a>';
		
		$admin_output .= '
		
	</div>
	</div>
';
		
}

# Forgotten Password Form
elseif(isset($_GET['forgot_password']) && $_GET['forgot_password'] != '') {


}

# Password Reset Notification
elseif(isset($_GET['forgot_password']) && $_GET['password_reset'] != '') {


}

?>
