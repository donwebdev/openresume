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
	public $resume;
	public $admin;
	public $columns = array();
	public $table = array();
	
	public function __construct($admin) {
	
		# Create a reference to the admin object that spawned this class
		# Because variable scope...
		$this->admin = &$admin;
		
		$this->get_resumes();
		
		$this->resume_table_columns();
		
		$this->resume_table_data();
		
		# If there's only one resume, or we're editing a resume
		# Build a resume model based on the id in $this->table
		if($this->table['total_items'] == 1) {
		
			# Build a resume model from the first id in the table array
			$this->resume = new Resume($this->table[0]['id']);
		
		# Build a resume based on if one needs to be edited
		} elseif(isset($_GET['edit_resume']) && is_numeric($_GET['edit_resume'])) {
			
			$this->resume = new Resume($_GET['edit_resume']);
			
		}
	}
	
	# Grabs all resumes matching current admin query parameters
	public function get_resumes() {
	
		$this->resumes = new Admin_Query('resumes','','*',true);
		
	}
	
	# The column structure of the resume table
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
	
	# Builds all data for the resume table
	public function resume_table_data() {
		
		global $db;
		
		$this->table['columns'] = $this->columns;
		
		# Populate data based on columns
		$i = 0;
		
		# Iterate through results		
		foreach($this->resumes->results as $key => $resume) {
		
		
			# Add the id to the array
			$this->table[$i]['id'] = $resume['id'];
			
			# Add custom fields to the array
			
			# Get impressions for this resume
			$impressions = new Admin_Query('impressions','resume_id = '.$resume['id'],'visitor_id');
			
			$this->table[$i]['impressions'] = $impressions->total_rows;
			
			
			# Get unique visitor count for this Resume
			$uniques = new Admin_Query('visitors','id IN ('.$impressions->query.')','*',true);
			
			$this->table[$i]['uniques'] = $uniques->total_rows;
			
			
			# Get messages from this resume
			$messages = new Admin_Query('messages','resume_id = '.$resume['id']);
			
			$this->table[$i]['messages'] = $messages->total_rows;
			
			# Add the rest of the fields to the array from the result
			$this->table[$i] = array_merge($this->table[$i],$this->admin->columns_to_array($resume,$this->columns));
		
			$i++;	
			
		}		
	
		# Total amount of resumes in table		
		$this->table['total_items'] = $i;
	
	}	
}

?>