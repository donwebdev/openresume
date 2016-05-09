<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_admin_query.php
# Builds a query based on arguments and settings
#
#-------------------------------------------------------


class Admin_Query {

	public $query;
	public $table_name; 
	public $select;
	public $where;

	public function __construct($table_name,$where='',$select = '*') {
		
		
	}

	# Construct the query based on settings
	public function make_query() {

		$query = 'SELECT '.$this->select.' FROM '.$this->table_name.' ';			

		if($this->where != '') {
		
			$query .= 'WHERE '.$where.' ';
			
		}
		
		# Do the necessary methods
		$query_args .= $this->pagination();
				
		$query_args .= $this->deleted();
		
		$query_args .= $this->filtered();
		
		$query_args .= $this->date_range();
		
		# Add a where in case we need it
		if($this->where == '' && $query_args != '') {
		
			$query .= 'WHERE '.$query_args;
			
		} else {
		
			$query .= $query_args;	
			
		}
		
		$query .= $this->sorting();

		return $query;

	}

	# Does the query and returns an array
	# Use this array to build a table
	public function get_results() {
			
	}

	# Creates the appropriate pagination statement for the query
	public function pagination() {
		
	}

	# Don't show deleted entries by default
	# Check if table has a deleted column
	public function deleted() {
		
	}

	# Creates a filtered statement based on settings
	# Check if table has a filtered column
	public function filtered() {
		
	}
	
	# Creates a statement for sorting the results
	public function sorting() {
		
	}

	# Creates a date range based on settings	
	public function date_range($date_field = 'created', $dont_change_settings = false) {
		
		global $settings;
		
		# Check if a different date range has been requested
		if (isset($_GET['date'])) {
			$range = $_GET['date'];
			
		# Get the range setting from the settings object	
		} else {
			$range = $settings->set_setting('date_range_type');
		}
		
		# Create a timezone offset if a timezone has been set
		$tz = $settings->setting['time_zone'] * 3600;
		
		# Get the entire range of today until 11:59:59
		if ($range == 'Today') {
			$time_1 = mktime(0, 0, 0, date('n'), date('j', time() + $tz));
			$time_2 = mktime(23, 59, 59, date('n'), date('j', time() + $tz));
			$date_1 = date('Y-m-d H:i:s', $time_1);
			$date_2 = date('Y-m-d H:i:s', $time_2);
			if (!$dont_change_settings) {
				$settings->set_setting('date_range_type', 'Today');
			}
		
		# Get yesterday's range
		} elseif ($range == 'Yesterday') {
			$time_1 = mktime(0, 0, 0, date('n'), date('j', time() + $tz) - 1);
			$time_2 = mktime(23, 59, 59, date('n'), date('j', time() + $tz) - 1);
			$date_1 = date('Y-m-d H:i:s', $time_1);
			$date_2 = date('Y-m-d H:i:s', $time_2);
			if (!$dont_change_settings) {
				$settings->set_setting('date_range_type', 'Yesterday');
			}
		
		# Get the range from the last 7 days
		} elseif ($range == 'Last7') {
			$time_1 = mktime(0, 0, 0, date('n'), date('j', time() + $tz) - 6);
			$time_2 = mktime(23, 59, 59, date('n'), date('j', time() + $tz));
			$date_1 = date('Y-m-d H:i:s', $time_1);
			$date_2 = date('Y-m-d H:i:s', $time_2);
			if (!$dont_change_settings) {
				$settings->set_setting('date_range_type', 'Last7');
			}
		
		# Get the full range of dates from this month
		} elseif ($range == 'ThisMonth') {
			$time_1 = mktime(0, 0, 0, date('n', time() + $tz), 1);
			$time_2 = mktime(23, 59, 59, date('n', time() + $tz) + 1, 0);
			$date_1 = date('Y-m-d H:i:s', $time_1);
			$date_2 = date('Y-m-d H:i:s', $time_2);
			if (!$dont_change_settings) {
				$settings->set_setting('date_range_type', 'ThisMonth');
			}
		
		# Get the full range of dates from the previous month
		} elseif ($range == 'LastMonth') {
			$time_1 = mktime(0, 0, 0, date('n', time() + $tz) - 1, 1);
			$time_2 = mktime(23, 59, 59, date('n', time() + $tz), 0);
			$date_1 = date('Y-m-d H:i:s', $time_1);
			$date_2 = date('Y-m-d H:i:s', $time_2);
			if (!$dont_change_settings) {
				$settings->set_setting('date_range_type', 'LastMonth');
			}
		
		# Get dates from January first until the end of the year
		} elseif ($range == 'ThisYear') {
			$time_1 = mktime(0, 0, 0, 1, 1, date("Y", time() + $tz));
			$time_2 = mktime(23, 59, 59, 12, 31, date("Y", time() + $tz));
			$date_1 = date('Y-m-d H:i:s', $time_1);
			$date_2 = date('Y-m-d H:i:s', $time_2);
			if (!$dont_change_settings) {
				$settings->set_setting('date_range_type', 'ThisYear');
			}
		
		# Build a custom date range
		} elseif ($range == 'Custom') {
			if (isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])) {
				$start_date_array = explode('/', $_REQUEST['start_date']);
				$end_date_array   = explode('/', $_REQUEST['end_date']);
				$time_1           = mktime(0, 0, 0, $start_date_array[0], $start_date_array[1], $start_date_array[2]);
				$time_2           = mktime(23, 59, 59, $end_date_array[0], $end_date_array[1], $end_date_array[2]);
			} else {
				$start_date_array = explode('/', $settings->set_setting('start_date'));
				$end_date_array   = explode('/', $settings->set_setting('end_date'));
				$time_1           = mktime(0, 0, 0, $start_date_array[0], $start_date_array[1], $start_date_array[2]);
				$time_2           = mktime(23, 59, 59, $end_date_array[0], $end_date_array[1], $end_date_array[2]);
			}
			if ($time_1 > $time_2) {
				$date_1 = date('Y-m-d H:i:s', $time_2);
				$date_2 = date('Y-m-d H:i:s', $time_1);
				$time_3 = $time_1;
				$time_2 = $time_1;
				$time_1 = $time_3;
			} else {
				$date_1 = date('Y-m-d H:i:s', $time_1);
				$date_2 = date('Y-m-d H:i:s', $time_2);
			}
			if (!$dont_change_settings) {
				$settings->set_setting('date_range_type', 'Custom');
			}	
		
		# Nothing is set, or Alltime is set		
		} else {
			if (!$dont_change_settings) {
				$settings->set_setting('date_range_type', 'AllTime');
			}
			
			# Return all dates instead of a range
			return '1=1';
		}
		
		# Set the new date range settings and return the query
		$settings->set_setting('start_date', date('m/d/Y', $time_1));
		$settings->set_setting('end_date', date('m/d/Y', $time_2));
		return $date_field . " BETWEEN '" . $date_1 . "' AND '" . $date_2 . "'";
	}
		
	
}



?>