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
	
	/* Get POST data */        
	$submitted_id = $_POST['id'];
	$value = $_POST['value'];
	$exid = explode("-",$submitted_id); 
	$field = $exid[0];
	$id = $exid[1];
	
	/* Submit POST data */  
	$sql = querySQL('inline_edit');

	/* Submit POST data */  
	echo $value;
}
?>