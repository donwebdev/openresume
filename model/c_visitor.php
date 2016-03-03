<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_visitor.php
# Logs and tracks the current visitor, instatiates the
# visitor object so it can be accessed in other places.
# Also logs all the page loads of the visitor.
#
#-------------------------------------------------------


    
class Visitor {
	
	public $visitor = NULL;
	public $impression = NULL;
	private $visitor_type = NULL;
	
	public function __construct()
	{
		{
			$this->visitor();
			$this->impression();
		}
	}
	
	public function log($url = '')
	{
		$this->visitor();
		$this->impression($url);
	}
	
	public function visitor()
	{
		if ($this->visitor == NULL) {
			if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				return;
			}
			global $db;
			if (isset($_COOKIE['visitor'])) {
				$this->visitor = $db->get_row('SELECT * FROM visitors WHERE cookie="' . $_COOKIE['visitor'] . '"', ARRAY_A);
			} else {
				
				#create a cookie and make sure it's unique				
				do { $cookie = $this->random_string(32, 32); } while ($db->get_row('SELECT cookie FROM visitors WHERE cookie = "' . $cookie . '"') != null);
				
				setcookie('visitor', $cookie, time() + 2592000);
				
				$url           = parse_url($_SERVER['HTTP_REFERER']);
				$referer       = $_SERVER['HTTP_REFERER'];
				$user_agent    = get_browser($_SERVER['HTTP_USER_AGENT']);
				$geo           = $this->geocode_ip($_SERVER['REMOTE_ADDR']);
				$this->visitor = array(
					'id' => NULL,
					'filtered' => $this->filter(),
					'created' => $db->current_time(),
					'cookie' => $cookie,
					'ip_address' => $_SERVER['REMOTE_ADDR'],
					'user_agent' => $_SERVER['HTTP_USER_AGENT'],
					'browser' => $user_agent->browser . ' ' . $user_agent->version,
					'operating_system' => $user_agent->platform,
					'referal_url' => $_SERVER['HTTP_REFERER'],
					'country_code' => $geo->country_code,
					'country_name' => $geo->country_name,
					'region_code' => $geo->region_code,
					'region_name' => $geo->region_name,
					'zipcode' => $geo->zipcode,
					'latitude' => $geo->latitude,
					'longitude' => $geo->longitude
				);
				$this->insert('visitors', $this->visitor);
				$this->visitor['id'] = $db->insert_id;
			}
		}
		return $this->visitor;
	}
	
	
	public function impression($url = '')
	{
		if ($this->impression == NULL) {
			if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				return;
			}
			global $db;
			if ($url == '') {
				if ($_SERVER['SERVER_PORT'] == '443') {
					$http = 'https://';
				} else {
					$http = 'http://';
				}
				;
				$url = $http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			}
			
			if (strpos($_SERVER['REQUEST_URI'], '/admin_pages/ajax/remote.php') !== false) {
				$url = $_SERVER['HTTP_REFERER'];
			}
			$impression_text_id = $this->random_string(7, 7);
			$data               = array(
				'id' => NULL,
				'text_id' => $impression_text_id,
				'filtered' => $this->filter(),
				'created' => $db->current_time(),
				'visitor_id' => $this->visitor['id'],
				'last_impression_id' => $_COOKIE['last_impression'],
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'impression_url' => $url,
				'referal_url' => $_SERVER['HTTP_REFERER']
			);
			
			$this->insert('impressions', $data);
			$last_impression  = $db->insert_id;
			$data['id']       = $last_impression;
			$this->impression = $data;
			setcookie('last_impression', $last_impression, time() + 2592000);
			return $last_impression;
			
		}
	}
	
	public function filter()
	{
		global $db;
		global $user;
		$ip_address   = $db->real_escape($_SERVER['REMOTE_ADDR']);
		$user_agent   = $db->real_escape($_SERVER['HTTP_USER_AGENT']);
		$filter_check = $db->query('SELECT * FROM click_filter WHERE (ip_address = "' . $ip_address . '" AND user_agent = "' . $user_agent . '" ) OR (ip_address = "' . $ip_address . '" AND user_agent = "" ) OR (ip_address = "" AND user_agent = "' . $user_agent . '" ) OR (ip_address = "' . $ip_address . '" AND user_agent IS NULL ) OR (ip_address IS NULL AND user_agent = "' . $user_agent . '" )');
		
		if ($filter_check > 0 && $user->logged_in === false) {
			return "1";
		} else {
			return "0";
		}
		
	}
	
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
	
	public function geocode_ip($ip_address = '')
	{
		if ($ip_address != '') {
			$timeout  = 1;
			$data     = array();
			$call     = "http://freegeoip.net/json/" . $ip_address;
			$handle   = @fopen($call, "rb");
			$contents = @stream_get_contents($handle);
			@fclose($handle);
			$data[] = @json_decode($contents);
			if ($data != '') {
				foreach ($data as $d) {
					return $d;
				}
			}
		}
	}
	
	public function insert($table_name, $data)
	{
		global $db;
		$final_data = array();
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				if (strpos($key, '_id') !== false) {
					if ($value == '') {
						$final_data[$key] = 0;
					} elseif (is_null($value)) {
						$final_data[$key] = 0;
					} else {
						$final_data[$key] = $value;
					}
				} else {
					$final_data[$key] = $value;
				}
			}
		}
		$return = $db->insert($table_name, $final_data);
		return $return;
	}
	
	public function update($table_name, $data, $conditions)
	{
		global $db;
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				if (strpos($key, '_id') !== false) {
					if ($value == '') {
						$final_data[$key] = 0;
					} elseif (is_null($value)) {
						$final_data[$key] = 0;
					} else {
						$final_data[$key] = $value;
					}
				} else {
					$final_data[$key] = $value;
				}
			}
		}
		$return = $db->update($table_name, $final_data, $conditions);
		return $return;
	}
}

?>