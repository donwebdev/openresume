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
require_once('model/c_visitor.php');


# Check to see if installation is necessary
if(DB_HOSTNAME===NULL || DB_USERNAME===NULL || DB_PASSWORD===NULL) {

	require_once('install.php');	

}

# Check the database connection


# Include the rest of the files


?>