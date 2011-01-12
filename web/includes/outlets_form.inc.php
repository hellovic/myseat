<?
if ($_SESSION['button']==2) {
	$row = "";
}
?>
<div class="content" style="height:740px;">
<form method="post" action="?p=6" id="edit_outlet_form">
	<label><?= _property;?></label>
	<p><strong>	 	 				 
		<?= querySQL('db_property');?>
	</strong></p>
	<label><?= _name;?></label>
	<p>
		<input type="text" name="outlet_name" id="outlet_name" class="required" title=' ' value="<?= $row->outlet_name;?>"/>
	</p>
	<label><?= _cuisine_style;?></label>
	<p>
		<div class="option">
			<div class="text"></div>
			<?= cuisineDropdown($cuisines,$row->cuisine_style);?>
		</div>
	</p>
	<br/>
	<label><?= _description;?></label>
	<p style="max-width:500px;">
		<textarea name="outlet_description" id="outlet_description" rows="5" cols="35" class="required" title=' ' style="width:97%"><?= trim($row->outlet_description);?></textarea>
	</p>	
	<label><?= _confirmation_email;?></label>
	<p>
		<input type="text" name="confirmation_email" id="confirmation_email" class="required email" title=' ' value="<?= $row->confirmation_email;?>"/>
	</p>
	<label><?= _seats;?></label>
	<p>		 	 	 	 	 	 	
		<input type="text" name="outlet_max_capacity" id="outlet_max_capacity" class="required digits" title=' ' value="<?= $row->outlet_max_capacity;?>"/>
	</p>
	<label><?= _tables;?></label>	
	<p>	 	 	 	 	 	 	
		<input type="text" name="outlet_max_tables" id="outlet_max_tables" class="required digits" title=' ' value="<?= $row->outlet_max_tables;?>"/>
	</p>
	<label>Max. <?= _passerby;?></label>	
	<p>	 	 	 	 	 	 	
		<input type="text" name="passerby_max_pax" id="passerby_max_pax" class="digits" title=' ' value="<?= $row->passerby_max_pax;?>"/>
	</p>
	<label><?= _open_time;?></label>
	<p>		 	 	 	 	 	 	
			<? getTimeList($general['timeformat'], $general['timeintervall'],'outlet_open_time',$row->outlet_open_time);?>
	</p>
	<label><?= _close_time;?></label>	
	<p>	 	 	 	 	 	 			
			<? getTimeList($general['timeformat'], $general['timeintervall'],'outlet_close_time',$row->outlet_close_time);?>
	</p>
	<label><?= _duration;?></label>	
	<p>	 	 	 	 	 	 			
			<? getDurationList($general['timeintervall'],'avg_duration',$row->avg_duration);?>
	</p>		 	 	 	 	 	 		 	 	 	 	 	 				 	 	 	 	 	 	 
	<br class="clear">
		<input type="submit" class="button_dark" value="<?= _save;?>"/>		 	 	 	 	 	 	 			 	 	 	 	 	 	
</div></div></div> <!-- end left column -->
<!-- Beginn right column -->	
<div class="twocolumn_wrapper right">
	<div class="twocolumn" >
		<div class="content" style="height:740px;">
			<label><?= _season_start;?></label>
			<p>		
				<?
				// buildDate($general['dateformat_short'],substr($row->saison_start,2,2),substr($row->saison_start,0,2));
				echo monthDropdown('saison_start_month',substr($row->saison_start,0,2)); 
				echo dayDropdown('saison_start_day',substr($row->saison_start,2,2));
				?>
			</p>			 	 	 	 	 	 	 
			<label><?= _season_end;?></label>	
			<p>		
				<?
				// buildDate($general['dateformat_short'],substr($row->saison_end,2,2),substr($row->saison_end,0,2));
				echo monthDropdown('saison_end_month',substr($row->saison_end,0,2));
				echo dayDropdown('saison_end_day',substr($row->saison_end,2,2));
				?>
			</p>
			<label><?= _year;?></label>	
			<p>
				<div class="option">
					<div class="text"></div>
					<?= yearDropdown('saison_year',$row->saison_year); ?>
				</div>
			</p>
			<br/>
			<label><?= _day_off;?></label>
			<p>	
				<? echo getWeekdays_select($row->outlet_closeday); ?>	
			</p>
			<!--
			<label><?= _password;?></label>
			<p>		
				<input type="text" name="password" id="password" class="digits" title=' ' value="<?= $row->password;?>"/>
			</p>
			-->			 	 	 	 	 	 	 		 	 	 	 	 	 	 
			<label><?= _webform;?></label>
			<p>		
				<?= printOnOff($row->webform,'webform','');?>
			</p>	 	 	 	 	 	 	 		 	 	 	 	 	 	 
			<br/><br/>
			<?php if ($_SESSION['button']!=2): ?> 	 	 	 	 	 	 
				<small>				
					<?= _created." ".humanize($row->outlet_timestamp);?>
				</small>
			<?php endif ?>	
			<input type="hidden" name="outlet_id" value="<?= $row->outlet_id;?>">
			<input type="hidden" name="property_id" value="<?= $_SESSION['property'];?>">
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
			<input type="hidden" name="action" value="save_out">
</form>
</div>