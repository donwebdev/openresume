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
require('constants.php');
require('model/c_db.php');


# Check to see if installation is necessary
if(DB_NAME===NULL || DB_USER===NULL || DB_PASSWORD===NULL || DB_HOST===NULL) {

	require('install.php');	

}

# Instantiate the database wrapper
$db = new DB(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);


# Check the database connection
if(!$db->has_connected) {

	require('database_error.php');

}


# Load the models
require('model/c_cover_letter.php');
require('model/c_resume.php');
require('model/c_visitor.php');
require('model/c_user.php');
require('model/c_settings.php');

# SpyC for Piwik
require('libs/spyc/Spyc.php');

# Piwik user agent parser
require('libs/device-detector/DeviceDetector.php');
require('libs/device-detector/Cache/Cache.php');
require('libs/device-detector/Cache/StaticCache.php');
require('libs/device-detector/Parser/ParserAbstract.php');
require('libs/device-detector/Parser/Bot.php');
require('libs/device-detector/Parser/OperatingSystem.php');
require('libs/device-detector/Parser/VendorFragment.php');
require('libs/device-detector/Parser/Client/ClientParserAbstract.php');
require('libs/device-detector/Parser/Client/Browser/Engine.php');
require('libs/device-detector/Parser/Device/DeviceParserAbstract.php');

# Load the views
require('view/c_render_contact_form.php');
require('view/c_render_cover_letter.php');
require('view/c_render_resume.php');
require('view/c_form.php');
require('view/html_header.php');
require('view/html_footer.php');

# Load the controllers
require('controller/c_form_controller.php');
require('controller/c_contact_controller.php');
require('controller/c_email_controller.php');


# Instantiate controller objects
$email = new Email_Controller;

$settings = new Settings;

# Don't make objects if this is ajax

if(!isset($ajax)) {

# Instantiate all the model objects we need
$resume = new Resume;
$visitor = new Visitor;
$user = new User; 
$cover_letter = new Cover_Letter;

}

# Load the language
require('language/'.$settings->setting['language'].'/frontend.php');
require('language/'.$settings->setting['language'].'/email.php');

?>