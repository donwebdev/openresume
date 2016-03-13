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
	public $impression_id = NULL;
	public $id = NULL;
	public $http_referer = NULL;
	private $visitor_type = NULL;
	
	public function __construct()
	{
		{
			if(isset($_SERVER['HTTP_REFERER'])) { $this->http_referer = $_SERVER['HTTP_REFERER']; }
			$this->visitor();
			$this->impression();
		}
	}
	
	# Manually log a visitor and a url
	public function log($url = '')
	{
		$this->visitor();
		$this->impression($url);
	}
	
	public function visitor()
	{
		if ($this->visitor == NULL) {
			
			# Most likely an ajax request, lets not log these.
			if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				return;
			}
			
			global $db;
			global $settings;
			
			# Get the cookie for the visitor info if the visitor cookie is set
			if (isset($_COOKIE['visitor'])) {
				
				$this->visitor = $db->get_row('SELECT * FROM visitors WHERE cookie="' . $_COOKIE['visitor'] . '"', ARRAY_A);
				# Just making this easier to get to
				$this->id = $this->visitor['id'];
				
			} else {
				
				
				# Create a cookie and make sure it's unique				
				do { $cookie = $this->random_string(32, 32); } while ($db->get_row('SELECT cookie FROM visitors WHERE cookie = "' . $cookie . '"') != null);
				
				
				# Parse user agent with Piwik DeviceDetector
				$dd = new DeviceDetector($_SERVER['HTTP_USER_AGENT']);
								
				$dd->parse();
				
				if ($dd->isBot()) {
				  # handle bots,spiders,crawlers,...
				  $filtered = 1;
				  $botInfo = $dd->getBot();
				} else {
				  $filtered = 0;
				  $clientInfo = $dd->getClient();
				  $osInfo = $dd->getOs();
				}				
				
				setcookie('visitor', $cookie, time() + 2592000);
				 
				$url           = parse_url($this->http_referer);
				$referer       = $this->http_referer;
				$geo           = $this->geocode_ip($_SERVER['REMOTE_ADDR']);
				$this->visitor = array(
					'id' => NULL,
					'filtered' => $filtered,
					'created' => $db->current_time(),
					'cookie' => $cookie,
					'ip_address' => $_SERVER['REMOTE_ADDR'],
					'user_agent' => $_SERVER['HTTP_USER_AGENT'],
					'browser' => $clientInfo['name'],
					'browser_version' => $clientInfo['version'],
					'operating_system' => $osInfo['name'].' '.$osInfo['version'],
					'referal_url' => $this->http_referer,
					'country_code' => $geo->country_code,
					'country_name' => $geo->country_name,
					'region_code' => $geo->region_code,
					'region_name' => $geo->region_name,
					'zipcode' => $geo->zip_code,
					'latitude' => $geo->latitude,
					'longitude' => $geo->longitude
				);
								
				$db->insert('visitors', $this->visitor);
				$this->visitor['id'] = $db->insert_id;
				$this->id = $db->insert_id;
			}
		}
		return $this->visitor;
	}
	
	
	public function impression($url = '')
	{
		if ($this->impression == NULL) {
			
			# Quit if it's an ajax request
			
			if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				return;
			}
			
			# Quit if it's admin panel
			if (strpos($url, '/admin/') !== false) {
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
			
			do { $impression_text_id = $this->random_string(7, 7); } while ($db->get_row('SELECT text_id FROM impressions WHERE text_id = "' . $impression_text_id . '"') != null);
			
			$data               = array(
				'id' => NULL,
				'text_id' => $impression_text_id,
				'filtered' => $this->visitor['filtered'],
				'created' => $db->current_time(),
				'visitor_id' => $this->visitor['id'],
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'impression_url' => $url,
				'referal_url' => $this->http_referer
			);
			
			$db->insert('impressions', $data);
			$last_impression  = $db->insert_id;
			$this->impression_id = $impression_text_id;
			return $last_impression;
			
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
	
}


?>