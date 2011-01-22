<?php
	// The default language
	$default_lang = "en";
	
	// The relative path to the lang folder
	$lang_folder = "lang";
	
	//Insert your email address for getting a BCC mail
	$BCCTo = "info@myseat.us";	
	
	
	//Get the language used by the browser
	$browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	$language = "";
	
	// Check if the language file exists
	function use_lang($language)
	{
		global $lang_folder;
		if( is_file($lang_folder."/".$language.".php") )
		{
			return true;
		}
	}	
	
	if( isset($_GET['lang']) && use_lang($_GET['lang']) )
	{
		$language = $_GET['lang'];
	}
	else if ( isset($browser_lang) && use_lang($browser_lang) )
	{
		$language = $browser_lang;
	}
	else 
	{ 
		$language = $default_lang;
	}
	
	// Include the right language file	
    include($lang_folder."/".$language.".php");
	
	// Helper function to echo the values of the $lang array
	function lang($key)
	{
		global $lang;
		echo $lang[$key];
	}
	
	function language_navigation()
	{
		global $lang;
		$languages = $lang["available_language"];
		foreach( $languages as $single_language )
		{
			echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?lang=' . key($languages) . '">'. $single_language . '</a></li>';
			next($languages);
		}
	}
?>