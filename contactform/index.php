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
    $outlet_name = querySQL('db_outlet');
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
				
				<a href="index.php" class="logo"><img src="img/logo.png" alt="hanbai logo" /></a>  
				
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
			<h1><?php lang("title"); ?></h1>
		</div>
		
		<div id="main">
			

			<?php lang("contact_form_intro"); ?>
			<div style='font-size:1.3em; font-weight:bold;'><?= $outlet_name." - ".buildDate($general['dateformat'],$sd,$sm,$sy); ?><br/></div>
			<br/>
			
			<?php
				// Generate captcha fields
				$captchaField1 = rand(1, 10);
				$captchaField2 = rand(1, 20);
				$captchaField3 = rand(1, 10);
				$captchaField2 = ($captchaField2%2) ? "+" : "-";
			?>

                
		<form action="process_booking.php" method="post" id="contactForm">
		    
		    <!-- Datepicker -->
		    <label> </label><div id="bookingpicker"></div>
		    <input type="hidden" name="dbdate" id="dbdate" value="<?= $_SESSION['selectedDate']; ?>"/>
      
		    <input type="hidden" name="reservation_date" value="<?= $_SESSION['selectedDate'];?>">
		    <input type="hidden" name="recurring_dbdate" value="<?= $_SESSION['selectedDate']; ?>"/>
                    <br/><br/>
		    <!-- END datepicker -->
		    <div>
			<label><?php lang("contact_form_restaurant"); ?></label><br/>
			<?php
			  outletList($_SESSION['outletID'],'enabled','reservation_outlet_id');
			?>
		    <br/><br/>
		    </div>
		    <div>
			<label><?php lang("contact_form_time"); ?></label><br/>
			<?php
			    timeList($general['timeformat'], $general['timeintervall'],'reservation_time','',$_SESSION['selOutlet']['outlet_open_time'],$_SESSION['selOutlet']['outlet_close_time'],1);
			?>
		    </div>
		    <br/>
		    <div>
			<?php
			    titleList();
			?>
		    </div>
		    <br/>
		    <div>
                        <input type="text" name="reservation_guest_name" class="form required" id="reservation_guest_name" placeholder="<?php lang("contact_form_name"); ?>" value="" />
                    </div>
		    <div>
                        <input type="text" name="reservation_pax" class="form required digits" id="reservation_pax" placeholder="<?php lang("contact_form_pax"); ?>" value="" style="width:130px;"/>
                    </div>
                    <div>
                        <input type="text" name="reservation_guest_email" class="form required email" id="reservation_guest_email" placeholder="<?php lang("contact_form_email"); ?>" value="" />
                    </div>
		    <div>
                        <input type="text" name="reservation_guest_phone" class="form required" id="reservation_guest_phone" placeholder="<?php lang("contact_form_pax"); ?>" value="" />
                    </div>
                    <div>
                	<textarea cols="50" rows="10" name="reservation_notes" class="form required" id="reservation_notes" placeholder="<?php lang("contact_form_notes"); ?>"></textarea>
                    </div>
		    
		    <div class="side">
                	<div class="captchaContainer">
                		<label for="captcha"><?php lang("contact_form_captcha"); ?></label>
                		<input type="text" name="captcha" class="form required captcha" id="captcha" value="" />
                		
                		<span class="captchaField">=</span>                    		

	            		
                		<span id="captchaField3" class="captchaField"><?php echo $captchaField3; ?></span>
        				<input type="hidden" name="captchaField3" value="<?php echo $captchaField3; ?>"/>
        				
	            		<span id="captchaField2" class="captchaField"><?php echo $captchaField2; ?></span>
	            		<input type="hidden" name="captchaField2" value="<?php echo $captchaField2; ?>"/>
	            		
	            		<span id="captchaField1" class="captchaField"><?php echo $captchaField1; ?></span>
	            		<input type="hidden" name="captchaField1" value="<?php echo $captchaField1; ?>"/>
	            		
                		<div class="clear"></div>
                	</div>
		    </div> 
                	<div class="oh">
				<input type="hidden" name="action" id="action" value="submit"/>
				<input type="hidden" name="reservation_booker_name" id="reservation_booker_name" value="Contact Form"/>
				<input type="hidden" name="email_type" id="email_type" value="en"/>
                		
				<input class="button" type="submit" value="<?php lang("contact_form_send"); ?>" />
                	</div>
		</form>
				
			<!-- side close -->
			
			<div class="clear"></div>
			
		</div><!-- main close -->
		<div id="mainBottom"></div>
	
	</div><!-- wrap close -->
			
	<div id="footer">
		<div class="wrap">
			
			<div class="oneOfThree">
				
				<?php lang("footer_one"); ?>
				
			</div>
			<div class="oneOfThree">
				
				<?php lang("footer_two"); ?>
				
			</div>
			<div class="oneOfThree last">
				
				<?php lang("footer_three"); ?>
			
			</div>
			<div class="clear"></div>
			
		</div>
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

  <!-- Javascript at the bottom for fast page loading --> 
<script>
    jQuery(document).ready(function($) {
      // Setup datepicker input at customer reservation form
      $("#bookingpicker").datepicker({
	      nextText: '&raquo;',
	      prevText: '&laquo;',
	      firstDay: 1,
	      numberOfMonths: 2,
	      gotoCurrent: true,
	      altField: '#dbdate',
	      altFormat: 'yy-mm-dd',
	      defaultDate: 0,
	      dateFormat: '<?= $general['datepickerformat'];?>',
	      regional: '<?= substr($_SESSION['language'],0,2);?>',
	      onSelect: function(dateText, inst) { window.location.href="?selectedDate="+$("#dbdate").val(); }
      });
      $("#bookingpicker").datepicker('setDate', new Date ( "<?= $_SESSION['selectedDate']; ?>" ));
      $("#ui-datepicker-div").hide();
      $("#reservation_outlet_id").change(function(){
	    window.location.href='?outletID=' + this.value;
	  });
    });
</script>

</body>
</html>