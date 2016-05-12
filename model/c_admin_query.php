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
	public $query_pagination = '';
	public $pagination_total;
	public $total_rows;
	public $table_name;
	public $select;
	public $where;
	public $results;

	# Stores total results for accurate pagination
	public $query_all_results;	
	
	public function __construct($table_name,$where='',$select = '*',$get_results = true) {

		$this->table_name = $table_name;
		$this->where = $where;
		$this->select = $select;
		$this->get_results = $get_results;
		
		$this->make_query();
		
		if($get_results === true) {
		
			$this->get_results();
			
		}		
	}

	# Construct the query based on settings
	public function make_query() {

		$query = 'SELECT '.$this->select.' FROM '.$this->table_name.' ';			

		# Start the where clause if it exists
		if($this->where != '') {
		
			$where = 'WHERE '.$this->where.' ';
			
		} else {
		
			$where = '';	
			
		}
		
		# Get the rest of the arguments for this query
		$pagination = $this->pagination();				
		$deleted = $this->deleted();		
		$filtered = $this->filtered();		
		$date_range = $this->date_range();
		
	
		# Spaghetti to build the rest of the query
		# Using spaghetti in case special conditions are needed later
		if($deleted != '') {
			
			$where .= ' AND '.$deleted;	
			
		}
		
		if($filtered != '') {
			
			$where .= ' AND '.$filtered;					
			
		}
		
		if($date_range != '') {
			
			$where .= ' AND '.$date_range;					
			
		}
		
		# Check if WHERE statement is blank
		# If so WHERE statement begins with AND and needs fixing
		if($this->where == '' && ($deleted != '' || $filtered != '' || $date_range != '')) {
	
			# Because the 4th argument has to be passed by reference
			$count = 1;
	
			# Only repace the first and with where
			$where = preg_replace('/ AND /','WHERE ',$where, 1);
			
		}
		
		# Add the where and the sorting to the query
		$query .= $where;				
		$query .= $this->sorting();		
		$query .= $this->pagination();

		# Create pagination query to get the total amount of results
		if($pagination != '') {
		
			# Get pagination statement to get a full query
			$this->query_pagination = str_replace($pagination,' 1=1 ',$query);				
			
		}		
		
		# Final query
		$this->query = $query;

	}
	
	# Does the query and returns an array
	# Use this array to build a table
	public function get_results() {
		
		global $db;
		
		$this->results = $db->get_results($this->query,ARRAY_A);
		
		# Get the total amount of rows
		$this->total_rows = $db->num_rows;
		
		# Get the total amount of results for pagination if needed
		if($this->query_pagination != '') {
		
			$this->pagination_total = $db->query($this->query_pagination);
		
		}
	}

	# Creates the appropriate pagination statement for the query
	public function pagination($page_num = '', $page_count = '') {
		
		# Check if GET variables are set and grab those
		if($page_num != '' && $page_count != '' && isset($_GET['page_num']) && isset($_GET['page_count']) && is_int($_GET['page_num']) && is_int($_GET['page_count'])) {
				
			$page_num = $_GET['page_num'];
			$page_count = $_GET['page_count'];
			
		}	
		
			
	}

	# Check if table has a deleted column
	# Create a deleted statement based on settings
	public function deleted() {
		
		global $tables;
		global $settings;
		
		# Check to see if the table has a deleted column
		if(isset($tables->table_array[$this->table_name]['deleted'])) {

			if($settings->setting['show_deleted'] == 0) {
			
				return 'deleted IS NULL';
				
			} elseif($settings->setting['show_deleted'] == 1) {
			
				return 'deleted = 1';
				
			} else {
			
				return '';	
				
			}
		}		
	}

	# Check if table has a filtered column
	# Creates a filtered statement based on settings
	public function filtered() {
		
		global $tables;
		global $settings;
		
		# Check to see if the table has a filtered column
		if(isset($tables->table_array[$this->table_name]['filtered'])) {
			
			if($settings->setting['show_filtered'] == 0) {
			
				return 'filtered = 0';
				
			} elseif ($settings->setting['show_filtered'] == 1) {
				
				return 'filtered = 1';
				
			} else {
			
				return '';	
				
			}		
		}		
	}
	
	# Creates a statement for sorting the results
	public function sorting($sort='',$order='') {
		
		global $tables;
		
		# Check to see if GET variables are set if function arguments are not
		if($sort != '' && $order != '' && isset($_GET['sort']) && isset($_GET['order'])) {
			
			$sort = $_GET['sort'];
			$order = $_GET['order'];
			
		}
		
		# Check to see if the sorting column exists, and that order is set properly
		if (isset($tables->table_array[$sort]) && ($order == 'asc' || $order == 'desc')) {
			
			return 'ORDER BY ' . $sort . ' ' . $order;
			
		}		
	}

	# Creates a date range based on settings	
	public function date_range($date_field = 'created', $dont_change_settings = false) {
		
		global $settings;
		
		# Check if a different date range has been requested
		if (isset($_GET['date'])) {
			$range = $_GET['date'];
			
		# Get the range setting from the settings object	
		} else {
			$range = $settings->setting['date_range_type'];
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