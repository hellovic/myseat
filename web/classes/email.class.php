<?
		// Initiate dates
		$pdate = date($general['dateformat'],strtotime($_SESSION['selectedDate']));
		$sdate = "";
		
		// Get property name
		$prop_name = querySQL('db_property');
		
	if ( $_POST['recurring_dbdate']!="" && $_POST['recurring_dbdate']>$_SESSION['selectedDate'] ) {
		$sdate = date($general['dateformat'],strtotime($_POST['recurring_dbdate']));
	}
	
	
	// To send HTML mail, the Content-type header must be set
	// charset=charset=iso-8859-1
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	// Additional headers
	$headers .= 'From: '.$prop_name.' <'.$_SESSION['selOutlet']['confirmation_email'].'>' . "\r\n";
	$headers .= 'Bcc: '.$_SESSION['selOutlet']['confirmation_email']. "\r\n";

	// Subject of email
        if ( $_POST['email_type'] == 'en' ) {
		$subject = _email_subject_en." ".$prop_name;
	}else{
		$subject = _email_subject." ".$prop_name;
	}
	
	//Salutation
	if ( $_POST['email_type'] == 'en' ) {
		switch ($_POST['reservation_title']) {
			case 'M':
				$salut = _dear_mr_en." ".$_POST['reservation_guest_name'];
				break;
			case 'W':
				$salut = _dear_mrs_en." ".$_POST['reservation_guest_name'];
				break;	
			case 'F':
				$salut = _dear_family_en." ".$_POST['reservation_guest_name'];
				break;
			case 'C':
				$salut = _dear_sirs_and_madams_en." ".$_POST['reservation_guest_name'];
				break;	
		}
	}else{
		switch ($_POST['reservation_title']) {
			case 'M':
				$salut = _dear_mr." ".$_POST['reservation_guest_name'];
				break;
			case 'W':
				$salut = _dear_mrs." ".$_POST['reservation_guest_name'];
				break;	
			case 'F':
				$salut = _dear_family." ".$_POST['reservation_guest_name'];
				break;
			case 'C':
				$salut = _dear_sirs_and_madams." ".$_POST['reservation_guest_name'];
				break;	
		}
	}
	
	// prepare date/datespan
		$txt_date = $pdate;
	if ($sdate!='' && $pdate!=$sdate) {
		$txt_date = $pdate." - ".$sdate;
	}

	// prepate subject of email
        if ( $_POST['email_type'] == 'en' ) {
		$subject = _email_subject_en." ".$_SESSION['selOutlet']['outlet_name'];
	}else{
		$subject = _email_subject." ".$_SESSION['selOutlet']['outlet_name'];
	}
	
	// prepare text
	if ( $_POST['email_type'] == 'en' ) {
		$text = _email_confirmation_en;
	}else{
		$text = _email_confirmation;
	}
	
	$body  = $salut.",\r\n\r\n";
	$body .= sprintf( $text , $_SESSION['selOutlet']['outlet_name'], $_POST['reservation_pax'], $txt_date, formatTime($_POST['reservation_time'],$general['timeformat']), $_SESSION['booking_number'], $prop_name." Team"  );


	//***
	//SEND OUT MAIL
		mail( $_POST['reservation_guest_email'], $subject, nl2br($body), $headers); 
	//***
?>