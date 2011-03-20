<?
if ($_SESSION['button']==2) {
	$row = array();
}else{
	$row = querySQL('event_data_single');	
}

$row['event_date'] = ($row['event_date']) ? $row['event_date'] : date('Y-m-d');
list($sj,$sm,$sd)    = explode("-",$row['event_date']);
$eventdate			 = buildDate($general['dateformat'],$sd,$sm,$sj);
?>
<form method="post" action="?p=6&q=4&btn=1" id="event_form">
	<br/>
	<label><?= _date;?></label>
	<p>	
		<div class="date dategroup">
			<div class="text" id="datetext"><?= $eventdate; ?></div>
			<input type="text" id="ev_datepicker"/>
			<input type="hidden" name="event_date" id="event_date" value=" <?= $row['event_date']; ?> "/>
	    </div>
	</p>	
	<br style='clear:both'><br/>
	<label><?= _outlets;?></label>
	<p>
		<div class="option_xl">
			<div class="text"></div>
				<? getOutletList($row['outlet_id'],'enabled'); ?>
		</div>
	</p>
	<br/>
	<label><?= _advertise_start;?></label>
	<p>
		<div class='option'>
			<div class='text'></div>
			<select name='advertise_start' id='advertise_start' size='1'>
				<?
				//set role
				$range = ($row['advertise_start']) ? $row['advertise_start'] : 30;

				for($i = 0, $size = sizeof($adv_range); $i < $size; ++$i)
				{
						//build dropdown
							echo "<option value='".$adv_range[$i]."' ";
							echo ($adv_range[$i]==$range) ? "selected='selected'" : "";
							echo ">".$adv_range[$i]." "._days." "._before."</option>\n";
				}
				?>
			</select>
		</div>
	</p>
	<br/>	
	<label><?= _subject;?></label>
	<p>
		<input type="text" name="subject" id="subject" class="required" minlength="6" title=' ' style='width: 97%;' value="<?= $row['subject'];?>"/>
	</p>
	<label><?= _description;?></label>
	<p>
		<div class="onecolumn">
		<textarea name="description" id="wysiwyg" style="width: 97%;" cols="35" rows="5" class="wysiwyg required" minlength="6" title=' '><?= $row['description'];?></textarea>
		</div>
	</p>
	<!--
	<label><?= _contact;?></label>
	<p>
		<input type="text" name="contact" id="contact" class="required" title=' ' style='width: 57%;' value="<?= $row['contact'];?>"/>
	</p>
	<label><?= _open_to;?></label>
	<p>
		<input type="text" name="open_to" id="open_to" class="required" title=' ' value="<?= $row['open_to'];?>"/>
	</p>
	-->
	<label><?= _ticket_price;?></label>
	<p>
		<input type="text" name="price" id="price" class="required" title=' ' value="<?= $row['price'];?>"/>
	</p>
	<label><?= _open_time;?></label>
	<p>		 	 	 	 	 	 	
			<? getTimeList($general['timeformat'], $general['timeintervall'],'start_time',$row['start_time']);?>
	</p>
	<label><?= _close_time;?></label>	
	<p>	 	 	 	 	 	 			
			<? getTimeList($general['timeformat'], $general['timeintervall'],'end_time',$row['end_time']);?>
	</p>

	<?php if ($_SESSION['button']!=2): ?> 
		<br/>	 	 	 	 	 	 
		<small>				
			<?= _created." ".humanize($row['created_at']);?>
		</small>
	<?php endif ?>
			<input type="hidden" name="id" value="<?= $row['id'];?>">
			<input type="hidden" name="eventID" value="<?= $row['eventID'];?>">
			<input type="hidden" name="property_id" value="<?= $_SESSION['property'];?>">
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
			<input type="hidden" name="action" value="save_evnt">
	<br/>
	<div style="text-align:center;">
		<input type="submit" class="button_dark" value="<?= _save;?>">
	</div>
</form>
</div>