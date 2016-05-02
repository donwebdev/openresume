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

    public function __construct() {		
		
		global $db;
					
		# Default settings	
		$defaults['admin_url'] = '';		
		$defaults['gmt_offset'] = 0;		
		$defaults['site_title'] = 'Open Resume';
		$defaults['fixed_header'] = '1';
		$defaults['language'] = 'english';
		$defaults['your_name'] = 'Your Name';
		$defaults['your_address_1'] = '';
		$defaults['your_address_2'] = '';
		$defaults['your_phone'] = '(123) 456-7890';
		$defaults['your_email'] = 'you@email.com';
		$defaults['your_location'] = 'Timbuktu';
		
					
		# Load all current settings, overrides default settings	
		$settings = $db->get_results('SELECT * FROM settings');
		
		# The amount of settings in the database is less than it should be
		# Check against all existing settings and fix it
		if($db->num_rows != count($defaults)) {
			
			$this->create_settings($defaults);
			$settings = $db->get_results('SELECT * FROM settings');
						
		}
		
		
		foreach($settings as $row) {
			$this->setting[$row->name] = $row->value;			
		}
		
	}
   
   	# Compare defaults to all existing settings
   	private function create_settings($settings) {
		
		global $db;
		
		foreach($settings as $name => $value) {
			
			$setting = $db->get_row('SELECT * FROM settings WHERE name = "'.$name.'"');
		
			if($setting===null) {
				
				$data['name'] = $name;
				$data['value'] = $value;
				
				$db->insert('settings',$data);
				
			}
			
		}
		
	}
   
   	# Set a setting!
	public function set_setting($name,$value) {
		
		global $db;
		
		# The arrays the database needs		
		$data['name'] = $name;
		$data['value'] = $value;
		
		$where['name'] = $name;
		
		# Check to make sure the setting exists		
		if($db->query('SELECT * FROM settings WHERE name = "'.$name.'"') == 0) {
			
			$db->insert('settings', $data);
			
		} else {
			
			$db->update('settings', $data, $where);
			
		}	   
	}
	
   	
	# Remove a setting from the database completely
	public function unset_setting($name) {
		
		global $db;
		
		$db->query('DELETE FROM settings WHERE name = "'.$name.'"');
	
	
	}	
	
	
}


?>