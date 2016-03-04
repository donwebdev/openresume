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


# Check to see if installation is necessary
if(DB_NAME===NULL || DB_USER===NULL || DB_PASSWORD===NULL || DB_HOST===NULL) {

	require_once('install.php');	

}

# Instantiate the database wrapper
$db = new DB(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);


# Check the database connection
if(!$db->has_connected) {

	require_once('database_error.php');

}


# Load the models
require_once('model/c_cover_letter.php');
require_once('model/c_resume.php');
require_once('model/c_visitor.php');
require_once('model/c_user.php');
require_once('model/c_settings.php');

# SpyC
require_once('libs/spyc/Spyc.php');

# Piwik user agent parser
require_once('libs/device-detector/DeviceDetector.php');
require_once('libs/device-detector/Cache/Cache.php');
require_once('libs/device-detector/Cache/StaticCache.php');
require_once('libs/device-detector/Parser/ParserAbstract.php');
require_once('libs/device-detector/Parser/Bot.php');
require_once('libs/device-detector/Parser/OperatingSystem.php');
require_once('libs/device-detector/Parser/VendorFragment.php');
require_once('libs/device-detector/Parser/Client/ClientParserAbstract.php');
require_once('libs/device-detector/Parser/Client/Browser/Engine.php');
require_once('libs/device-detector/Parser/Device/DeviceParserAbstract.php');


# Load the views
require_once('view/c_render_cover_letter.php');
require_once('view/c_render_resume.php');
require_once('view/form_elements.php');
require_once('view/html_header.php');
require_once('view/html_footer.php');


# Instantiate all the objects we need
$settings = new Settings;
$visitor = new Visitor;
$user = new User; 
$cover_letter = new Cover_Letter;
$resume = new Resume;

?>