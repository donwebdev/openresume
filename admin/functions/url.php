<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# admin/functions/url.php
# Function for creating and editing links with arguments
#
#-------------------------------------------------------


function url($new_url = '', $accepted_arguments = '', $base_url = '')
{

	# Simple link to base url
    if ($accepted_arguments == 'clear') {
        return $base_url;
    }
    
	
	# Arguments that may be in the url
	# If $acepted_arguments is blank, all arguments are okay 
	if ($accepted_arguments != '') {
        $variables = explode(',', $accepted_arguments);
        unset($accepted_arguments);
        foreach ($variables as $key => $value) {
            $accepted_arguments[$value] = 1;
        }
    }
	
	
	# Get current URL arguments
    $current_url = $_SERVER['REQUEST_URI'];
    $current_url = explode('?', $current_url);
    if(isset($current_url[1])) {
		$current_url = explode('&', $current_url[1]);
	}
	
	
	# Blow up the current URL
    foreach ($current_url as $key => $value) {
        $argument = explode('=', $value);
        if ($accepted_arguments == '') {
            $url[$argument[0]] = $argument[1];
        } elseif (isset($accepted_arguments[$argument[0]]) && $accepted_arguments[$argument[0]] == 1) {
            $url[$argument[0]] = $argument[1];
        }
    }
	
	
	# Blow up the new URL and overwrite arguments in the current URL
    $new_url = explode('&', $new_url);
    foreach ($new_url as $key => $value) {
        $argument = explode('=', $value);
        if (is_array($accepted_arguments)) {
            if ($accepted_arguments[$argument[0]] == 1) {
                $url[$argument[0]] = rawurlencode($argument[1]);
            }
        } elseif (!is_array($accepted_arguments)) {
            $url[$argument[0]] = rawurlencode($argument[1]);
        }
    }
		
	
	# Build the final url
    $return_url  = $base_url . '?';
    $i           = 1;
    foreach ($url as $key => $value) {
        if ($value != '') {
            if ($i > 1) {
                $return_url .= '&';
            }
            $return_url .= $key . '=' . $value;
            $i++;
        }
    }
	
	
	# Output the final url
    return $return_url;
}

?>