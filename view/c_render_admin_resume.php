<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# view/c_render_admin_resume.php
# Renders the admin page based on the admin model
#
#-------------------------------------------------------

class Admin_Resume_Output {
	
	public $output = '';
	public $resume;
	public $admin_view;

	public function __construct($admin_view) {
		
		# Get a reference to the model used to build this resume
		$this->admin_view = &$admin_view;
		
		# If there is a resume model, render it with editing options
		if(isset($this->admin_view->model->output->resume)) { 
		
			$contact_form = new Contact_Form($this->admin_view->model->output->resume);
		
			$resume = new Resume_Output($this->admin_view->model->output->resume,'',$contact_form,true);
		
		
			# The stats and buttons for the resume
			$this->output .= $this->admin_view->page_container_start();			
		
			$this->output .= $this->single_resume_table();			
		
			$this->output .= $this->admin_view->page_container_end();
		
			# The resume itself	
			$this->output .= '<div class="resume_container"><div class="container-fluid">';
			
			$this->output .= $resume->output;
			
			$this->output .= '</div></div>';
		
			# Form for editing and adding resume sections
			
			# Edit history
		
		# No resume model, render a table of resumes instead	
		} else {
			
			
			
		}
	}

	# Show the stats of a single resume
	# Used when showing only one resume
	public function single_resume_table() {	
		
		$output = '
		<div class="admin_header">
		
			<h1 class="admin_title">'.LANG_RESUMES.'</h1>
			
			<button class="btn admin_button">'.LANG_CREATE_NEW.' '.LANG_RESUME.'</button>
						
		';

		# Date range selector from table object		
		$output .= ' Date Form';
		
		
		# Resume stats grid
		
		
		# Resume stats graph

		$output .= '
		</div>
		';
		
		
		return $output;
		
	}
	
	# Display a table of all resumes
	# Only used when there is more than one resume
	public function resume_table() {
	
		
		
	}
	
	# Displays the form to edit a resume section
	public function edit_resume_section() {
	
		
		
	}
	
	# The form array to render the section form
	public function edit_resume_section_form() {
	
		
		
	}
	
	# Display the edit history of the resume
	public function edit_resume_history() {
	
		
		
	}
	

	
}


?>