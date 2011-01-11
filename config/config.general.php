<?php
// start main session
session_start();

// ** Database Details Settings

 // ** the database that we will use
 $settings['dbName'] = 'myseat';
 // ** the database host
 // ** mostly 'localhost' fits
 $settings['dbHost'] = 'localhost';
 // ** the database user
 $settings['dbUser'] = 'root';
 // ** the database password
 $settings['dbPass'] = 'root';
 // ** the database port (standard: 3306)
 $settings['dbPort'] = 3306;

// **

// ** Google map API key
// ** Sign up for your own at: http://code.google.com/intl/en-EN/apis/maps/signup.html
// ** Do not use mine please !!
$settings['googlemap_key'] = "ABQIAAAA1-uY3igh_R_JiWHmwKK_UxT75Ut2Ph_t8aXAK0xXRJ_z6BkX6xTyGQK8WxAFbqP1c4QmI7AiZ-VjAQ";

// ********************************************************************
// Do not change anything under this line, except you know what you do.

// ** date & time format database
$settings['dbdate'] = "Y-m-d";
$settings['dbtime'] = "H:i:s";

// array consists of: PHP country code, language name
 $langTrans = array(
		'en_EN' => 'English',
		'de_DE' => 'Deutsch',
		'fr_FR' => 'Français',
		'es_ES' => 'Español',
		'nl_NL' => 'Nederlands',
		'dk_DK' => 'Danske',
		'se_SE' => 'Svenska',
		'it_IT' => 'Italia');

// User roles
	$roles = array(
	'1' => 'Superadmin',
	'2' => 'Admin',
	'3'  => 'Manager',
	'4'  => 'Supervisor',
	'5'   => 'User',
	'6'   => 'Guest'
	);
	
// Advertise start ranges
// in days
$adv_range = array( 3,7,14,30,60,90);


?>