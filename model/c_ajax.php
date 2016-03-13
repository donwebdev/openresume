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
	
	private $visitor;
	private $user;
	private $resume;
	private $cover_letter;
	private $contact_form;	
	
	public function __construct($login_required = false) {
	
		$this->visitor = new Visitor;
		$this->user = new User;
		
		# Validate the visitor or die
		
		
		# Validate the impression or die
		
		
		# Validate the user or die if login is required
		
		
	}
	
}

?>