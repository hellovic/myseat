<?
// get outlet maximum capacity
$maxC = maxCapacity();
// get Pax by timeslot
$passbyTime = reservationsByTime('pass');

// Maitre day comment
if (trim($maitre['maitre_comment_day']) != "" && $_SESSION['page'] == 2 ) {
	echo "<div class='alert_warning'>
	<p><img src='images/icon_info.png' alt='error' class='middle'/>";
		// maitre comment
		echo $maitre['maitre_comment_day']."<br>";
	echo "</p></div>";
	$maitre['maitre_comment_day'] = '';	
}

// Max passerby warning
if (isset($passbyTime)) {
	$i=1;
	foreach ($passbyTime as $key => $value) {
		if ( $_SESSION['passerby_max_pax']-$value <= 0 && $_SESSION['page'] == 2 ) {
			if($i<=1){echo "<div class='alert_warning'><p>";}
			echo "<img src='images/icon_warning.png' alt='error' class='middle'/>".formatTime($key,$general['timeformat']).": "._sentence_16."<br>";
			if($i==count($passbyTime)){echo "</p></div>";}
			$i++;
		}
	}
}

// Messages
if (count($_SESSION['messages']) > 0) {
	echo "<div class='alert_error'>
	<p><img src='images/icon_warning.png' alt='error' class='middle'/>";
	foreach ($_SESSION['messages'] as $key => $value) {
		echo $value."<br/>";
	}
	echo "</p></div>";
	//Clear messages after printing
	$_SESSION['messages'] = array();
}

// Error & success messages
if ( !empty($_SESSION['errors']) ) {
	echo "<div id='messageBox' style='cursor:pointer;'>";
	echo "<div class='alert_error'>
	<p><img src='images/icon_error.png' alt='error' class='middle' />";
	foreach ($_SESSION['errors'] as $key => $value) {
		echo $value."<br/>";
	}
	echo "</p></div></div>";
	//Clear errors after printing
	$_SESSION['errors'] = array();
}else if ( $_SESSION['result'] ) {
	echo "<div id='messageBox'>";
	echo "<div class='alert_success'><p><img src='images/icons/icon_accept.png' alt='success' class='middle'/>". _new_entry ."</p></div></div>";
	$_SESSION['result'] = '';
}

// Special event advertise
$events_advertise = querySQL('event_advertise');
if ($events_advertise && ($_SESSION['page'] == 2 || $_SESSION['page'] == 1) ) {
	echo "<div class='alert_ads'>
	<div class='ads'>"._ads."</div>";
		// special events
		foreach($events_advertise as $row) {
			echo "
			<img src='images/icon_cutlery.png' alt='special' class='middle'/>
			<span class='bold'>
			<a href='".$_SERVER['SCRIPT_NAME']."?outletID=".$row->outlet_id."&selectedDate=".$row->event_date."'>".
			_sp_events.": ".$row->subject."</a> | ".$row->outlet_name."</span>
			<p>".$row->description."<br/><cite><span class='bold'>
			".date($general['dateformat'],strtotime($row->event_date)).
			"</span> ".formatTime($row->start_time,$general['timeformat']).
			" - ".formatTime($row->end_time,$general['timeformat'])." | ".
			_ticket_price.": ".number_format($row->price,2).
			"</cite></p>";
			if( key($row) != count($events_advertise)-1 ) {
				echo"<br/>";
			} 
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
			<span class='bold'>"._today.": ".$row->subject.
			"</strong><br/><div style='margin-left:36px; font-size:0.8em; line-height:1.2em;'>".
			date($general['dateformat'],strtotime($row->event_date)) 
			." ".formatTime($row->start_time,$general['timeformat']).
			" - ".formatTime($row->end_time,$general['timeformat'])."<br/>".
			$row->outlet_name."<br/>".
			_ticket_price.": ".number_format($row->price,2).
			"<br/><br/></div><div style='margin-top:13px; margin-left:36px; font-size:0.9em; line-height:1.2em; width:80%'>".
			$row->description."<br/></div><br/></p>";
		}
	echo "</div>";
}

?>