<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# view/html_footer.php
# Creates HTML for the footer. 
# Mainly date, copyright and credits.
#
#-------------------------------------------------------


function html_footer() {
	
$output = '


	<footer class="container-fluid text-center">
		<p id="footer" class="footer">This site powered by <a href="http://www.phpopenresume.com">OpenResume</a> - '.VERSION_STATE.' '.VERSION_NUMBER.' - &copy;'.date('Y').'</p>
	</footer>
	
</body>
</html>

';

return $output;

}


?>