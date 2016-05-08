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

	$admin_pages = array('resume','coverletter','messages','analytics','settings');

	if(!isset($_GET['admin_page'])) {
		$admin_page = 'resume';	
	} else {
		$admin_page = $_GET['admin_page'];
	}
	
	# Include the proper admin page
	if(in_array($admin_page,$admin_pages)) {
		
		include($admin_page.'.php');
				
	}
	
}


# Output the Resume View and end execution
require('admin_end.php');

?>