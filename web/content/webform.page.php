<?
session_start();

/** Log to property **/
	$_SESSION['property'] 	= (int)$_GET['property'];

// ** set configuration
	include('../config/config.general.php');
// ** database functions
	include('classes/database.class.php');
// ** localization functions
	include('classes/local.class.php');
// ** business functions
	include('classes/business.class.php');
// ** cuisines styles functions
	include('classes/cuisines.class.php');
// ** connect to database
	include('classes/connect.db.php');
// ** all database queries
	include('classes/db_queries.db.php');
// ** set configuration
	include('../config/config.inc.php');
// translate to selected language
	translateSite(substr($_SESSION['language'],0,2),'../');
// ** get superglobal variables
	include('includes/get_variables.inc.php');
// ** check booking
	include('classes/bookingrules.class.php');
// ** html header section
	include('views/header.html.php');

// ** begin page content
echo "<body>
	<!-- Begin control panel wrapper -->
	<div id='wrapper'>";
?>

	<br class="clear"/>

		<!-- Online booking form -->
			<? include('includes/new.inc.php'); ?>	

		<!-- ALERT & MESSAGE boxes goes here -->
			<? 
			if($searchquery == '' && $_SESSION['storno'] == 0){ 
				include('includes/messagebox.inc.php'); 
			} 
			$_SESSION['errors'] = array();
			$_SESSION['messages'] = array();
			?>

		<!-- CAPACITY timeline goes here -->
		<?
		// get Pax by timeslot
		$resbyTime = reservationsByTime();
		// get availability by timeslot
		$occupancy = getAvailability($resbyTime,$general['timeintervall']);

		if(($q=='1' || $q=='2') && $dayoff == 0){
		echo "<div class='timeline-section' id='timeline'>";	
			include('includes/timeline.inc.php');
		echo "</div><br class='clear'/>";	
		}
		?>
		
		<!-- Begin nomargin -->
		<div class="content nomargin">
			
			<?
			// ** content
			switch($q){
				case '1':
				 if($dayoff == 0){	
					// confirmed
					include('includes/reservations_grid.inc.php');
		
					// waitlist
					$_SESSION['wait'] = 1;
					$waitlist =	querySQL('reservations');
					if($waitlist){
						echo "<br/><div class='dategroup_name' ";
						echo" >"._wait_list."</div><br class='clear'>";
						include('includes/reservations_grid.inc.php');
					}
				 }else{
					echo "<h2 style='margin-left:45%;margin-top:50px;'>"._day_off."</h2>";
				 }
				break;
				case '2':
					// new
					include('includes/new.inc.php');
				break;
				case '3':
					// cancelled/storno
					include('includes/reservations_grid.inc.php');
				break;
				case '4':
					// search
					include('includes/search_grid.inc.php');
				break;
			}
			echo"<br/>";
			//most recent reservations
			include('includes/recent.inc.php');
			?>
			<br/>
			<br class="clear"/>
		</div>
		<!-- End nomargin -->
</div>
<br class="clear"/>