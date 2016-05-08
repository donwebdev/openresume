<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_query.php
# Builds a query based on arguments and settings
#
#-------------------------------------------------------


class Query {

	public $query;

	function __construct() {
		
		
	}
	
	
}




function opt_calculate_date_range($date_field = 'time_created', $dont_change_settings = false)
{
    if (!empty($_GET['date'])) {
        $range = $_GET['date'];
    } else {
        $range = opt_settings('date_range_type');
    }
    if ($range == '') {
        opt_settings('date_range_type', 'Today');
        $range = 'Today';
    }
    $tz = intval(get_option('gmt_offset')) * 3600;
    if ($range == '') {
        opt_settings('date_range_type', 'Today');
        $range = 'Today';
    }
    if ($range == 'Today') {
        $time_1 = mktime(0, 0, 0, date('n'), date('j', time() + $tz));
        $time_2 = mktime(23, 59, 59, date('n'), date('j', time() + $tz));
        $date_1 = date('Y-m-d H:i:s', $time_1);
        $date_2 = date('Y-m-d H:i:s', $time_2);
        if (!$dont_change_settings) {
            opt_settings('date_range_type', 'Today');
        }
    } elseif ($range == 'Yesterday') {
        $time_1 = mktime(0, 0, 0, date('n'), date('j', time() + $tz) - 1);
        $time_2 = mktime(23, 59, 59, date('n'), date('j', time() + $tz) - 1);
        $date_1 = date('Y-m-d H:i:s', $time_1);
        $date_2 = date('Y-m-d H:i:s', $time_2);
        if (!$dont_change_settings) {
            opt_settings('date_range_type', 'Yesterday');
        }
    } elseif ($range == 'Last7') {
        $time_1 = mktime(0, 0, 0, date('n'), date('j', time() + $tz) - 6);
        $time_2 = mktime(23, 59, 59, date('n'), date('j', time() + $tz));
        $date_1 = date('Y-m-d H:i:s', $time_1);
        $date_2 = date('Y-m-d H:i:s', $time_2);
        if (!$dont_change_settings) {
            opt_settings('date_range_type', 'Last7');
        }
    } elseif ($range == 'ThisMonth') {
        $time_1 = mktime(0, 0, 0, date('n', time() + $tz), 1);
        $time_2 = mktime(23, 59, 59, date('n', time() + $tz) + 1, 0);
        $date_1 = date('Y-m-d H:i:s', $time_1);
        $date_2 = date('Y-m-d H:i:s', $time_2);
        if (!$dont_change_settings) {
            opt_settings('date_range_type', 'ThisMonth');
        }
    } elseif ($range == 'LastMonth') {
        $time_1 = mktime(0, 0, 0, date('n', time() + $tz) - 1, 1);
        $time_2 = mktime(23, 59, 59, date('n', time() + $tz), 0);
        $date_1 = date('Y-m-d H:i:s', $time_1);
        $date_2 = date('Y-m-d H:i:s', $time_2);
        if (!$dont_change_settings) {
            opt_settings('date_range_type', 'LastMonth');
        }
    } elseif ($range == 'ThisYear') {
        $time_1 = mktime(0, 0, 0, 1, 1, date("Y", time() + $tz));
        $time_2 = mktime(23, 59, 59, 12, 31, date("Y", time() + $tz));
        $date_1 = date('Y-m-d H:i:s', $time_1);
        $date_2 = date('Y-m-d H:i:s', $time_2);
        if (!$dont_change_settings) {
            opt_settings('date_range_type', 'ThisYear');
        }
    } elseif ($range == 'Custom') {
        if ($_REQUEST['start_date'] != '' && $_REQUEST['end_date'] != '') {
            $start_date_array = explode('/', $_REQUEST['start_date']);
            $end_date_array   = explode('/', $_REQUEST['end_date']);
            $time_1           = mktime(0, 0, 0, $start_date_array[0], $start_date_array[1], $start_date_array[2]);
            $time_2           = mktime(23, 59, 59, $end_date_array[0], $end_date_array[1], $end_date_array[2]);
        } else {
            $start_date_array = explode('/', opt_settings('start_date'));
            $end_date_array   = explode('/', opt_settings('end_date'));
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
            opt_settings('date_range_type', 'Custom');
        }
    } elseif ($range == 'AllTime') {
        if (!$dont_change_settings) {
            opt_settings('date_range_type', 'AllTime');
        }
        return '1=1';
    }
    opt_settings('start_date', date('m/d/Y', $time_1));
    opt_settings('end_date', date('m/d/Y', $time_2));
    return $date_field . " BETWEEN '" . $date_1 . "' AND '" . $date_2 . "'";
}


?>