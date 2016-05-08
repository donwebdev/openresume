<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# admin/menu.php
# Renders the menu for the admin panel
# Simple flat stack logic, the menu isn't complicated
#
#-------------------------------------------------------


function admin_menu() {
	
	global $user;
	global $admin_pages;

	$output = '';	
		
	# User is logged in, render the menu
	if($user->logged_in === true) {
		
	# Menu Container
	$output .= '
	<div class="admin_menu page_width">
		<ul>';
	
	foreach($admin_pages as $key => $value) {
	
		if((isset($_GET['admin_page']) && $_GET['admin_page'] == $value) || (!isset($_GET['admin_page']) && $value == 'resume')) {
	
			$class = ' class="menu_this_page"';					
			
		} else {
	
			$class = '';
					
		}
		
		$output .= '<li'.$class.'><a href="'.url('admin_page='.$value,'admin_page').'">'.constant('LANG_MENU_'.strtoupper($value)).'</a></li>';
		
	}
	
	
	$output .= '<li class="logout_li"><a href="'.url('logout=1','logout').'" class="logout_link">'.LANG_LOGOUT.'</a></li></ul>';
	
	
	# Menu Container Close
	$output .= '
	</div>'; 
	
	}

	return $output;
	
}

?>