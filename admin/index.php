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
require('../application_start.php');

# Check if logged in

if($user->logged_in === false) {
	
require('login.php');

} else {
	
	switch($_GET['admin_page']) {
		
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
require('../application_end.php');

?>