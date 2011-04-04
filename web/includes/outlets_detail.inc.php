
<div class="content" style="height:700px;">
	<label><?= _property;?></label>
	<p><strong>	 	 				 
		<?= $row->name;?>
	</strong></p>
	<label><?= _name;?></label>
	<p><strong>
		<?= $row->outlet_name;?>
	</strong></p>
	<label><?= _cuisine_style;?></label>
	<p>
		<?= $cuisines[($row->cuisine_style-1)];?>
	</p>
	<label><?= _description;?></label>
	<p style="max-width:500px;">	 	 	 	 	 	 	 
		<?= trim(utf8_encode($row->outlet_description));?>
	</p>	
	<label><?= _confirmation_email;?></label>
	<p>
		<?= $row->confirmation_email;?>
	</p>
	<label><?= _seats;?></label>
	<p>		 	 	 	 	 	 	
		<?= $row->outlet_max_capacity;?>
	</p>
	<label><?= _tables;?></label>	
	<p>	 	 	 	 	 	 	
		<?= $row->outlet_max_tables;?>
	</p>
	<label>Max. <?= _passerby;?></label>	
	<p>	 	 	 	 	 	 	
		<?= $row->passerby_max_pax;?>
	</p>
	<label><?= _duration;?></label>	
	<p>	 	 	 	 	 	 			
		<?= $row->avg_duration;?> h
	</p>
	<label><?= _webform;?></label>
	<p>		
		<?= printOnOff($row->webform);?>
	</p>
	<br/><br/>
	<label>Booking Link</label>
	<p>		
		<?
		echo "<br/><span class='bold'>".$row->outlet_name." :</span><br/>";
		echo "<code>http://www.openmyseat.com/contactform/index.php?so=ON&prp=".$row->property_id."&outletID=".$row->outlet_id."</code>";
		echo "<br/><span class='bold'>"._property." :</span><br/>";
		echo "<code>http://www.openmyseat.com/contactform/index.php?prp=".$row->property_id."</code>";
		?>
	</p>	 	 	 	 	 	 	
</div></div></div> <!-- end left column -->
<!-- Beginn right column -->	
<div class="twocolumn_wrapper right">
	<div class="twocolumn" >
		<div class="content" style="height:700px;">		 	 	 	 	 	 		 	 	 	 	 	 				 	 	 	 	 	 	 
			<label><?= _season_start;?></label>
			<p>		
				<?= buildDate($general['dateformat_short'],substr($row->saison_start,2,2),substr($row->saison_start,0,2));?>
			</p>			 	 	 	 	 	 	 
			<label><?= _season_end;?></label>	
			<p>		
				<?= buildDate($general['dateformat_short'],substr($row->saison_end,2,2),substr($row->saison_end,0,2));?>
			</p>
			<label><?= _year;?></label>	
			<p>		
				<?= $row->saison_year;?>
			</p>	 	 	 	 	 	 	 
			<br/>
			<label><?= _day_off;?></label>
			<p>		
				<? echo getWeekdays_select($row->outlet_closeday,'disabled'); ?>
			</p>
			<br/>
			<label><?= _general." "._open_time." & "._close_time;?></label>
			<p>		 	 	 	 	 	 	
				<? 
					echo formatTime($row->outlet_open_time,$general['timeformat']);
					echo " - "; 	 	 	 	 	 	
					echo formatTime($row->outlet_close_time,$general['timeformat']);
				?>
			</p>		 	 	 	 	 	 	 		 	 	 	 	 	 	 
			<br/>
			<label><?= _specific." "._open_time." & "._close_time;?></label>
			<p>	
				<table>
 	 	 	 	 <?
					$day = strtotime("next Monday");
					for ($i=1; $i <= 7; $i++) { 
						$weekday = date("w",$day);
						$field_open = $weekday.'_open_time';
						$field_close = $weekday.'_close_time';
						echo "<tr><td><div class='bold'>".date("l",$day)."</div></td><td style='padding-left:20px;'>".
						date('H:i',strtotime($row->$field_open))." - ".date('H:i',strtotime($row->$field_close)).
						"<br/></td></tr>";
						$day = $day + 86400;
					}
 	 	 	 	 ?>	
				</table>
			</p>
			<br/><br/>
			<label><?= _break;?></label>
			<p>	
				<table>
 	 	 	 	 <?
					$day = strtotime("next Monday");
					for ($i=1; $i <= 7; $i++) { 
						$weekday = date("w",$day);
						$field_open = $weekday.'_open_break';
						$field_close = $weekday.'_close_break';
						echo "<tr><td><div class='bold'>".date("l",$day)."</div></td><td style='padding-left:20px;'>".
						date('H:i',strtotime($row->$field_open))." - ".date('H:i',strtotime($row->$field_close)).
						"<br/></td></tr>";
						$day = $day + 86400;
					}
 	 	 	 	 ?>	
				</table>
			</p>	 	 	 	 	 	 	 	 	 	 	 	 	 	 		 	 	 	 	 	 	 		 	 	 	 	 	 
			<br/><br/>
			<small>				
				<?= _created." ".humanize($row->outlet_timestamp);?>
			</small>
</div>