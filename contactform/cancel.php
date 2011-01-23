<?php
session_start();

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

  if ($_POST['action']=='cncl_book'){

    // cancel reservation
    $result = query("UPDATE `reservations` SET `reservation_hidden` = '1' WHERE `reservation_hidden` = '0' AND `reservation_bookingnumber` = '%s' AND `reservation_guest_email` = '%s'", $_POST['reservation_bookingnumber'], $_POST['reservation_guest_email']);
    $cancel = $result;

    // get reservation id from booking number
    if($cancel>=1){
      $result = query("SELECT `reservation_id` FROM `reservations` WHERE `reservation_bookingnumber` = '%s' LIMIT 1",$_POST['reservation_booking_number']);
	if ($row = mysql_fetch_row($result)) {
		$reservation_id = $row[0];
	}
      // store changes in history
      $result = query("INSERT INTO `res_history` (reservation_id,author) VALUES ('%d','Online-Cancel')",$reservation_id);
    }
    
  }
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
			<h1><?php lang("cxl_title"); ?></h1>
		</div>
		
		<div id="main">
			

			<h3>
			  <?php
			    lang("cxl_intro"); 
			  ?>
			</h3>
			<br/>
			<span id="result">
			  <?php
                            if($_POST['action'] == 'cncl_book'){
			      if($cancel>=1){
				echo "<span class='success'>".$lang['cxl_form_success']."</span><br/>";
			      }else{
				echo "<span class='fail'>".$lang['contact_form_fail']."</span><br/>";
			      }
                            }
			  ?>
                        
                	</span>
                             <form method="post" action="cancel.php" name="contactForm" id="contactForm"">
                                    <br/>
                                        <div>
                                        <label><?php lang("book_num"); ?></label><br/>
                                                <input type="text" name="reservation_bookingnumber" id="reservation_bookingnumber" class="form required" value=""/>
                                        </div>
                                        <br/>
                                        <div>
                                        <label><?php lang("contact_form_email"); ?></label><br/>
                                                <input type="text" name="reservation_guest_email" class="form required email" id="reservation_guest_email" value="" />
                                        </div>
                                    <br/>
                                <p class="tc">
                                  <input type="hidden" name="reservation_timestamp" value="<?= date('Y-m-d H:i:s');?>">
                                  <input type="hidden" name="reservation_ip" value="<?= $_SERVER['REMOTE_ADDR'];?>">
                                  <input type="hidden" name="action" value="cncl_book">
                                  <button type="submit" class="button" id="submit"><?php lang("contact_form_cxl");?></button>
                                </p>
                                <div class="error"></div>
                              </form>
			<br/><br/><br/><br/><br/>
			<a href="index.php"><div class="button" style="line-height:32px;"><?php lang("contact_form_back");?></div></a>
			<br/>
			<div class="clear"></div>
			<br/><br/><br/>
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

</body>
</html>