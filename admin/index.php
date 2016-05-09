<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# admin/index.php
# Initialize the admin panel
#
#-------------------------------------------------------


# Load the model
require('admin_start.php');


# Instantiate the model
$admin = new Admin;

# Pass the model to the view
$admin_output = new Admin_Output($admin);


# Output the Resume View and end execution
require('admin_end.php');

?>