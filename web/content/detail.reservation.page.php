<!-- Begin one column box -->
<div class="onecolumn">
	
	<div class="header">
<?
$rows = querySQL('reservation_info');
//print_r($rows);
	// display rows
	foreach($rows as $row) { 
?>	
		<h2><?= _detail;?></h2>
		
		<!-- Begin 2nd level tab -->
		<ul class="second_level_tab">
			<?php if ( $dayoff == 0 && current_user_can( 'Reservation-New' ) ): ?>
			<li>
				<a href="#" id="editToggle" onclick="return false;">
					<?= _edit;?>
				</a>
			</li>
			<?php endif ?>
			<li>
				<a href="?p=2&outletID=<?= $_SESSION['outletID']; ?>" class="button_dark">
					<?= _back;?>
				</a>
			<li/>
		</ul>
		<!-- End 2nd level tab -->	
	</div>
	<div class="content">
	<div id="content_wrapper">
	<br/>
	<!-- Begin detail -->
		<div id="show"
		<?php if ($resedit == 'ON'){
			echo' style="display:none;"';
		}
		?>
		>
					<? include('includes/reservation_detail.inc.php'); ?>
		</div>
		<div id="edit"
		<?php if ($resedit == 'OFF'){
				echo' style="display:none;"';
		}
		?>
		>
					<? include('includes/reservation_form.inc.php'); ?>
		</div>
		<br class="clear">
	</div> <!-- end content wrapper -->
	<!-- End detail -->	
</div>
<div class="onecolumn">
	<div class="header">
		<h3><?= _info;?></h3>
	</div>
  <div id="content_wrapper">
	<div class="content detailbig">
<?
// INFO: guest history
// count total visits
$visits = querySQL('reservation_visits');
// last time guest visits outlet
$visits2 = querySQL('reservation_last_visit');
$lastvisit = ($visits2>0 && $visits2!='1970-01-01') ? date("d.M Y", strtotime($visits2)) : "--";

// collect history infos about guest
$history = 	querySQL('reservation_history');	

echo "<label>"._visits."</label><p>".$visits."</p>";
echo "<label>"._last_visit."</label><p>".$lastvisit."</p>";
echo "<label>"._history."</label><p>";
 
	//echo "Anz:".count($history)."<br/>";
echo "<ul style='margin-left:40px'>";
if(count($history)>0){
	foreach ($history as $row) {
		if (trim($row->reservation_notes)!=''){
			echo "<li>".utf8_encode($row->reservation_notes)."</li>";
		}
	}
}
echo "</ul></p>";

//reservation history
echo "<br/><label>"._changes."</label><p><div class='option_xl'><div class='text'></div>";
$res_history = 	querySQL('res_history');
echo"<select name='history' size='1' >\n";
foreach ($res_history as $row) {
	echo "<option>".$row->author." : ".$row->timestamp."</option>";
}
echo "</select></div></p><br/>";
 
?>
	</div>
  </div>
</div>
<?}?>
<br/>
	<div style='margin-left:85px;float:left;'>
		<a href="?p=2&outletID=<?= $_SESSION['outletID']; ?>" class="button_dark">
			<input type="button" class="button_dark" value="<?= _back;?>"/>
		</a>
	</div>
	<!--
	<div style='margin-right:85px;float:right;'>
		<a href="?p=2&outletID=<?= $_SESSION['outletID']; ?>" class="button_red">
		<input type="button" class="button_red" value="<?= ucfirst(_delete);?>"/>
		</a>
		<a href="?p=2&outletID=<?= $_SESSION['outletID']; ?>" class="button_red">
		<input type="button" class="button_red" value="<?= ucfirst(_delete_all_entries);?>"/>
		</a>
	</div>
	-->
<br style='clear:both;'/>
</div>
<!-- End one column box -->