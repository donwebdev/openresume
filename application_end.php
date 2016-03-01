<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# application_end.php
# Outputs HTML for the page.
# Wraps everything up and ends execution of the app.
#
#-------------------------------------------------------


#Build HTML Output
$output = html_header();
if(isset($cover_letter_output)) { $output .= $cover_letter_output->output; }
if(isset($resume_output)) { $output .= $resume_output->output; }
$output .= html_footer();


#Do any DOM processing on the page here



#Finally put the HTML onto the page
echo $output;


#Finish application, close connections, log load times and anything else that needs logging



?>