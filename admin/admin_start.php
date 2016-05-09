<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# admin/admin_start.php
# Load all the files needed for starting the admin panel
# Start the stack that will create the admin panel
#
#-------------------------------------------------------

# Include the files needed for install.php
require('../constants.php');
require('../model/c_db.php');


# Check to see if installation is necessary
if(DB_NAME===NULL || DB_USER===NULL || DB_PASSWORD===NULL || DB_HOST===NULL) {

	require('../install.php');	

}

# Instantiate the database wrapper
$db = new DB(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);


# Check the database connection
if(!$db->has_connected) {

	require('../database_error.php');

}


# Load the models
require('../model/c_admin.php');
require('../model/c_admin_analytics.php');
require('../model/c_admin_coverletter.php');
require('../model/c_admin_messages.php');
require('../model/c_admin_query.php');
require('../model/c_admin_resume.php');
require('../model/c_admin_settings.php');
require('../model/c_cover_letter.php');
require('../model/c_resume.php');
require('../model/c_visitor.php');
require('../model/c_user.php');
require('../model/c_settings.php');
require('../model/c_tables.php');

# SpyC
require('../libs/spyc/Spyc.php');

# Piwik user agent parser
require('../libs/device-detector/DeviceDetector.php');
require('../libs/device-detector/Cache/Cache.php');
require('../libs/device-detector/Cache/StaticCache.php');
require('../libs/device-detector/Parser/ParserAbstract.php');
require('../libs/device-detector/Parser/Bot.php');
require('../libs/device-detector/Parser/OperatingSystem.php');
require('../libs/device-detector/Parser/VendorFragment.php');
require('../libs/device-detector/Parser/Client/ClientParserAbstract.php');
require('../libs/device-detector/Parser/Client/Browser/Engine.php');
require('../libs/device-detector/Parser/Device/DeviceParserAbstract.php');

# Load the views;
require('../view/c_render_admin.php');
require('../view/c_render_admin_analytics.php');
require('../view/c_render_admin_coverletter.php');
require('../view/c_render_admin_login.php');
require('../view/c_render_admin_messages.php');
require('../view/c_render_admin_resume.php');
require('../view/c_render_admin_settings.php');
require('../view/c_render_cover_letter.php');
require('../view/c_render_resume.php');
require('../view/c_form.php');
require('../view/c_render_table.php');
require('../view/html_footer.php');
require('../view/html_header_admin.php');

# Load the controllers
require('../controller/c_contact_controller.php');
require('../controller/c_email_controller.php');
require('../controller/c_form_controller.php');
require('../controller/c_login_controller.php');
require('../controller/c_user_controller.php');


# Instantiate model objects
$tables = new Tables;
# Create the array of table structures
$tables->table_arrays();

# Instantiate view objects
$settings = new Settings;
$visitor = new Visitor;

# Instantiate controller objects
$email = new Email_Controller;
$user = new User_Controller; 

# Load the language
require('../language/'.$settings->setting['language'].'/admin.php');
require('../language/'.$settings->setting['language'].'/email.php');


# Make sure that output is set
$admin_output = '';

?>