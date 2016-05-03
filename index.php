<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# index.php
# Starts and ends the application stack
#
#-------------------------------------------------------

# Load the model
require('application_start.php');

# Load the Resume View
require('resume.php');

# Output the Resume View and end execution
require('application_end.php');

?>