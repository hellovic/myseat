<?php
session_start();

 // Error reporting
 //error_reporting(E_ALL & ~E_NOTICE);
 //ini_set("display_errors", 1);
 
// ** set configuration
include('../../config/config.general.php');
// ** connect to database
include('../classes/connect.db.php');
// ** database functions
include('../classes/database.class.php');
// ** localization functions
include('../classes/local.class.php');
// translate to selected language
translateSite(substr($_SESSION['language'],0,2));
// ** business functions
include('../classes/business.class.php');
// ** all database queries
include('../classes/db_queries.db.php');
// ** set configuration
include('../../config/config.inc.php');

// prevent dangerous input
secureSuperGlobals();

// set sql table
$table = 'reservations';

// CSRF - Secure forms with token
if ($_SESSION['token'] == $_POST['token']) {
	// submitted forms storage
		$reservation_date = $_SESSION['selectedDate'];
		$recurring_date = $_SESSION['selectedDate'];
		$_SESSION['errors'] = array();
	// prepare POST data for storage in database:
	// $keys
	// $values 
		$keys = array();
		$values = array();
		$i=1;
		
		// prepare arrays for database query
		foreach($_POST as $key => $value) {
			if ($key == 'saison_start_month' || $key == 'saison_start_day' || $key == 'saison_end_month' || $key == 'saison_end_day') {
				$saison_start = $_POST['saison_start_month'].$_POST['saison_start_day'];
				$saison_end = $_POST['saison_end_month'].$_POST['saison_end_day'];
			}else if($key == 'outlet_closeday'){
				$keys[$i] = $key;
				$values[$i] = "'".implode(',',$value)."'";
			}else if($key == 'password'){
				if($value != "EdituseR"){
					$keys[$i] = $key;
					$insert = new flexibleAccess();
					$password = $insert->hash_password($value);
					$values[$i] = "'".$password."'";
				}
			}else if( $key != "action"
				 && $key != "email_type"
				 && $key != "recurring_date"
				 && $key != "recurring_dbdate"
				 && $key != "password2"
				 && $key != "eventID"
				 && $key != "s_datepicker"
				 && $key != "MAX_FILE_SIZE"
				 && $key != "propertyID"
				 && $key != "token"
				 && $key != "verify"){
					$keys[$i] = $key;
					$values[$i] = "'".$value."'";
			}
			
			// remember some values
			if( $key == "reservation_date" ){
		    	$reservation_date = strtotime($value);
				$recurring_date = $reservation_date;
			}else if( $key == "recurring_dbdate" && $value !=''){
		    	$recurring_date = strtotime($value);
			}else if($key == 'repeat_id'){	
				$repeatid = "'".$value."'";
			}else if($key == 'reservation_booker_name'){	
				$_SESSION['author'] = $value;
			}else if($key == 'reservation_time'){	
				$_SESSION['reservation_time'] = "'".$value."'";
			}else if($key == 'reservation_pax'){	
					$_SESSION['reservation_pax'] = "'".$value."'";
			}
			$i++;
		} // END foreach $_POST
		
			$_SESSION['reservation_date'] = date('Y-m-d',$reservation_date);
			$_SESSION['recurring_date'] = date('Y-m-d',$recurring_date);
		
		// outlets build start and enddate
		if($saison_start!='' && $saison_end!=''){
			$keys[] = 'saison_start';
	    	$values[] = "'".$saison_start."'";
			$keys[] = 'saison_end';
	    	$values[] = "'".$saison_end."'";
		}

		// =-=-=-=Store in database =-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		
			// clear old booking number
			$_SESSION['booking_number'] = '';
			// variables
			$res_pax = ($_POST['reservation_pax']) ? (int)$_POST['reservation_pax'] : 0;
			// memorize selected date
			$selectedDate = $_SESSION['selectedDate'];
			// res_dat is the beginning of circling through recurring dates 
			$res_dat = $reservation_date;
			
			// sanitize old booking numbers
			$clr = querySQL('sanitize_unique_id');
			
			// create and store booking number
			if ( !$_POST['reservation_id'] ) {
			    $_SESSION['booking_number'] = uniqueBookingnumber();
			    //$_SESSION['booking_number'] = '123';
			    $keys[] = 'reservation_bookingnumber';
			    $values[] = "'".$_SESSION['booking_number']."'";
			}
		    
			//store recurring reservation
			if ($recurring_date != $reservation_date){
				$repeatid = querySQL('res_repeat');
			 	$keys[] = 'repeat_id';
	    	 	$values[] = "'".$repeatid."'";
			}
			
		 while ( $res_dat <= $recurring_date) {
			
			// build new reservation date
			$index = array_search('reservation_date',$keys);
			// build for availability calculation
			$_SESSION['selectedDate'] = date('Y-m-d',$res_dat);
			if($index){
				$values[$index] = "'".$_SESSION['selectedDate']."'";
			}
			$index = array_search('reservation_wait',$keys);
			if($index){
				$values[$index] = '1';
			}
			
			
			//Check Availability
			// =-=-=-=-=-=-=-=-=
			
			// get Pax by timeslot
			$resbyTime = reservationsByTime('pax');
			$tblbyTime = reservationsByTime('tbl');
			// get availability by timeslot
			$occupancy = getAvailability($resbyTime,$general['timeintervall']);
			$tbl_occupancy = getAvailability($tblbyTime,$general['timeintervall']);
			
			//cut both " ' " from reservation_pax
			$res_pax = substr($_SESSION['reservation_pax'], 0, -1);
			$res_pax = substr($_SESSION['reservation_pax'], 1);
			
			$startvalue = $_SESSION['reservation_time'];
			//cut both " ' " from reservation_time
			$startvalue = substr($startvalue, 0, -1);
			$startvalue = substr($startvalue, 1);
			
			  $val_capacity = $_SESSION['outlet_max_capacity']-$occupancy[$startvalue];
			  $tbl_capacity = $_SESSION['outlet_max_tables']-$tbl_occupancy[$startvalue]; 

			if( (int)$res_pax > $val_capacity || $tbl_capacity < 1 ){
				//prevent double entry 	
				$index = array_search('reservation_wait',$keys);
				if($index>0){
					if ($values[$index] == '0') {
					  // error on edit entry
					  $_SESSION['errors'][] = date($general['dateformat'],strtotime($_SESSION['selectedDate']))." "._wait_list;
					}				
					  $values[$index] = '1'; // = waitlist
				}else{
					  // error on new entry
					  $keys[] = 'reservation_wait';
					  $values[] = '1'; // = waitlist
					  $_SESSION['errors'][] = date($general['dateformat'],strtotime($_SESSION['selectedDate']))." "._wait_list;	
				}
			}
			// END Availability

			// number of database fields
			$max_keys = count($keys);
			// enter into database
			// -----
			$query = "INSERT INTO `$table` (".implode(',', $keys).") VALUES (".implode(',', $values).") ON DUPLICATE KEY UPDATE ";
			// Build 'on duplicate' query
			for ($i=1; $i <= $max_keys; $i++) {
				if($keys[$i]!=''){
			 		$query .= $keys[$i]."=".$values[$i].",";
				}else{
					$max_keys++;
				}
			}
			// run sql query 				
			$query = substr($query,0,-1);				   
			$result = query($query);
			$_SESSION['result'] = $result;

			// -----
			// increase reservation date
			$res_dat += (60*60*24);
		 } // end while: reservation to store
		
			// *** send confirmation email
			if ( $_POST['email_type'] != 'no' ) {
				include('../classes/email.class.php');
			}
			
			// store changes in history
			$result = query("INSERT INTO `res_history` (reservation_id,author) VALUES ('%d','%s')",$_POST['reservation_id'],$_POST['reservation_booker_name']);
			
			// set back selected date
			$_SESSION['selectedDate'] = $selectedDate;
}
// CSRF - Secure forms with token
$token = md5(uniqid(rand(), true)); 
$_SESSION['token'] = $token;

// after processing reservation, redirect to main page
header("Location: ../main_page.php?q=1");

exit;

?>