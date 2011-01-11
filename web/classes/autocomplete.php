<?php
/*
**************************************************************************
                  AutoSuggest build a database query
**************************************************************************/
include_once('../../config/config.general.php');
	
mysql_connect($settings['dbHost'], $settings['dbUser'], $settings['dbPass']);
mysql_select_db($settings['dbName']) or die ("No Database");
mysql_query("SET NAMES 'utf8'");

$field = $_GET['field'];

$sql = mysql_query("SELECT DISTINCT ".$field." FROM reservations WHERE ".$field." LIKE '".$_GET['q']."%'") or die(mysql_error());
while($data = mysql_fetch_array($sql))
{
echo $data[0]."\r\n";
}
mysql_close();
?>