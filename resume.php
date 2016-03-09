<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# resume.php
# Does logic to initalize resume and cover letter objects
# Creates output objects
#
#-------------------------------------------------------


#Make a cover letter if we need one
if($cover_letter->render_cover_letter === true) {	
	$cover_letter_output = new Cover_Letter_Output($cover_letter); 	
}
	
$contact_form = new Contact_Form($resume);

$resume_output = new Resume_Output($resume,$cover_letter,$contact_form); 
	


?>