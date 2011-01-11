<?php
/* Connection to Database */
// ** set configuration
include('../../config/config.general.php');
// ** database functions
include('../classes/database.class.php');
// ** connect to database
include('../classes/connect.db.php');
// ** all database queries
include('../classes/db_queries.db.php');

if($_POST['id']){
	// prevent dangerous input
	secureSuperGlobals();
	
	$value = $_POST['value'];
	$id = (int)$_POST['id'];
	
	if ($select_id !='undefinded') {
		$sql = querySQL('update_status');
		echo $sql;
	}else{
		echo "AJAX Error";
	}
}
?>