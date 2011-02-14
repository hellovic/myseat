<?php
// prevent dangerous input
secureSuperGlobals();

// CSRF - Secure forms with token
if ($_SESSION['token'] == $_POST['token']) {
	// submitted forms storage
	if ($_POST['action']=='save_res') {
		// Out of order; see ajax/process_reservation.php
		//$resultQuery = writeForm('reservations');
	}else if ($_POST['action']=='save_book' &&  (int)$_POST['verify'] == 4) {
		$resultQuery = writeForm('reservations');
	}else if ($_POST['action']=='save_out') {
		$resultQuery = writeForm('outlets');
	}else if ($_POST['action']=='save_maitre') {
		$resultQuery = writeForm('maitre');
	}else if ($_POST['action']=='save_set') {
		$resultQuery = writeForm('settings');
	}else if ($_POST['action']=='save_evnt') {
		$resultQuery = writeForm('events');
	}else if ($_POST['action']=='save_prpty') {
		$resultQuery = writeForm('properties');
		$_SESSION['property'] = $resultQuery;
		$_SESSION['propertyID'] = $resultQuery;
	}else if ($_POST['action']=='save_usr') {
		// PHP check for a unique username
		// secures the Javascript check
		if(isSet($_POST['username'])){
			$value = $_POST['username'];
			$sql_check = querySQL('check_username');
		}
		if(mysql_num_rows($sql_check) < 1 || $_POST['userID'] != ''){
			$resultQuery = writeForm('plc_users');
		}
	}
}
// CSRF - Secure forms with token
$token = md5(uniqid(rand(), true)); 
$_SESSION['token'] = $token;

// id of outlet
if (!$_SESSION['outletID']) {
	$_SESSION['outletID'] = ($_GET['outletID']) ? (int)$_GET['outletID'] : querySQL('standard_outlet');
}else if ($_GET['outletID']) {
	$_SESSION['outletID'] = (int)$_GET['outletID'];
}
if ($_POST['reservation_outlet_id']) {
	$_SESSION['outletID'] = $_POST['reservation_outlet_id'];
}

// id of event
if ($_GET['eventID']) {
	$_SESSION['eventID'] = ($_GET['eventID']) ? (int)$_GET['eventID'] : 0;
}else if ($_POST['eventID']) {
	$_SESSION['eventID'] = ($_POST['eventID']) ? (int)$_POST['eventID'] : 0;
}

// id of property
if ($_GET['propertyID']) {
	$_SESSION['propertyID'] = ($_GET['propertyID']) ? (int)$_GET['propertyID'] : 1;
}else if ($_POST['propertyID']) {
	$_SESSION['propertyID'] = ($_POST['propertyID']) ? (int)$_POST['propertyID'] : 1;
}else if(!$_SESSION['propertyID']){
	$_SESSION['propertyID'] = 1;
}

// id of user
if ($_GET['userID']) {
	$_SESSION['userID'] = ($_GET['userID']) ? (int)$_GET['userID'] : 0;
}else if ($_POST['userID']) {
	$_SESSION['userID'] = ($_POST['userID']) ? (int)$_POST['userID'] : 0;
}

// id of reservation
if ($_GET['resID']) {
	$_SESSION['resID'] = ($_GET['resID']) ? (int)$_GET['resID'] : 0;
}else if ($_POST['resID']) {
	$_SESSION['resID'] = ($_POST['resID']) ? (int)$_POST['resID'] : 0;
}

// id of country
if ($_GET['countryID']) {
	$_SESSION['countryID'] = $_GET['countryID'];
}else if ($_POST['countryID']) {
	$_SESSION['countryID'] = $_POST['countryID'];
}else if($this_page != "detail"){
	$_SESSION['countryID'] = '%';
}

// id of city
if ($_GET['city']) {
	$_SESSION['city'] = $_GET['city'];
}else if ($_POST['city']) {
	$_SESSION['city'] = $_POST['city'];
}else if($this_page != "detail"){
	$_SESSION['city'] = '%';
}

//prevent division by zero
$_SESSION['selOutlet']['outlet_max_capacity'] = ($_SESSION['selOutlet']['outlet_max_capacity']) ? $_SESSION['selOutlet']['outlet_max_capacity'] : 1;

// selected date
if (!$_SESSION['selectedDate']) {
	$_SESSION['selectedDate'] = ($_GET['selectedDate']) ? $_GET['selectedDate'] : buildDate($settings['dbdate']);
}else if ($_GET['selectedDate']) {
	$_SESSION['selectedDate'] = $_GET['selectedDate'];
}

list($sj,$sm,$sd)                = explode("-",$_SESSION['selectedDate']);
$_SESSION['selectedDate_user']   = buildDate($general['dateformat'],$sd,$sm,$sj);
$_SESSION['selectedDate_saison'] = $sm.$sd;
$_SESSION['selectedDate_year']	 = $sj;

// Check if selected date is within open times of outlet
if ( !( 
	($_SESSION['selOutlet']['saison_start']<=$_SESSION['selOutlet']['saison_end'] 
	 && $_SESSION['selectedDate_saison']>=$_SESSION['selOutlet']['saison_start'] 
	 && $_SESSION['selectedDate_saison']<=$_SESSION['selOutlet']['saison_end']) 
	 )) {
		// if not, go to standard outlet
		$_SESSION['outletID'] = querySQL('standard_outlet');
	}

// memorize selected outlet details
$rows = querySQL('db_outlet_info');
	if($rows){
	foreach ($rows as $key => $value) {
		$_SESSION['selOutlet'][$key] = $value;
	}
}
$rows = querySQL('maitre_info');
foreach($rows as $row) {
	$maitre['maitre_id'] = $row->maitre_id;
	$maitre['maitre_ip'] = $row->maitre_ip;
	$maitre['maitre_author'] = $row->maitre_author;
	$maitre['maitre_timestamp'] = $row->maitre_timestamp;
	$maitre['maitre_comment_day'] = $row->maitre_comment_day;
	$maitre['outlet_child_tables'] = ($row->outlet_child_tables) ? $row->outlet_child_tables : 0;
	$maitre['outlet_child_capacity'] = ($row->outlet_child_capacity) ? $row->outlet_child_capacity : 0;
	$maitre['passerby_max_pax'] = ($row->outlet_child_passer_max_pax) ? $row->outlet_child_passer_max_pax : 0;
}


// selected tabs
if ($_GET['p']) {
	$_SESSION['page'] = (int)$_GET['p'];
}else if ( !$_SESSION['page'] ){
	$_SESSION['page'] = 2;
}

//selected subtabs
$q = ($_GET['q']) ? (int)$_GET['q'] : 1;

// selected reservations/storno
// 0 = confirmed
// 1 = canceled
$_SESSION['storno'] = ($_GET['s']) ? (int)$_GET['s'] : 0;

// selected waitlist
// 0 = reservation
// 1 = waitlist
// 2 = secondseating
$_SESSION['wait'] = ($_GET['w']) ? (int)$_GET['w'] : 0;

// selected button
if ($_GET['btn']) {
	$_SESSION['button'] = (int)$_GET['btn'];
}else if (!$_SESSION['button']){
	$_SESSION['button'] = 1;
}

// searchquery
$searchquery = '';
if($_POST['searchquery']){
	$searchquery = $_POST['searchquery']."%";
	$q = 4;
}

?>