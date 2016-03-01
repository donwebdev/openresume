<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# application_start.php
# Includes all required files.
# Checks for install wrapper.
# Initialize the entire front end application.
#
#-------------------------------------------------------

# Include the files needed for install.php
require_once('constants.php');
require_once('model/c_db.php');

$db = new DB;

# Check to see if installation is necessary
if(DB_HOSTNAME===NULL || DB_USERNAME===NULL || DB_PASSWORD===NULL) {

	require_once('install.php');	

}

# Check the database connection
if(!$db->connected) {

	require_once('database_error.php');

}

# Load the models
require_once('model/c_cover_letter.php');
require_once('model/c_resume.php');
require_once('model/c_visitor.php');
require_once('model/c_user.php');
require_once('model/settings.php');


# Load the views
require_once('view/c_render_cover_letter.php');
require_once('view/c_render_resume.php');
require_once('view/form_elements.php');
require_once('view/html_header.php');


# Instantiate all the objects we need
$visitor = new Visitor;
$user = new User; 
$cover_letter = new Cover_Letter;
$resume = new Resume;



?>