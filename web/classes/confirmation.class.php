<?	

	// To send HTML mail, the Content-type header must be set
	// charset=charset=iso-8859-1
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	// Additional headers
	$headers .= 'From: mySeat Team <info@openmyseat.com>' . "\r\n";
	//$headers .= 'Bcc: support@myseat.us \r\n';


	//get a random 8 character string
    $_SESSION['confHash'] = randomString();

    //add confirmation hash to the database
    $rows = querySQL('user_confirm_code');


	// Subject of email
	$subject = "Welcome to mySeat";
		
	// prepate welcome text of email
	//$text = _user_email_confirmation;
	
	// prepate confirmation text of email
	$text = _user_activation_email;
	
	
	$body = sprintf( $text , $_POST['username'], $_SERVER['HTTP_HOST'], $_SESSION['confHash'], $_SERVER['HTTP_HOST'], $_SESSION['confHash']);


	//***
	//SEND OUT MAIL
		mail( $_POST['email'], $subject, nl2br($body), $headers); 
	//***
?>