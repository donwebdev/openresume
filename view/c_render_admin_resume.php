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
	public $admin_output;
	public $render_table;

	public function __construct($admin_output) {
		
		# Get a reference to the model used to build this resume
		$this->admin_output = &$admin_output;
		
		# Make a table rendered with the current model
		$this->render_table = new Render_Table($this->admin_output);
		
		$this->output .= $this->admin_output->page_container_start();		
		
		$this->output .= $this->resume_header();
		
		# If there is a resume model, render it with editing options
		if(isset($this->admin_output->model->output->resume)) { 
		
			$contact_form = new Contact_Form($this->admin_output->model->output->resume);
		
			$resume = new Resume_Output($this->admin_output->model->output->resume,'',$contact_form,true);		
		
			# The stats and buttons for the loaded resume
			$this->output .= $this->single_resume_table();			
		
			$this->output .= $this->admin_output->page_container_end();
		
			# The resume itself				
			$this->output .= $resume->output;
		
			# Form for editing and adding resume sections
			
			# Edit history
		
		# No resume model, render a table of resumes instead	
		} else {
			
			
			
		}
	}
	
	# Resume header
	public function resume_header() {
		
		$output = '
		<div class="admin_header">
		
			<h1 class="admin_title">'.LANG_RESUMES.'</h1>
			
			<a class="admin_header_link">'.LANG_CREATE_NEW.' '.LANG_RESUME.'</a>';
						
	
		# Date range selector from table object		
		$output .= $this->render_table->date_range_form();
				
		$output .= '</div>';

		return $output;	
		
	}

	# Show the stats of a single resume
	# Used when showing only one resume
	public function single_resume_table() {	
		
		
		# Resume stats grid
		$output = '
				<div>
				
					'.LANG_UNIQUES.'
					
					'.LANG_IMPRESSIONS.'
					
					'.LANG_MESSAGES.'
		
				</div>		
		
		';
		
		$output .= $this->admin_output->model->output->table[0]['uniques'];
		
		$output .= $this->admin_output->model->output->table[0]['impressions'];
		
		$output .= $this->admin_output->model->output->table[0]['messages'];
		
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