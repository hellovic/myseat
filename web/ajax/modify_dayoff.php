<?php session_start();
/* Connection to Database */
// ** set configuration
include('../../config/config.general.php');
// ** database functions
include('../classes/database.class.php');
// ** connect to database
include('../classes/connect.db.php');
// ** all database queries
include('../classes/db_queries.db.php');

	// prevent dangerous input
	secureSuperGlobals();
	
	$value = $_POST['value'];
	$id	   = $_POST['id'];
	
	$sql = querySQL('update_maitre_dayoff');
	
	echo $sql;
?>