<?
		$pdate = date($general['dateformat'],strtotime($_SESSION['selectedDate']));
		$sdate = "";
	if ( $_POST['recurring_dbdate']!="" && $_POST['recurring_dbdate']!=$_SESSION['selectedDate'] ) {
		$sdate = date($general['dateformat'],strtotime($_POST['recurring_dbdate']));
	}
	
	
	// To send HTML mail, the Content-type header must be set
	// charset=charset=iso-8859-1
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	// Additional headers
	$headers .= 'From: '.$_SESSION['selOutlet']['outlet_name'].' <'.$_SESSION['selOutlet']['confirmation_email'].'>' . "\r\n";
	$headers .= 'Bcc: '.$_SESSION['selOutlet']['confirmation_email']. "\r\n";
	
	// Subject of email
	$subject = _email_subject." ".$_SESSION['selOutlet']['outlet_name'];
	
	//Salutation
	switch ($_POST['reservation_title']) {
		case 'M':
			$salut = _M_;
			break;
		case 'W':
			$salut = _W_;
			break;	
		case 'F':
			$salut = _F_;
			break;
		case 'C':
			$salut = _C_;
			break;	
	}
	
	//Text
	$text = _email_confirmation_1;
	$body = sprintf( $text , $salut, $_POST['reservation_guest_name'], $_SESSION['selOutlet']['outlet_name'], $_POST['reservation_pax'], $pdate );
	if ($sdate!='' && $pdate!=$sdate) {
		$body .= " "._till." ".$sdate;
	}
	
	$text = " "._email_confirmation_2;
	$body .= sprintf( $text, formatTime($_POST['reservation_time'],$general['timeformat']), $_SESSION['booking_number'], $_POST['reservation_author'] );


	//***
	//SEND OUT MAIL
		mail( $_POST['reservation_guest_email'], $subject, $body, $headers); 
	//***
?>