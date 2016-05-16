<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# controller/c_admin_resume_controller.php
# Handles all admin requests to change the resume
# Stores edits into the edit log
# Commits edit log to resume
#
#-------------------------------------------------------


class Admin_Resume_Controller {
	
	public $action;
	public $resume_id;
	
	public function __construct($construct = true) {
		
		if($construct === true) {
		
			if(method_exists($this,$_REQUEST['resume_action']) && isset($_REQUEST['resume_id'])) {
				
				$this->action = $_REQUEST['resume_action'];
				$this->resume_id = $_REQUEST['resume_id'];
	
				$this->$this->action;
				
			}		
		}
	}
		
	#---------------------------------
	# Resume Setting CRUD's
	#---------------------------------
	
	public function create_resume() {
		
	}
	
	public function edit_resume() {
		
	}
	
	public function delete_resume() {
		
	}
	
	public function restore_resume() {
		
	}
	
	
	#---------------------------------
	# Resume Section CRUD's
	#---------------------------------
	
		
	public function resume_add_section() {
		
	}
	
	public function resume_edit_section() {
	
	}
		
	public function resume_edit_section_order() {
	
	}
	
	public function resume_delete_section() {
	
	}
	
	public function resume_restore_section() {
	
	}
	
		
	#---------------------------------
	# Resume Item CRUD's
	#---------------------------------
		
		
	public function resume_add_item() {
		
	}
	
	public function resume_edit_item() {
		
	}
		
	public function resume_edit_item_order() {
	
	}
	
	public function resume_delete_item() {
		
	}
	
	public function resume_restore_item() {
		
	}

	
		
	#---------------------------------
	# Handle results
	#---------------------------------
	
	
	# Serializes an edit to json and stores it in the edit table
	public function create_resume_edit($data) {
		
		global $db;
		
		$data = json_encode($data);
		
		$insert = array();
		
		$insert_data = array(
			'id' => NULL,
			'created' => $db->current_time(),
			'resume_id' => $this->resume_id,
			'committed' => 0,
			'edit_data' => $data
		);
						
		$db->insert('resume_edit_log', $insert_data);
		
	}
	
	public function remove_resume_edit() {
			
		
	}
	
	public function commit_resume_edits() {
		
	}
	
		
	#---------------------------------
	# Spawn a view based on the change
	#---------------------------------
	
	
	
}


?>