<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# view/c_render_table.php
# Renders a table of the data supplied to it
#
#-------------------------------------------------------


class Render_Table {

	public $admin_output;	

	public function __construct($admin_output) {
		
		$this->admin_output = &$admin_output;
				
	}
	
	
	public function table_headers() {
	
	
	
	}
	
	
	public function table_rows() {
	
	
		
	}
	
	
	public function pagination() {
		
	
		
	}
	
	
	public function date_range_form() {
	
		global $settings;

		
		$range = $settings->setting['date_range_type'];
		$output  = '<div class="admin_date_form_container"><div id="admin_date_presets"';
		
		if ($range == 'Custom') {
			$output .= 'style="display:none;"';
		}
		
		$output .= '> <form name="custom_date_range" method="post" action="' . $this->admin_output->url('date=Custom') . '"> <input type="hidden" name="form_id" value="custom_date_range"> <ul class="admin_date_list"> <li>'.LANG_DATE.':</li>';
		$output .= '<li><a href="' . $this->admin_output->url('date=Today&delete_page=') . '"';
		
		if ($range == 'Today') {
			$output .= ' class="admin_current" ';
		}
		
		$output .= '>'.LANG_TODAY.'</a></li>';
		$output .= '<li><a href="' . $this->admin_output->url('date=Yesterday&delete_page=') . '"';
		
		if ($range == 'Yesterday') {
			$output .= ' class="admin_current" ';
		}
		
		$output .= '>'.LANG_YESTERDAY.'</a></li>';
		$output .= '<li><a href="' . $this->admin_output->url('date=Last7&delete_page=') . '"';
		
		if ($range == 'Last7') {
			$output .= ' class="admin_current" ';
		}
		$output .= '>'.LANG_LAST_7_DAYS.'</a></li>';
		$output .= '<li><a href="' . $this->admin_output->url('date=ThisMonth&delete_page=') . '"';
		
		if ($range == 'ThisMonth') {
			$output .= ' class="admin_current" ';
		}
		$output .= '>'.LANG_THIS_MONTH.'</span></a></li>';
		$output .= '<li><a href="' . $this->admin_output->url('date=LastMonth&delete_page=') . '"';
		
		if ($range == 'LastMonth') {
			$output .= ' class="admin_current" ';
		}
		$output .= '>'.LANG_LAST_MONTH.'</span></a></li>';
		$output .= '<li><a href="' . $this->admin_output->url('date=ThisYear&delete_page=') . '"';
		
		if ($range == 'ThisYear') {
			$output .= ' class="admin_current" ';
		}
		$output .= '>'.LANG_THIS_YEAR.'</span></a></li>';
		$output .= '<li><a href="' . $this->admin_output->url('date=AllTime&delete_page=') . '"';
		
		if ($range == 'AllTime') {
			$output .= ' class="admin_current" ';
		}
		$output .= '>'.LANG_ALL_TIME.'</span></a></li>';
		$output .= '<li><a href="javascript:void(0)" onclick="jQuery(\'#date_custom\').fadeIn(200);jQuery(\'#date_presets\').hide();" ';
		
		if ($range == 'Custom') {
			$output .= ' class="admin_current" ';
		}
		
		$output .= '>'.LANG_CUSTOM.'</span></a></li>';
		$output .= ' </ul> </div> <div id="date_custom"';
		if ($range != 'Custom') {
			$output .= 'style="display:none;"';
		}
		
		$output .= '> <script type="text/javascript"> jQuery(function() { jQuery( "#start_date" ).datepicker({ defaultDate: "0", changeMonth: true, numberOfMonths: 3, onClose: function( selectedDate ) { jQuery( "#end_date" ).datepicker( "option", "minDate", selectedDate ); } }); jQuery( "#end_date" ).datepicker({ defaultDate: "0", changeMonth: true, numberOfMonths: 3, onClose: function( selectedDate ) { jQuery( "#start_date" ).datepicker( "option", "maxDate", selectedDate ); } }); }); </script> <span> <a href="javascript:void(0)" onclick="jQuery(\'#date_custom\').hide();jQuery(\'#date_presets\').fadeIn(200);">'.LANG_BACK.'</a> <label for="from">'.LANG_FROM.'</label> <input type="text" id="start_date" name="start_date" maxlength="10" value="' . $settings->setting['start_date'] . '" class="admin_date_range" /> <label for="to">'.LANG_TO.'</label> <input type="text" id="end_date" name="end_date" maxlength="10" value="' . $settings->setting['end_date'] . '" class="admin_date_range" /> <input type="submit" name="" id="post-query-submit" class="button" value="'.LANG_APPLY.'"> </span> </div> </form> ';
		
		$output .= '</div>';
		
		return $output;
		
		
	}	
}



?>