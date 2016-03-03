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
	/*
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
	
	public function register_plugin($name, $class_name, $version, $version)
	{
		global $db;
		$this_plugin = array(
			'name' => $name,
			'class_name' => $class_name,
			'version' => $version,
			'version' => $version
		);
		$where['id'] = $db->get_var('SELECT id FROM ' . TABLE_PREFIX . 'plugins WHERE name="' . $name . '"');
		if ($where['id'] != NULL) {
			$this->update(TABLE_PREFIX . 'plugins', $this_plugin, $where);
			return;
		}
		$this_plugin['time_created'] = current_time('mysql');
		$this->insert(TABLE_PREFIX . 'plugins', $this_plugin);
	}
	public function check_plugin($name)
	{
		$version = false;
		foreach ($this->plugins as $plugin) {
			if ($plugin['name'] == $name) {
				return $plugin['version'];
			}
		}
		return $version;
	}
	public function visitor()
	{
		if ($this->visitor == NULL) {
			if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				return;
			}
			global $db;
			if (isset($_COOKIE['visitor'])) {
				$this->visitor = $db->get_row('SELECT * FROM ' . DB_PREFIX . 'visitors WHERE cookie="' . $_COOKIE['visitor'] . '"', ARRAY_A);
			} else {
				do {
					$cookie = $this->random_string(32, 32);
				} while ($db->get_row("SELECT * FROM " . DB_PREFIX . "visitors WHERE cookie = '" . $cookie . "'") != null);
				setcookie('visitor', $cookie, time() + 2592000);
				$url           = parse_url($_SERVER['HTTP_REFERER']);
				$referer       = $_SERVER['HTTP_REFERER'];
				$user_agent    = new user_agent();
				$geo           = $this->geocode_ip($_SERVER['REMOTE_ADDR']);
				$this->visitor = array(
					'id' => NULL,
					'filtered' => $this->filter(),
					'campaign_traffic' => $this->is_campaign_traffic(),
					'time_created' => current_time('mysql'),
					'visitor_type' => $this->traffic_type(),
					'cookie' => $cookie,
					'ip_address' => $_SERVER['REMOTE_ADDR'],
					'user_agent' => $_SERVER['HTTP_USER_AGENT'],
					'browser' => ucwords($user_agent->getBrowserName()) . ' ' . $user_agent->getBrowserVersion(),
					'operating_system' => ucwords($user_agent->getOperatingSystem()),
					'referal_url' => $_SERVER['HTTP_REFERER'],
					'country_code' => $geo->country_code,
					'country_name' => $geo->country_name,
					'region_code' => $geo->region_code,
					'region_name' => $geo->region_name,
					'zipcode' => $geo->zipcode,
					'latitude' => $geo->latitude,
					'longitude' => $geo->longitude
				);
				$this->insert(DB_PREFIX . 'visitors', $this->visitor);
				$this->visitor['id'] = $db->insert_id;
			}
		}
		return $this->visitor;
	}
	private function is_campaign_traffic()
	{
		return is_numeric($_COOKIE['inc_click_id']);
	}
	public function traffic_type()
	{
		if ($this->visitor_type == NULL) {
			if ($this->is_referrer_search()) {
				$traffic = TRAFFIC_SEARCH;
			} elseif ($_SERVER['HTTP_REFERER'] != '' && $_COOKIE['last_impression'] == '') {
				$traffic = TRAFFIC_LINK;
			} elseif ($_SERVER['HTTP_REFERER'] == '') {
				$traffic = TRAFFIC_DIRECT;
			} elseif ($_COOKIE['last_impression'] != '') {
				$traffic = TRAFFIC_INTERNAL;
			}
			return $traffic;
		} else {
			return $this->visitor_type;
		}
	}
	private function is_referrer_search()
	{
		$search_engines = array(
			'google.com',
			'yahoo.com',
			'search.com',
			'altavista.com',
			'excite.com',
			'lycos.com',
			'alltheweb.com',
			'metacrawler.com',
			'dogpile.com',
			'go.com',
			'ask.com',
			'bing.com'
		);
		foreach ($search_engines as $search) {
			if (strpos($_SERVER['HTTP_REFERER'], $search) !== false) {
				return true;
			}
		}
		return false;
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
			if (strpos($_SERVER['REQUEST_URI'], '/wp-admin/') === false && $is_pixel != 1) {
				$wp_post_id = get_the_ID();
				if (strpos($_SERVER['REQUEST_URI'], '/admin_pages/ajax/remote.php') !== false) {
					$url = $_SERVER['HTTP_REFERER'];
				}
				$impression_text_id = $this->random_string(7, 7);
				$data               = array(
					'id' => NULL,
					'text_id' => $impression_text_id,
					'filtered' => $this->filter(),
					'time_created' => current_time('mysql'),
					'wp_post_id' => $wp_post_id,
					'visitor_id' => $this->visitor['id'],
					'last_impression_id' => $_COOKIE['last_impression'],
					'ip_address' => $_SERVER['REMOTE_ADDR'],
					'impression_url' => $url,
					'referal_url' => $_SERVER['HTTP_REFERER']
				);
				if ($this->check_plugin('wpppc') !== false) {
					$landing_page = $db->get_row("SELECT id FROM " . WPPPC_DB_PREFIX . "wpppc_landing_pages WHERE url = '" . $url . "'", ARRAY_A);
					if ($_COOKIE['inc_click_id'] != '') {
						$incoming_click_id = $_COOKIE['inc_click_id'];
					}
					$data['wpppc_incoming_click_id'] = $incoming_click_id;
					$data['wpppc_landing_page_id']   = $landing_page['id'];
				}
				$this->insert(DB_PREFIX . "impressions", $data);
				$last_impression  = $db->insert_id;
				$data['id']       = $last_impression;
				$this->impression = $data;
				setcookie('last_impression', $last_impression, time() + 2592000);
				return $last_impression;
			}
		}
	}
	public function filter()
	{
		global $db;
		$ip_address   = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
		$user_agent   = mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']);
		$filter_check = $db->query('SELECT * FROM ' . DB_PREFIX . 'click_filter WHERE (ip_address = "' . $ip_address . '" AND user_agent = "' . $user_agent . '" ) OR (ip_address = "' . $ip_address . '" AND user_agent = "" ) OR (ip_address = "" AND user_agent = "' . $user_agent . '" ) OR (ip_address = "' . $ip_address . '" AND user_agent IS NULL ) OR (ip_address IS NULL AND user_agent = "' . $user_agent . '" )');
		if ($filter_check > 0 || current_user_can('edit_posts')) {
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
		$db->query('SET foreign_key_checks=0;');
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
		$db->query('SET foreign_key_checks=1;');
		return $return;
	}
	public function update($table_name, $data, $conditions)
	{
		global $db;
		$db->query('SET foreign_key_checks=0;');
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
		$db->query('SET foreign_key_checks=1;');
		return $return;
	}*/
}

?>