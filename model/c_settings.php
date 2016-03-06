<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_settings.php
# Simple object for creating, editing, and retrieving
# application wide settings. 
#
#-------------------------------------------------------


class Settings {

	public $setting = Array();
	public $setting_defaults = Array();

    public function __construct() {
		
			# Create Default Array
			
			$this->setting_defaults['gmt_offset'] = 0;
			$this->setting_defaults['site_title'] = 'Open Resume';
			$this->setting_defaults['language'] = 'english';
			
			
			# Load all current settings
		
			$this->setting['gmt_offset'] = 0;		
			$this->setting['site_title'] = 'Open Resume';
			$this->setting['language'] = 'english';
   }
	
}


?>