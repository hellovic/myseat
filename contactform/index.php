<?php
session_start();

$_SESSION['role'] = 6;
$_SESSION['language'] = 'en_EN';
$_SESSION['property'] = '1';
$_SESSION['propertyID'] = '1';

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
//stadard outlet for contact form
if (!$_SESSION['outletID']) {
	$_SESSION['outletID'] = ($_GET['outletID']) ? (int)$_GET['outletID'] : querySQL('web_standard_outlet');
}
// ** get superglobal variables
	include('../web/includes/get_variables.inc.php');
// CSRF - Secure forms with token
	$barrier = md5(uniqid(rand(), true)); 
	$_SESSION['barrier'] = $barrier;


// Get POST data	
   // outlet id
    // property id
    if ($_GET['prp']) {
        $_SESSION['property'] = (int)$_GET['prp'];
    }elseif ($_POST['prp']) {
        $_SESSION['property'] = (int)$_POST['prp'];
    }
    // selected date
    if ($_GET['selectedDate']) {
        $_SESSION['selectedDate'] = $_GET['selectedDate'];
    }else if ($_POST['selectedDate']) {
        $_SESSION['selectedDate'] = $_POST['selectedDate'];
    }else if (!$_SESSION['selectedDate']){
        //$_SESSION['selectedDate'] = date('Y-m-d');
    }

  //prepare selected Date
    list($sy,$sm,$sd) = explode("-",$_SESSION['selectedDate']);
  
	// get outlet maximum capacity
	$maxC = maxCapacity(); 
	 
	// get Pax by timeslot
    $resbyTime = reservationsByTime('pax');
    $tblbyTime = reservationsByTime('tbl');

    // get availability by timeslot
    $availability = getAvailability($resbyTime,$general['timeintervall']);
    $tbl_availability = getAvailability($tblbyTime,$general['timeintervall']);

  // some constants
    $outlet_name = querySQL('db_outlet');
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
    <meta charset="utf-8"/>

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css" media="screen"/>
    <link rel="stylesheet" href="css/datepicker.css" media="screen"/>

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
			<h1><?php lang("title"); ?></h1>
		</div>
		
		<div id="main">
			

			<?php lang("contact_form_intro"); ?>
			<br/>
			<h3><?= $outlet_name." - ".buildDate($general['dateformat'],$sd,$sm,$sy); ?></h3>
			
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
			<?php
			$num_outlets = querySQL('num_outlets');
				if ($num_outlets>1) {
					echo"<label>RESTAURANT</label><br/>";
					outletList($_SESSION['outletID'],'enabled','reservation_outlet_id');
				} else{
					echo "<input type='hidden' name='reservation_outlet_id' value='".$_SESSION['outletID']."'>";
				}
			//Day off error message
			$day_off = getDayoff();
            if ($day_off > 0) {
				echo "<div class='alert_error'><p><img src='../web/images/icon_error.png' alt='error' class='middle'/>&nbsp;&nbsp;";
				echo lang('error_dayoff')."<br>";
				echo "</p></div>";
			}
			?>
			<br/><br/>
		    </div>
		    <div>
			<label><?php lang("contact_form_time"); ?></label><br/>
			<?php
			    timeList($general['timeformat'], $general['timeintervall'],'reservation_time','',$_SESSION['selOutlet']['outlet_open_time'],$_SESSION['selOutlet']['outlet_close_time'],0);
			?>
		    </div>
		    <br/>
		    <div>
			<label><?php lang("contact_form_title"); ?></label><br/>
			<?php
			    titleList();
			?>
		    </div>
		    <br/>
		    <div>
			<label><?php lang("contact_form_name"); ?></label><br/>
                        <input type="text" name="reservation_guest_name" class="form required" id="reservation_guest_name" value="" />
                    </div>
		    <br/>
		    <div>
			<label><?php lang("contact_form_pax"); ?></label><br/>
                        <?php
							//personsList(max pax before menu , standard selected pax);
						    personsList($general['max_menu'],2);
						?>
                    </div>
		    <br/>
                    <div>
			<label><?php lang("contact_form_email"); ?></label><br/>
                        <input type="text" name="reservation_guest_email" class="form required email" id="reservation_guest_email" value="" />
                    </div>
		    <br/>
		    <div>
			<label><?php lang("contact_form_phone"); ?></label><br/>
                        <input type="text" name="reservation_guest_phone" class="form required" id="reservation_guest_phone" value="" />
                    </div>
		    <br/>
                    <div>
			<label><?php lang("contact_form_notes"); ?></label><br/>
                	<textarea cols="50" rows="10" name="reservation_notes" class="form" id="reservation_notes" ></textarea>
                    </div>
		    <br/>
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
				<input type="hidden" name="barrier" value="<?php echo $barrier; ?>" />
				<input type="hidden" name="reservation_hotelguest_yn" id="reservation_hotelguest_yn" value="PASS"/>
				<input type="hidden" name="reservation_booker_name" id="reservation_booker_name" value="Contact Form"/>
				<input type="hidden" name="reservation_author" id="reservation_author" value="mySeat Team"/>
				<input type="hidden" name="email_type" id="email_type" value="en"/>
                <?php
				$day_off = getDayoff();
                if ($day_off == 0) {
                	echo"<input class='button' type='submit' value='".$lang['contact_form_send']."' />";
                }
                ?>	
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
      // month is 0 based, hence for Feb. we use 1
      $("#bookingpicker").datepicker('setDate', new Date(<?= $sy.", ".($sm-1).", ".$sd; ?>));
      $("#ui-datepicker-div").hide();
      $("#reservation_outlet_id").change(function(){
	    window.location.href='?outletID=' + this.value;
	  });
    });
</script>

</body>
</html>