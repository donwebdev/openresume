<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_admin_resume.php
# Retrieve and organize resume data, can spawn a resume
# view object too.
#
#-------------------------------------------------------

class Admin_Resume {
	
	public $resumes;
	public $columns = array();
	public $table = array();
	
	public function __construct() {
		
		$this->get_resumes();
		
	}
	
	public function get_resumes() {
	
		$this->results = new Admin_Query('resumes');	
		
	}
	
	public function resume_table_columns() {
	
		# Define the columns of this table	
		$i = 0;
		
		$this->columns[$i]['name'] = LANG_COLUMN_RESUME_NAME;	
		$this->columns[$i]['field_name'] = 'name';	
		$this->columns[$i]['type'] = 'text';	
		$this->columns[$i]['sortable'] = true;
		$i++;	
		
		$this->columns[$i]['name'] = LANG_COLUMN_RESUME_TYPE;	
		$this->columns[$i]['field_name'] = 'display_type';	
		$this->columns[$i]['type'] = 'text';	
		$this->columns[$i]['sortable'] = true;
		$i++;	
		
		$this->columns[$i]['name'] = LANG_COLUMN_RESUME_STYLE;	
		$this->columns[$i]['field_name'] = 'style';	
		$this->columns[$i]['type'] = 'text';	
		$this->columns[$i]['sortable'] = true;
		$i++;	
		
		$this->columns[$i]['name'] = LANG_COLUMN_UNIQUES;	
		$this->columns[$i]['field_name'] = 'uniques';	
		$this->columns[$i]['type'] = 'number';	
		$this->columns[$i]['sortable'] = true;
		$i++;	
		
		$this->columns[$i]['name'] = LANG_COLUMN_IMPRESSIONS;	
		$this->columns[$i]['field_name'] = 'impressions';	
		$this->columns[$i]['type'] = 'number';	
		$this->columns[$i]['sortable'] = true;
		$i++;	
		
		$this->columns[$i]['name'] = LANG_COLUMN_MESSAGES;	
		$this->columns[$i]['field_name'] = 'messages';	
		$this->columns[$i]['type'] = 'number';	
		$this->columns[$i]['sortable'] = true;
		$i++;		
		
		
	}
	
	public function resume_table_data() {
		
		global $db;
		global $admin;
		
		$this->table['columns'] = $this->columns;
		
		# Populate data based on columns
		$i = 0;
		
		# Iterate through results		
		foreach($this->results as $key => $value) {
		
			# Add the id to the array
			$this->table[$i]['id'] = $value['id'];
			
			# Add custom fields to the array
			
			# Get unique visitor count for this Resume
			$this->table[$i]['uniques'] = 0;
			
			# Get impressions for this resume
			$this->table[$i]['impressions'] = 0;
			
			# Get messages from this resume
			$this->table[$i]['messages'] = 0;
			
			# Add the rest of the fields to the array from the result
			$this->table[$i] = array_merge($this->table[$i],$admin->columns_to_array($value,$this->columns));
		
			$i++;	
			
		}		
	
			
		$this->table['total_items'] = $i + 1;
	
	}	
}

?>