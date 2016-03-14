<?php


#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_form.php
# Simple object for creating and validating forms
# Ajax compatible stuff
#
#-------------------------------------------------------


# Builds a set of form objects from receiving an array of objects
# Displays error text with javascript and from the form array
# The form array first passes through the form controller to get error text if necessary
# We can also call the methods directly to generate form field output
# The array could easily be replaced by a full model object that was database driven

class Form {

	public $form_name;
	public $form_javascript;
	public $form_header;
	public $form_footer;
	public $fields = Array();	

	public function __construct($form_name,$form_fields_array,$edit_id='') {

		# The form name is passed with the post so that the right controller is used		
		$this->form_name = $form_name;
		$this->form_header = $this->form_header();			
		$this->form_footer = $this->form_footer();

		# Check to see if this form has been posted
		if(isset($_POST['form_name']) && $_POST['form_name']==$form_name) {

			# Run form controller here if it's a controlled form
			
			switch($form_name) {
			
				case 'contact_form':
				
				
				break;	
				
			}
			
		}

		# Iterate through all the fields and build the output array
		foreach($form_fields_array as $field_name => $settings) {
			
			
			# Create HTML for this form element by supplying arguments
			if(method_exists($this,$settings['field_type'])) {
			
				$this->fields[$settings['field_name']] = $this->$settings['field_type'](
				
					$settings['field_name'],
					$settings['field_required'],
					$settings['field_value'],
					$settings['field_children'],
					$settings['field_error_text'],
					$settings['field_error_conditions'],
					$settings['field_html']
					
				);
			
			}
			
		}	
		
	
	}


	# Make javascript to validate the form here

	public function form_javascript($form_name,$form_fields_array) {
		
		$output = '
		
		<script type="text/javascript">
		
		
		';
		
		foreach($form_fields_array as $field_name => $settings) {
			
			
			
		}
		
		$output .= '
		
		</script>
		
		
		';
		
	}
	
	
	# HTML Header for the form, includes the form validation javascript.

	public function form_header() {
		
		$output = '
		<form id="'.$this->form_name.'">
		<div class="form_container '.$this->form_name.'_container">
		<input type="hidden" name="form_name" value="'.$this->form_name.'">
		';
			
		return $output;
		
	}
	
	# HTML Footer for the form, just closes everything up.
	
	public function form_footer() {
		
		$output = '
		</div></form>';
		
		return $output;
		
	}
	
	
	# Make a hidden form element, pretty easy.
	
	public function hidden($field_name,$field_required,$field_value,$field_children,$field_error_text,$field_error_conditions,$field_html) {

		$output = '
		<input type="hidden" name="'.$field_name.'" value="'.$field_value.'" '.$field_html.'>
		';
		
		return $output;
		
	}
	
	
	# Make a text field and do everything with it
	
	public function text($field_name,$field_required,$field_value,$field_children,$field_error_text,$field_error_conditions,$field_html) {

		$output = '
		<div class="form_field '.$field_name.'_div">
			<input type="text" name="'.$field_name.'" id="'.$this->form_name.'_'.$field_name.'" class="'.$this->form_name.'_form_field '.$field_name.'" value="'.$field_value.'" '.$field_html.'>
		</div>
		<div class="error_text '.$field_name.'_error">
			<div class="'.$field_name.'_field_error_text">'.$field_error_text.'</div>			
		</div>
		';
		
		return $output;
		
	}
	
	
	public function password_field() {
		
	}
	
	
	public function textarea($field_name,$field_required,$field_value,$field_children,$field_error_text,$field_error_conditions,$field_html) {

		$output = '
		<div class="form_field '.$field_name.'_div">
			<textarea name="'.$field_name.'" id="'.$this->form_name.'_'.$field_name.'" class="'.$this->form_name.'_field '.$field_name.'" '.$field_html.'>'.$field_value.'</textarea>
		</div>
		<div class="error_text '.$field_name.'_error">
			<div class="'.$field_name.'_field_error_text">'.$field_error_text.'</div>			
		</div>
		';	
		
		return $output;
		
	}
	
	
	public function dropdown() {
		
	}
	
	
	public function dropdown_from_enum() {
		
	}
	
	
	public function dropdown_from_table() {
		
	}
		
		
	public function checkbox() {
		
	}
	
	
	public function radio() {
		
	}
	
	
	public function submit($submit_text) {
		
		$output = '<button class="btn btn-primary '.$this->form_name.'_submit_button" id="'.$this->form_name.'_submit_button" type="submit">'.$submit_text.'</button>';
		
		return $output;
		
	}
	
	

}


?>