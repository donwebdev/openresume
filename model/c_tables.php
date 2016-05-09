<?php

#-------------------------------------------------------
#
# OPEN RESUME by Don Westendorp
# © 2016 - Released under GPL v3 Licensing
#
# model/c_tables.php
# Data structure for the application
#
#-------------------------------------------------------


class Tables {
	
	public $table_array = array();
	public $table_sql = '
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `impressions`
		--
		
		CREATE TABLE `impressions` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `text_id` varchar(7) NOT NULL,
		  `visitor_id` int(11) NOT NULL,
		  `resume_id` int(11) DEFAULT NULL,
		  `ip_address` varchar(16) NOT NULL,
		  `filtered` tinyint(1) NOT NULL,
		  `created` datetime NOT NULL,
		  `page_time` int(11) DEFAULT NULL,
		  `impression_url` text NOT NULL,
		  `referal_url` text,
		  `load_time` decimal(10,3) DEFAULT NULL,
		  UNIQUE KEY `id` (`id`),
		  UNIQUE KEY `text_id` (`text_id`)
		) ENGINE=InnoDB AUTO_INCREMENT=2420 DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `messages`
		--
		
		CREATE TABLE `messages` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `resume_id` int(11) NOT NULL,
		  `visitor_id` int(11) NOT NULL,
		  `impression_id` varchar(7) NOT NULL,
		  `created` datetime NOT NULL,
		  `name` varchar(255) NOT NULL,
		  `email` varchar(255) NOT NULL,
		  `message` text NOT NULL,
		  `ip_address` varchar(20) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `resumes`
		--
		
		CREATE TABLE `resumes` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `created` datetime NOT NULL,
		  `deleted` datetime DEFAULT NULL,
		  `display_type` enum(\'Main\',\'Secondary\',\'Hidden\') NOT NULL,
		  `show_contact_details` tinyint(1) NOT NULL,
		  `show_contact_form` tinyint(1) NOT NULL,
		  `show_phone` tinyint(1) NOT NULL,
		  `show_email` tinyint(1) NOT NULL,
		  `show_address` tinyint(1) NOT NULL,
		  `name` varchar(64) NOT NULL,
		  `title` varchar(255) DEFAULT NULL,
		  `portrait` varchar(255) DEFAULT NULL,
		  `description` text,
		  `style` varchar(64) NOT NULL,
		  `override_name` varchar(128) DEFAULT NULL,
		  `override_address_1` varchar(128) DEFAULT NULL,
		  `override_address_2` varchar(128) DEFAULT NULL,
		  `override_phone` varchar(128) DEFAULT NULL,
		  `override_email` varchar(128) DEFAULT NULL,
		  `secondary_resume_order` int(11) DEFAULT NULL,
		  UNIQUE KEY `id` (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `resume_cover_letters`
		--
		
		CREATE TABLE `resume_cover_letters` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `resume_id` int(11) NOT NULL,
		  `linkname` varchar(255) DEFAULT NULL,
		  `created` datetime NOT NULL,
		  `deleted` datetime DEFAULT NULL,
		  `name` varchar(64) NOT NULL,
		  `description` text NOT NULL,
		  `addressee` text NOT NULL,
		  `text` text NOT NULL,
		  UNIQUE KEY `id` (`id`),
		  UNIQUE KEY `linkname` (`linkname`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `resume_edit_log`
		--
		
		CREATE TABLE `resume_edit_log` (
		  `id` int(6) NOT NULL AUTO_INCREMENT,
		  `created` datetime NOT NULL,
		  `deleted` datetime DEFAULT NULL,
		  `name` varchar(64) NOT NULL,
		  `description` text NOT NULL,
		  UNIQUE KEY `id` (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `resume_items`
		--
		
		CREATE TABLE `resume_items` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `resume_section_id` int(11) NOT NULL,
		  `resume_item_id` int(11) DEFAULT NULL,
		  `resume_item_type_id` int(11) DEFAULT NULL,
		  `created` datetime NOT NULL,
		  `deleted` datetime DEFAULT NULL,
		  `value` text NOT NULL,
		  `item_order` int(11) NOT NULL,
		  UNIQUE KEY `id` (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `resume_item_types`
		--
		
		CREATE TABLE `resume_item_types` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `section_type` varchar(64) NOT NULL,
		  `created` datetime NOT NULL,
		  `deleted` datetime DEFAULT NULL,
		  `name` varchar(64) NOT NULL,
		  `description` text NOT NULL,
		  UNIQUE KEY `id` (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `resume_sections`
		--
		
		CREATE TABLE `resume_sections` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `resume_id` int(11) NOT NULL,
		  `created` datetime NOT NULL,
		  `deleted` datetime DEFAULT NULL,
		  `section_type` enum(\'Text\',\'Bullet Points\') NOT NULL,
		  `title` varchar(255) NOT NULL,
		  `sub_title` varchar(255) NOT NULL,
		  `description` text NOT NULL,
		  `item_order` int(11) NOT NULL,
		  UNIQUE KEY `id` (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `settings`
		--
		
		CREATE TABLE `settings` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) NOT NULL,
		  `value` text,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `name` (`name`)
		) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `users`
		--
		
		CREATE TABLE `users` (
		  `id` int(6) NOT NULL AUTO_INCREMENT,
		  `created` datetime NOT NULL,
		  `name` varchar(64) DEFAULT NULL,
		  `email` varchar(255) NOT NULL,
		  `password` varchar(255) NOT NULL,
		  UNIQUE KEY `id` (`id`),
		  UNIQUE KEY `email` (`email`)
		) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `user_login`
		--
		
		CREATE TABLE `user_login` (
		  `id` int(6) NOT NULL AUTO_INCREMENT,
		  `user_id` int(11) NOT NULL,
		  `cookie` varchar(128) NOT NULL,
		  `created` datetime NOT NULL,
		  `ip_address` varchar(32) NOT NULL,
		  `user_agent` text NOT NULL,
		  UNIQUE KEY `id` (`id`),
		  UNIQUE KEY `cookie` (`cookie`)
		) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `user_login_log`
		--
		
		CREATE TABLE `user_login_log` (
		  `id` int(6) NOT NULL AUTO_INCREMENT,
		  `user_id` int(11) DEFAULT NULL,
		  `visitor_id` int(11) DEFAULT NULL,
		  `created` datetime NOT NULL,
		  `type` varchar(32) NOT NULL,
		  `ip_address` varchar(64) NOT NULL,
		  `user_agent` text NOT NULL,
		  UNIQUE KEY `id` (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `user_password_reset`
		--
		
		CREATE TABLE `user_password_reset` (
		  `id` int(6) NOT NULL AUTO_INCREMENT,
		  `created` datetime NOT NULL,
		  `deleted` datetime DEFAULT NULL,
		  `name` varchar(64) NOT NULL,
		  `description` text NOT NULL,
		  UNIQUE KEY `id` (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		
		-- --------------------------------------------------------
		
		--
		-- Table structure for table `visitors`
		--
		
		CREATE TABLE `visitors` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `cookie` varchar(32) NOT NULL,
		  `filtered` tinyint(1) NOT NULL DEFAULT \'0\',
		  `created` datetime NOT NULL,
		  `bounce` datetime DEFAULT NULL,
		  `ip_address` varchar(16) NOT NULL,
		  `user_agent` text,
		  `browser` varchar(32) DEFAULT NULL,
		  `browser_version` varchar(32) DEFAULT NULL,
		  `operating_system` varchar(32) DEFAULT NULL,
		  `referal_url` varchar(255) DEFAULT NULL,
		  `country_code` varchar(2) DEFAULT NULL,
		  `country_name` varchar(64) DEFAULT NULL,
		  `region_code` varchar(12) DEFAULT NULL,
		  `region_name` varchar(128) DEFAULT NULL,
		  `zipcode` varchar(16) DEFAULT NULL,
		  `latitude` decimal(7,4) DEFAULT NULL,
		  `longitude` decimal(7,4) DEFAULT NULL,
		  UNIQUE KEY `id` (`id`),
		  UNIQUE KEY `cookie` (`cookie`)
		) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

';

	# Breakdown table structure into an array
	public function table_arrays() {
		
		# Blow up the statement into individual tables
		$tables = explode('-- Table structure for table',$this->table_sql);
		
		# Explode string
			$explode = '
		--
		
		';
		
		# Get rid of the first entry in the array
		unset($tables[0]);
		
		# Iterate through each table individually and build 
		foreach($tables as $key => $value) {
		
		
			# Get the table name and make an array
			$table_name = explode($explode,$value);
			$table_name = ltrim(str_replace('`','',$table_name[0]),' ');
						
			# Get the table fields 
			preg_match_all("/`(.+)` (\w+)\(? ?(\d*) ?\)?/", $value, $_matches, PREG_SET_ORDER);
		
			# Put the table fields into the array
			$array[$table_name] = $_matches;
			
			
		}
		
		print_r($array);
		
	}
		
	
}

?>