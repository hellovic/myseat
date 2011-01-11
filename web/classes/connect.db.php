<?php
// DB connect
$link = mysql_connect($settings['dbHost'].':'.$settings['dbPort'], $settings['dbUser'], $settings['dbPass']);
        mysql_query("SET NAMES 'utf8'");
        mysql_query("SET CHARACTER SET 'utf8'");
if (!$link)
	die('Not connected: ' . mysql_error());
if (!mysql_select_db($settings['dbName']))
	die ("Can't use ".$settings['dbName'].": " . mysql_error());
?>