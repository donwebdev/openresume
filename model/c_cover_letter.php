<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_cover_letter.php
# Loads all data needed to create a cover letter.
#
#-------------------------------------------------------


class Cover_Letter {
	
	# If the model determines a cover letter should be displayed, switch this to true later
	public $render_cover_letter = false;
	public $cover_letter;
	public $cover_letter_settings;

	public function __construct($resume_id='') {
	
			global $db;		
		
			# If cover letter id is set we load that resume
			if(isset($_GET['cover_letter_id']) && is_numeric($_GET['cover_letter_id'])) {
				
				$cover_letter_id = $_GET['cover_letter_id'];
				
				$cover_letter = $db->get_row('SELECT * FROM resume_cover_letters WHERE id = '.$cover_letter_id);
				
				$render_cover_letter = true;
				
			}			
		
			# htaccess rewrite check
			if(isset($_GET['cover_letter_linkname']) && is_numeric($_GET['cover_letter_linkname'])) {
				
				$cover_letter_name = $_GET['cover_letter_linkname'];
				
				$cover_letter = $db->get_row('SELECT * FROM resume_cover_letters WHERE linkname = "'.$cover_letter_name.'"');
				
				$render_cover_letter = true;
				
			}
			
	}
	
	# Some more functionality eventually will go here.
	
}


?>