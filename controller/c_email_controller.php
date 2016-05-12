<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# controller/c_email_controller.php
# Simple email wrapper to send emails easily
# Email messages are saved in this object as well
#
#-------------------------------------------------------




class Email_Controller {

	
	public function send_email($email_type,$params) {
	
		if(method_exists($this,$email_type)) {
		
			$this->$email_type($params);
			
		}
		
	}
	
	private function email($to,$from,$subject,$message) {
	
		$headers = 	'From: '. $from . "\r\n" .
					'Reply-To: '. $from . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
	
		mail($to,$subject,$message,$headers);
		
	}
	
	
	private function contact_form($params) {
	
		global $db;
		global $settings;
		
		$subject = LANG_CONTACT_EMAIL_SUBJECT.$params['name'];
			
		$message = '
			
			'.LANG_EMAIL_RECEIVED_MESSAGE.'
			
			'.$params['name'].'
			'.$params['email'].'
			
			'.$params['message'].'
			
			<a href="'.$settings->setting['admin_url'].'">'.LANG_EMAIL_LOGIN_TO_ADMIN.'</a>
	
			'.LANG_EMAIL_GENERATED_BY.' '.VERSION_STATE.' '.VERSION_NUMBER.'
		
		';
	
		$this->email($settings->setting['your_email'],$subject,$message,$settings->setting['site_email']);	
		
	}
	
	
	private function password_reset_request($params) {
	
		
		
	}
	
	
	private function password_reset($params) {
	
	
		
	}
	
	
}



?>