<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# admin/index.php
# Initialize the admin panel
#
#-------------------------------------------------------

# Load the model
require('admin_start.php');

# Check if logged in

if($user->logged_in === false) {
	
require('login.php');

} else {

	if(!isset($_GET['admin_page'])) {
		$admin_page = 'resume';	
	} else {
		$admin_page = $_GET['admin_page'];
	}
	
	switch($admin_page) {
		
		case 'resume':
			require('resume.php');
		break;
		
		case 'coverletter':
			require('coverletter.php');		
		break;
		
		case 'messages':
			require('contact.php');				
		break;
		
		case 'analytics':
			require('analytics.php');			
		break;
		
		case 'settings':
			require('settings.php');			
		break;
		
	}
	
}


# Output the Resume View and end execution
require('admin_end.php');

?>