<style type="text/css" media="screen">
	small             {
	                      font-size: 12px;
	                      float: right;
	                      color: #fff;
	                      font-weight: normal;
						  text-align:right;
	                  }
</style>

<!-- Begin one column box -->
<div class='onecolumn'>
 <div class='header'>
	<a href="?selectedDate=<?= buildDate($settings['dbdate'],$sd,$sm,$sj,-1); ?>" class="navgroup">
		&laquo;
	</a>
	<div class="date dategroup">
		<div class="text" id="datetext"><?= $_SESSION['selectedDate_user']; ?></div>
		<input type="text" id="datepicker"/>
		<input type="hidden" id="dbdate" value="<?= $_SESSION['selectedDate']; ?>"/>
	</div>
	<a href="?selectedDate=<?= buildDate($settings['dbdate'],$sd,$sm,$sj,1); ?>" class="navgroup">
		&raquo;
	</a>
	<!-- Begin 2nd level tab -->
	<ul class='second_level_tab'>
		<li>
			<a href='?p=2' class='button_dark'> <?= _back;?>
			</a>
		<li/>
	</ul>
	<!-- End 2nd level tab -->
 </div>
<div id='content_wrapper'>
		<? 
			// MESSAGE boxes goes here
			include('includes/messagebox.inc.php'); 
		?>
</div>
</div>
<br class='cl' />
			<?
			$j = 1;
			// ** print out the timelines of all outlets **
			// memorize actual selected outlet
			$rem_outlet = $_SESSION['outletID'];
			
			// New column box
			echo"<div class='onecolumn'><div class='header'>\n";
			echo"<div class='dategroup_name'>"._overview."</div>
			</div>\n
			<div id='content_wrapper'>\n";
			// start statistic table	
			echo"<table border='0' cellspacing='5' cellpadding='5' width='100%'>";
			
			$outlets = querySQL('db_outlets');
			foreach($outlets as $row) {
			 if ( ($row->saison_start<=$row->saison_end 
				 && $_SESSION['selectedDate_saison']>=$row->saison_start 
				 && $_SESSION['selectedDate_saison']<=$row->saison_end)
				){
					//calculate statistic
					include('includes/dashboard_stat.inc.php');
					// outlet ID
					$_SESSION['outletID'] = $row->outlet_id;
					// outlet settings
					$rows = querySQL('db_outlet_info');
					if($rows){
						foreach ($rows as $key => $value) {
							$_SESSION['selOutlet'][$key] = $value;
						}
					}

						// next row
						if( $j == 0 ){
							echo "<tr>";
						}

					//make each outlet a timeline
					echo "<td style='text-align:right;'>";
					echo "<h1 style='float:right;'>";
					echo "&nbsp;".$show_occupancy."%";
					echo "</h1>".$val_by_time."/".$count_slots."<br/>";
					echo "<small><strong><a href='main_page.php?p=2&outletID=".$row->outlet_id."'>".$row->outlet_name."</a></strong></small>";
					echo "<br class='cl' /><br/>\n</td>\n";
					
						// next row
						if( $j == 3 ){
							echo "</tr>";
							$j = 0;
						}
					
					$j ++;
				}
			}
			echo"</table>\n</div></div><br/>";
			
			// memorize actual selected outlet
			$_SESSION['outletID'] = $rem_outlet;
			// memorize selected outlet details
			$rows = querySQL('db_outlet_info');
			if($rows){
				foreach ($rows as $key => $value) {
					$_SESSION['selOutlet'][$key] = $value;
				}
			}
			
			// ** print out all reservations **
			echo"<div class='onecolumn'><div class='header'>\n";
			echo"<div class='dategroup_name'>"._confirmed_reservations."</div>
			</div>\n
			<div id='content_wrapper'>\n";
			
			// no waitlist
			$_SESSION['wait'] = 0;
			include('includes/reservations_grid.inc.php');
			
			echo"<br class='cl' /><br/>\n</div></div><br/>";
			
			?>

<br class="clear"/><br/>