<?
// Maitre day comment
if (trim($maitre['maitre_comment_day']) != "" && $_SESSION['page'] == 2 ) {
	echo "<div class='alert_warning'>
	<p><img src='images/icon_info.png' alt='error' class='middle'/>";
		// maitre comment
		echo $maitre['maitre_comment_day']."<br>";
	echo "</p></div>";
	$maitre['maitre_comment_day'] = '';	
}

// Special event advertise
$events_advertise = querySQL('event_advertise');
if ($events_advertise && $_SESSION['page'] == 2 ) {
	echo "<div class='alert_tip' style='cursor:pointer;'>
	";
		// special events
		foreach($events_advertise as $row) {
			echo "<p style='margin-bottom:6px;'>
			<img src='images/icon_cutlery.png' alt='special' class='middle'/>
			<strong>"._sp_events.": ".$row->subject.
			"</strong><br/><div style='margin-left:36px; font-size:0.8em; line-height:1.2em;'>".
			date($general['dateformat'],strtotime($row->event_date)) 
			." ".formatTime($row->start_time,$general['timeformat']).
			" - ".formatTime($row->end_time,$general['timeformat'])."<br/>".
			$row->outlet_name."<br/>".
			_open_to." ".$row->open_to."<br/>".
			_ticket_price.": ".number_format($row->price,2).
			"<br/><br/></div><div style='margin-left:36px; font-size:0.9em; line-height:1.2em; width:80%'>".
			$row->description."<br/></div><br/></p>";
		}
	echo "</div>";
}

// Special event of the day and outlet
$special_events = querySQL('event_data_day');
if ($special_events && $_SESSION['page'] == 2 ) {
	echo "<div class='alert_info'>";
		// special events
		foreach($special_events as $row) {
			echo "<p style='margin-bottom:6px;'>
			<img src='images/icon_cutlery.png' alt='special' class='middle'/>
			<strong>"._today.": ".$row->subject.
			"</strong><br/><div style='margin-left:36px; font-size:0.8em; line-height:1.2em;'>".
			date($general['dateformat'],strtotime($row->event_date)) 
			." ".formatTime($row->start_time,$general['timeformat']).
			" - ".formatTime($row->end_time,$general['timeformat'])."<br/>".
			$row->outlet_name."<br/>".
			_open_to." ".$row->open_to."<br/>".
			_ticket_price.": ".number_format($row->price,2).
			"<br/><br/></div><div style='margin-left:36px; font-size:0.9em; line-height:1.2em; width:80%'>".
			$row->description."<br/></div><br/></p>";
		}
	echo "</div>";
}

// Error & success messages
if ( !empty($_SESSION['errors']) ) {
	echo "<div id='messageBox' style='cursor:pointer;'>";
	echo "<div class='alert_error'>
	<p><img src='images/icon_error.png' alt='error' class='middle' />";
	foreach ($_SESSION['errors'] as $key => $value) {
		echo $value."<br>";
	}
	echo "</p></div></div>";
	//Clear errors after printing
	$_SESSION['errors'] = array();
}else if ( $_SESSION['result'] ) {
	echo "<div id='messageBox'>";
	echo "<div class='alert_success'><p><img src='images/icons/icon_accept.png' alt='success' class='middle'/>". _new_entry ."</p></div></div>";
	$_SESSION['result'] = '';
}

// Messages
if (count($_SESSION['messages']) >= 1) {
	echo "<div class='alert_warning'>
	<p><img src='images/icon_warning.png' alt='error' class='middle'/>";
	foreach ($_SESSION['messages'] as $key => $value) {
		echo $value."<br>";
	}
	echo "</p></div>";
	//Clear messages after printing
	$_SESSION['messages'] = array();
}

?>