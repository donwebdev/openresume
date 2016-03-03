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
			$this->setting['gmt_offset'] = 0;
   }
	
}


?>