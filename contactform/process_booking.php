<?php

// PHP part of page / business logic
// ** set configuration
	require("config.php");
	include('../config/config.general.php');
// ** business functions
	require('includes/business.class.php');
// ** database functions
	include('../web/classes/database.class.php');
// ** localization functions
	include('../web/classes/local.class.php');
// ** business functions
	include('../web/classes/business.class.php');
// ** connect to database
	include('../web/classes/connect.db.php');
// ** all database queries
	include('../web/classes/db_queries.db.php');
// ** set configuration
	include('../config/config.inc.php');
// translate to selected language
	translateSite(substr($_SESSION['language'],0,2));
// ** get superglobal variables
	include('../web/includes/get_variables.inc.php');

// Get POST data	
   // outlet id
    if (!$_SESSION['outletID']) {
	$_SESSION['outletID'] = ($_GET['outletID']) ? (int)$_GET['outletID'] : querySQL('standard_outlet');
    }elseif ($_GET['id']) {
        $_SESSION['outletID'] = (int)$_GET['id'];
    }elseif ($_POST['id']) {
        $_SESSION['outletID'] = (int)$_POST['id'];
    }
    // property id
    if ($_GET['prp']) {
        $_SESSION['property'] = (int)$_GET['prp'];
    }elseif ($_POST['prp']) {
        $_SESSION['property'] = (int)$_POST['prp'];
    }
    // selected date
    if ($_GET['selectedDate']) {
        $_SESSION['selectedDate'] = $_GET['selectedDate'];
    }elseif ($_POST['selectedDate']) {
        $_SESSION['selectedDate'] = $_POST['selectedDate'];
    }elseif ($_POST['dbdate']) {
        $_SESSION['selectedDate'] = $_POST['dbdate'];
    }elseif (!$_SESSION['selectedDate']){
        //$_SESSION['selectedDate'] = date('Y-m-d');
    }

  //prepare selected Date
    list($sy,$sm,$sd) = explode("-",$_SESSION['selectedDate']);
  
  // get Pax by timeslot
    $resbyTime = reservationsByTime();
  // get availability by timeslot
    $availability = getAvailability($resbyTime,$general['timeintervall']);
  // some constants
    $bookingdate = date($general['dateformat'],strtotime($_POST['dbdate']));
    $bookingtime = formatTime($_POST['reservation_time'],$general['timeformat']);
    $outlet_name = querySQL('db_outlet');
    //$_SESSION['booking_number'] = '';
  
  //The subject of the confirmation email
  $subject = $lang["email_subject"]." ".$outlet_name;
  //Email address of the confirmation email
  $mailTo = $_POST['reservation_guest_email'];
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
    <meta charset="utf-8"/>

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css" media="screen"/>
    <link rel="stylesheet" href="css/datepicker.css" media="screen"/>
    <link rel="shortcut icon" href="img/favicon.png"/>

    <!-- jQuery Library-->
    <script src="js/jQuery.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script> 
    <script src="js/functions.js"></script>
    

	<!--[if IE 6]>
		<script src="js/DD_belatedPNG.js"></script>
		<script>
			DD_belatedPNG.fix('#togglePanel, .logo img, #mainBottom, #twitter, ul li, #searchForm, .footerLogo img, .social img');
		</script>
	<![endif]--> 

    <title>Reservation</title>
</head>
<body>
	<div id="headerPanel">
		<div id="header">
			<div class="wrap">
				
				<a href="index.php" class="logo"><img src="img/logo.png" alt="logo" /></a>  
				
				<div class="contactInfo">
					<?php lang("contact_info"); ?>
				</div>
				
				<div class="right">
					<h5><?php lang("change_language"); ?></h5>		
					<ul class="nav">
						<?php language_navigation(); ?>
					</ul>
				</div>
				
				<div class="clear"></div>
				
			</div>
		</div><!-- header close -->
		<div id="togglePanel"></div>
	</div><!-- headerPanel close -->
		
	<div class="wrap">
		
		<div id="title">
			<h1><?php lang("conf_title"); ?></h1>
		</div>
		
		<div id="main">
			

			<h3>
			  <?php
			    lang("conf_intro"); 
			    echo " ".$outlet_name." ".$lang["_at_"]." ".buildDate($general['dateformat'],$sd,$sm,$sy)." ".$bookingtime;
			  ?>
			</h3>
			<br/>
			<span id="result">
			  <?php
			    // =-=-=-=-=-=-=-=-=-=-=
			    //  Process the Booking
			    // =-=-=-=-=-=-=-=-=-=-=
			    
			    // Check the captcha
			    $field1 = intval($_POST['captchaField1']);
			    $operator = $_POST['captchaField2'];
			    $field3 = intval($_POST['captchaField3']);
			    
			    $operator = ($operator == "+") ? true : false;
			    $correct = $operator ? $field1+$field3 : $field1-$field3; 
			    
			    if($_POST['captcha'] == $correct){
			      // CSRF - Secure forms with token
			      if ($_SESSION['barrier'] == $_POST['barrier']) {
				// <Do booking>
				$waitlist = processBooking();
			      }
			      // CSRF - Secure forms with token
			      $barrier = md5(uniqid(rand(), true)); 
			      $_SESSION['barrier'] = $barrier;
			      
			      if($waitlist == 2){
				echo "<span class='success'>".$lang['contact_form_success']." ".$_SESSION['booking_number']."</span>";
			      }else if ($waitlist == 1){
				echo "<span class='fail'>".$lang['contact_form_full']."</span>";
			      }else{
				echo "<span class='fail'>".$lang['contact_form_fail']."</span>";
			      }
			    
			    }
			  
			  ?>
                	</span>
			<br/>
			<a href="index.php"><div class="button" style="line-height:32px;">Back</div></a>
			<br/>
			<div class="clear"></div>
			<br/><br/><br/>
		</div><!-- main close -->
		<div id="mainBottom"></div>
	
	</div><!-- wrap close -->
			
	<div id="footer">

	</div><!-- footer close -->
		
		
	<div id="miniFooter">
		<div class="wrap">
			
			<div class="left">
				<a href="#" class="footerLogo"><img src="img/footer-logo.png" alt="Footer Logo" /></a>
				<?php lang("minifooter_copyright"); ?>
			</div>
			
			<div class="clear"></div>
		</div>
	</div><!-- minifooter close -->

</body>
</html>