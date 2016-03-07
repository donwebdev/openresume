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
global $resume;

if($page_title == '') {
	
	$page_title = $settings->setting['site_title'];
	
}
	
$output = '

<!DOCTYPE html>
<html>
<head>

  <title>'.$page_title.'</title>
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.css">   
  <link rel="stylesheet" href="view/styles/'.$resume->style.'">  
  <script type="text/javascript" src="libs/jquery-1.12.1.min.js"></script>
  <script type="text/javascript" src="libs/bootstrap/js/bootstrap.js"></script>

</head>
<body>	


<div class="container-fluid">
	
';
	
	
return $output;
	
}


?>