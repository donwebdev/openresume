<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_user.php
# Create user object based on login status.
# Login controller uses this object to log people in
#
#-------------------------------------------------------


class User {

	public $logged_in = false;
	public $id;
	
	
	# Checks to see if a cookie is valid and logs the user in
	private function validate_cookie($cookie) {
		
		global $db;
		global $settings;
		
		# Check if cookie exists
		if(isset($cookie)) {
		
			$valid = $db->get_row('SELECT * FROM user_login WHERE cookie = "'.$db->real_escape($cookie).'" AND user_agent = "'.$db->real_escape($_SERVER['HTTP_USER_AGENT']).'" AND created >= "'.date('Y-m-d H:i:s',time() - $settings->setting['cookie_time']).'"',ARRAY_A);
			
			if($valid === NULL) {			
				
				$this->logged_in = false;
				
			} else {
				
				$this->logged_in = true;
				
			}
		
		# Cookie doesn't exist, user is not logged in	
		} else {			
				
				$this->logged_in = false;
			
		}
		
	}
	
	
	# Creates a cookie after a successful login
	private function create_cookie($user_id) {
		
		global $db;
		global $settings;
				
		do { $cookie = $this->random_string(128,128); } while ($db->get_row('SELECT cookie FROM impressions WHERE cookie = "' . $cookie . '"') != NULL);
		
		setcookie('openresume_admin',$cookie,time()+$settings->setting['cookie_time']);
		
		$insert_data = array(
			'id' => NULL,
			'user_id' => $user_id,
			'cookie' => $cookie,
			'created' => $db->current_time(),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'user_agent' => $_SERVER['HTTP_USER_AGENT']
		);
						
		$db->insert('user_login', $insert_data);		
		
	}
	
	
	# Turns a string into a hashed password
	private function do_the_hash($password) {
		
		# Add the salt to the password
		$hash = password_hash($password.PW_SALT,PASSWORD_BCRYPT);
		
		return $hash;
		
	}
	
	
	# Creates a new user from submitted data
	public function create_user($user_data) {
		
		global $db;
		
		$insert_data = array(
			'id' => NULL,
			'created' => $db->current_time(),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'user_agent' => $_SERVER['HTTP_USER_AGENT']
		);
						
		$db->insert('users', $insert_data);		
		
	}
	
	
	# Takes an email and password, verifies it, then logs the user in
	public function user_login($email,$password) {
		
		global $db;
		
		$password = $this->do_the_hash($password);
		
		$user = $db->get_row('SELECT * FROM user WHERE email = "' . $email . '" AND password = "'.$password.'"');
		
		# User is verified, log them in
		if($user !== NULL) {
		
			$this->user_login_log($user['id'],'login_successful');		
		
			$this->create_cookie($user['id']);
		
		# User is not verified, return an error	
		} else {
			
			  # Check if the email exists		
			$user = $db->get_row('SELECT * FROM user WHERE email = "' . $email . '"');
			
			# Email was valid, log it here
			if($user !== NULL) {
			
				$this->user_login_log($user['id'],'wrong_password');	
				
			} else {
			
				$this->user_login_log(NULL,'wrong_username');
			
			}
		}	
	}
	
	
	# Logs out a supplied user id
	public function user_logout($user_id) {
		
		global $db;
		
		# Delete all logins for this user
		$db->query('DELETE FROM user_login WHERE user_id = '.$user_id);
		
		# Destroy the cookie
		setcoookie('openresume_admin','',1);
		
		# Log that the user logged out
		$this->user_login_log($user['id'],'logout');	
				
	}
	
	
	# Logs all usages of the login system for security purposes
	public function user_login_log($user_id,$type) {
		
		global $db;
		
		$insert_data = array(
			'id' => NULL,
			'created' => $db->current_time(),
			'user_id' => $user_id,
			'type' => $type,
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'user_agent' => $_SERVER['HTTP_USER_AGENT']
		);
						
		$db->insert('user_login_log', $insert_data);

	}
	
	
	
	# Creates a password reset request
	public function password_reset_request($user_id) {
		
		global $db;

	}
	
	
	# Resets a password if the password request is valid
	public function password_reset($reset_key) {

		global $db;		
		
		
	}
	
	
	# Random alphanumeric string function
	private function random_string($min, $max)
	{
		$str = '';
		for ($i = 0; $i < rand($min, $max); $i++) {
			$num = rand(48, 122);
			if (($num >= 97 && $num <= 122))
				$str .= chr($num);
			else if (($num >= 65 && $num <= 90))
				$str .= chr($num);
			else if (($num >= 48 && $num <= 57))
				$str .= chr($num);
			else
				$i--;
		}
		return $str;
	}
	
	
	
	
}


?>