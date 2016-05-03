<?php


#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_form.php
# Simple object for creating form html
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
	public $fields = array();	
	
	private $form_fields_array = array();

	public function __construct($form_name,$form_fields_array) {

		# The form name is passed with the post so that the right controller is used		
		$this->form_name = $form_name;
		$this->form_javascript = $this->form_javascript();	
		$this->form_header = $this->form_header();			
		$this->form_footer = $this->form_footer();

		# Iterate through all the fields and build the output array
		foreach($form_fields_array as $field_name => $settings) {			
			
			# Create HTML for this form element by supplying arguments
			if(method_exists($this,$settings['type'])) {
			
				$this->fields[$settings['name']] = $this->$settings['type']($settings);
			
			}
			
		}			
	
	}


	# Make javascript for anything the form needs here
	# Currendtly not used for anything
	private function form_javascript() {
		
		$output = '
		
		<script type="text/javascript">
		</script>		
		
		';
		
		return $output;
		
	}
	
	
	# HTML Header for the form, includes the form validation javascript.

	private function form_header() {
		
		$output = '
		<form id="'.$this->form_name.'">
		<div id="'.$this->form_name.'_container" class="form_container '.$this->form_name.'_container">
		<input type="hidden" name="form_name" value="'.$this->form_name.'">
		';
			
		return $output;
		
	}
	
	# HTML Footer for the form, just closes everything up.
	
	private function form_footer() {
		
		$output = '
		</div></form>';
		
		return $output;
		
	}
	
	
	# Make a hidden form element, pretty easy.
	
	private function hidden($settings) {

		$output = '
		<input type="hidden" name="'.$settings['name'].'" value="'.$settings['value'].'" '.$settings['html'].'>
		';
		
		return $output;
		
	}
	
	
	# Make a text field and do everything with it
	
	private function text($settings) {

		$output = '
		<div class="form_field '.$settings['name'].'_div">
			<input type="text" placeholder="'.$settings['title'].'" name="'.$settings['name'].'" id="'.$this->form_name.'_'.$settings['name'].'" class="form-control '.$this->form_name.'_form_field '.$this->form_name.'_'.$settings['name'].'" value="'.$settings['value'].'" data-validate="'.$settings['validation'].'" '.$settings['html'].'>
		</div>
		<div class="error_text '.$settings['name'].'_error">
			<div class="'.$settings['name'].'_field_error_text">'.$settings['error_text'].'</div>			
		</div>
		';
		
		return $output;
		
	}
	
	
	private function password_field($settings) {

		$output = '
		<div class="form_field '.$settings['name'].'_div">
			<input type="password" placeholder="'.$settings['title'].'" name="'.$settings['name'].'" id="'.$this->form_name.'_'.$settings['name'].'" class="form-control '.$this->form_name.'_form_field '.$this->form_name.'_'.$settings['name'].'" value="'.$settings['value'].'" data-validate="'.$settings['validation'].'" '.$settings['html'].'>
		</div>
		<div class="error_text '.$settings['name'].'_error">
			<div class="'.$settings['name'].'_field_error_text">'.$settings['error_text'].'</div>			
		</div>
		';
		
		return $output;
		
	}
	
	
	private function textarea($settings) {

		$output = '
		<div class="form_field '.$settings['name'].'_div">
			<textarea placeholder="'.$settings['title'].'" name="'.$settings['name'].'" id="'.$this->form_name.'_'.$settings['name'].'" class="form-control '.$this->form_name.'_field '.$this->form_name.'_'.$settings['name'].'"  data-validate="'.$settings['validation'].'" '.$settings['html'].'>'.$settings['value'].'</textarea>
		</div>
		<div class="error_text '.$settings['name'].'_error">
			<div class="'.$settings['name'].'_field_error_text">'.$settings['error_text'].'</div>			
		</div>
		';	
		
		return $output;
		
	}
	
	
	private function dropdown() {
		
	}
	
	
	private function dropdown_from_enum() {
		
	}
	
	
	private function dropdown_from_table() {
		
	}
		
		
	private function checkbox() {
		
	}
	
	
	private function radio() {
		
	}
	
	
	public function submit($submit_text) {
		
		$output = '<button class="btn btn-primary '.$this->form_name.'_submit_button" id="'.$this->form_name.'_submit_button">'.$submit_text.'</button>';
		
		return $output;
		
	}
	
	

}


?>