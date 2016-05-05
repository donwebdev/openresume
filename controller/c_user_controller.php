<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# controller/c_user_controller.php
# Create user object based on login status.
# Login controller uses this object to log people in
#
#-------------------------------------------------------




class User_Controller extends User {
	
	public function __construct() {
		
		
		# Validate the cookie if its set, and set the user to logged in
		# Deletes the cookie if it's too old as well
		if(isset($_COOKIE['openresume_admin'])) {
		
			$this->validate_cookie($_COOKIE['openresume_admin']);
			
		    # Check for logout
			if($this->logged_in === true && isset($_GET['logout'])) {
			
				$this->user_logout($this->id);
				$this->logged_in = false;
				
			}
			
		}
		
	}	
	
}







?>