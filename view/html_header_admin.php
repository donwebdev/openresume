<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# view/html_header_admin.php
# Load Bootstrap and jQuery and all HTML headers.
# Build the menu for the admin panel
#
#-------------------------------------------------------


function html_header_admin($page_title='') {

global $settings;

if($page_title == '') {
	
	$page_title = $settings->setting['site_title'];
	
}
	
$output = '

<!DOCTYPE html>
<html>
<head>

  <title>'.$page_title.'</title>
  
  <script type="text/javascript" src="../libs/jquery-1.12.1.min.js"></script>

</head>

<body>	
	
';
	
	
return $output;
	
}



?>