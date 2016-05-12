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
global $visitor;

if($page_title == '') {
	
	$page_title = $settings->setting['site_title'];
	
}
	
$output = '<!DOCTYPE html>
<html>
<head>

  <title>'.$page_title.'</title>
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.css">   
  <link rel="stylesheet" href="view/styles/'.$resume->style.'">  
  <script type="text/javascript" src="libs/jquery-1.12.1.min.js"></script>
  <script type="text/javascript" src="libs/jquery-ui/jquery-ui.min.js"></script>
  <script type="text/javascript" src="libs/notify.js"></script>
  <script type="text/javascript" src="libs/verify.php?r_id='.$visitor->impression_id.'&language='.$settings->setting['language'].'"></script>
  <script type="text/javascript" src="libs/bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" src="view/js/contact.js"></script>
  <script type="text/javascript" src="view/js/ajax_handler.js"></script>


</head>
<body class="openresume_body">	

<div class="container-fluid resume_container">
	
';
	
	
return $output;
	
}


?>