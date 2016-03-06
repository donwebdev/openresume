<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# view/html_header.php
# Load Bootstrap and jQuery and all HTML headers.
# Use Resume Object to load correct styles.
#
#-------------------------------------------------------


function html_header($page_title='') {

global $settings;

if($page_title == '') {
	
	$page_title = $settings->setting['site_title'];
	
}
	
$output = '

<!DOCTYPE html>
<html>
<head>

  <title>'.$page_title.'</title>
  
  <script type="text/javascript" src="libs/jquery-1.12.1.min.js"></script>

</head>

<body>	
	
';
	
	
return $output;
	
}


?>