<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# ajax.php
# Handle ajax requests and send them to the right objects
# Output based on ajax request received
#
#-------------------------------------------------------

# Let it be known this is an ajax request
$ajax = true;

# Start the application
require_once('application_start.php');

# Rules for requests
require_once('controller/c_ajax.php');

$ajax = new Ajax;

# Output the output
echo $ajax->output();

?>