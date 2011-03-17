<div id="content_wrapper">
<br/>
	<div class="twocolumn_wrapper">
	 <div class="twocolumn">
	  <div class="content" style="height:710px;">
<!-- Beginn left column -->	
<form method="post" action="ajax/process_reservation.php" id="new_reservation_form">
		<br/>
		<label><?= _time; ?>*</label><br/>
			<div class="option">
				<div class="text"></div>
				<? getTimeList($general['timeformat'], $general['timeintervall'],'reservation_time','',$_SESSION['selOutlet']['outlet_open_time'],$_SESSION['selOutlet']['outlet_close_time'],1);?>
			</div>
		<br/>
			<label><?= _title; ?>*</label><br/>
			<div class="option">
				<div class="text"></div>
				<? getTitleList();?>
			</div>
		<br/>
		<p>
		<label><?= _guest_name; ?>&deg;*</label><br/>
			<input type="text" name="reservation_guest_name" id="reservation_guest_name" class="required" title=' ' minlength="3" style="width:280px;"/>
		</p>
		<br/>
		<p>
		<label><?= _pax; ?>*</label><br/>
			<input type="text" name="reservation_pax" id="reservation_pax" class="required digits" title=' ' />
		</p>
		<br/>
	    <label><?= _type; ?>*</label><br/>
		<div class="option">
			<div class="text"></div>
				<? getTypeList();?>
	    </div>
	    <br/>
		<p>
		<label><?= _phone_room; ?></label><br/>
			<input type="text" name="reservation_guest_phone" id="reservation_guest_phone"/>
		</p>
		<br/>
		<p>
		<label><?= _note; ?></label><br/>
			<textarea name="reservation_notes" id="reservation_notes" rows="5" cols="35" style="width:97%"></textarea>
		</p>
		<br/>
		<p>
		<label><?= _author; ?>&deg;*</label><br/>
			<input type="text" name="reservation_booker_name" id="reservation_booker_name" class='required' minlength="3"  maxlength="30" title=' ' />
		</p>
		<br/>
		<div style="text-align:center;">
			<input type="submit" class="button_dark" value="<?= _save;?>">
		</div>
	</div></div></div> <!-- end left column -->

<!-- Beginn right column -->	
	<div class="twocolumn_wrapper right">
	 <div class="twocolumn" >
	  <div class="content" style="height:710px;">
		<br/>
		<p>
		<label><?= _adress; ?></label><br/>
				<input type="text" name="reservation_guest_adress" id="reservation_guest_adress" />
		</p>
		<br/>
		<p>
		<label><?= _area_code; ?></label><br/>
				<input type="text" name="reservation_guest_city" id="reservation_guest_city" />
		</p>
		<br/>
		<p>
		<label><?= _email; ?>&deg;</label><br/>
				<input type="text" name="reservation_guest_email" id="reservation_guest_email" />
				<small>&nbsp;<?= _fill_out; ?></small><br>
				<small>
					<?= _language; ?>
					<input type="radio" name="email_type" checked="checked" value="no" style="width:20px;"><?= _no_; ?>
					<input type="radio" name="email_type" value="loc" style="width:20px;"><?= _english; ?>
					<input type="radio" name="email_type" value="en" style="width:20px;"><?= _international; ?>
				</small><br>
		</p>
		<br/>		
		<p>
		<label><?= _discount; ?></label><br/>
					<input name="reservation_discount" name="reservation_discount" id="reservation_discount" maxlength="3" style="width:30px;">
		</p>
		<br/>
		<p>
		<label><?= _parking; ?></label><br/>
					<input name="reservation_parkticket" name="reservation_parkticket" id="reservation_parkticket" maxlength="3" style="width:30px;">
		</p>
		<br/>
		<!-- <p><label><?= _Tisch; ?></label><br/>
					<input name="reservation_table" id="reservation_table" maxlength="3" style="width:30px;">
			 </p><br/>
		-->
		<p>
		<label><?= _payment; ?></label><br/>
			<span style="width: 250px;">
			<?= _paid;?>
			<input type="checkbox" style="width:20px; margin-top:10px; margin-right:20px;" name="reservation_bill_paid" value="<? if ($reservation_bill_paid!=""){echo $reservation_bill_paid;} else {echo date($general['dateformat']);} ?>" >
			<?= _shipped;?>
			<input type="checkbox" style="width:20px;" name="reservation_billet_sent" value="<? if ($reservation_billet_sent!=""){echo $reservation_billet_sent;} else {echo date($general['dateformat']);} ?>" > 
			</span>
		</p>
		<br/>
		<label><?= _paid_by; ?></label><br/>
				<div class="option">
					<div class="text"></div>
					<? getPaidList();?>
				</div>
		<br/><br/>
		<p>
		<label><?= _multi_booking; ?></label>
		<br/>
		<input type="radio" class="radio" name="recurring_span" value="1" checked="checked"><img src='images/icons/calendar-select-days-span.png' alt='daily' title='Daily'>&nbsp;
		<input type="radio" class="radio" name="recurring_span" value="7"><img src='images/icons/calendar-select-days.png' alt='weekly' title='Weekly'>
		<div class="date dategroup">
			<div class="text" id="recurring_text"></div>
			<input type="text" name="recurring_date" id="recurring_date"/>
			<input type="hidden" name="recurring_dbdate" id="recurring_dbdate" value="<?= $_SESSION['selectedDate']; ?>"/>
		</div>
		</p>
	</div></div></div> <!-- end right column -->
	<input type="hidden" name="reservation_outlet_id" value="<?= $_SESSION['outletID'];?>">
	<input type="hidden" name="reservation_timestamp" value="<?= date('Y-m-d H:i:s');?>">
	<input type="hidden" name="reservation_ip" value="<?= $_SERVER['REMOTE_ADDR'];?>">
	<input type="hidden" name="token" value="<?php echo $token; ?>" />
	<input type="hidden" name="action" value="save_res">
 </form><!-- end form -->
 <br class="clear">
</div> <!-- end content wrapper -->
<br/><br/><br/>
