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
global $visitor;
global $user;

if($page_title == '') {
	
	$page_title = $settings->setting['site_title'];
	
}

$custom_css = '';

if($user->logged_in === false) {
	
	
	# Stick the powered by text to the bottom of the page
	$custom_css = '
	<style type="text/css">
	
	.footer {	
		position: 		fixed;
		bottom: 		0%;
		margin: 		10px auto;
		width: 			100%;
		text-align: 	center;
	}
	
	</style>
	';
	
}
	
$output = '

<!DOCTYPE html>
<html>
<head>

  <title>'.$page_title.'</title>
  
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap.css">   
  <link rel="stylesheet" href="../view/styles/admin.css">  
  <script type="text/javascript" src="../libs/jquery-1.12.1.min.js"></script>
  <script type="text/javascript" src="../libs/jquery-ui/jquery-ui.min.js"></script>
  <script type="text/javascript" src="../libs/notify.js"></script>
  <script type="text/javascript" src="../libs/verify.php?r_id='.$visitor->impression_id.'&language='.$settings->setting['language'].'"></script>
  <script type="text/javascript" src="../libs/bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" src="../view/js/contact.js"></script>
  <script type="text/javascript" src="../view/js/ajax_handler.js"></script>

  '.$custom_css.'

</head>

<body>	
	
<div class="container-fluid admin_container">

';
	
	
return $output;
	
}



?>