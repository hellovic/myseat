<div class="twocolumn_wrapper">
 <div class="twocolumn">
  <div class="content detailbig content-height">
	<br/>
	<label><?= _booknum;?></label>
	<p><strong><?= $row->reservation_bookingnumber; ?></strong></p>
	<br/>
	<label><?= _outlets;?></label>
	<p><?= $row->outlet_name; ?></p>
	<br/>
	<label><?= _date;?></label>
	<p>
		<?= date($general['dateformat'],strtotime($row->reservation_date));?>
	</p>
			<label><?= _time; ?></label>
			<p>
				<?= formatTime($row->reservation_time,$general['timeformat']); ?>
			</p>
			<label><?= _title; ?></label>
			<p>
				<? getTitleList($row->reservation_title,'disabled');?>
			</p>
			<label><?= _guest_name; ?></label>
			<p>
				<strong><?
				$_SESSION['reservation_guest_name'] = $row->reservation_guest_name;
				echo $_SESSION['reservation_guest_name']; 
				?></strong>
			</p>
			<label><?= _pax; ?></label>
			<p>
				<?= $row->reservation_pax; ?>
			</p>
		    <label><?= _type; ?></label>
			<p>
					<?= getTypeList($row->reservation_hotelguest_yn,'disabled');?>
		    </p>
			<label><?= _phone_room; ?></label>
			<p>
				<?= $row->reservation_guest_phone; ?>
			</p>
			<label><?= _note; ?></label>
			<p>
				<?= $row->reservation_notes; ?>
			</p>
			<label><?= _author; ?></label>
			<p>
				<?= $row->reservation_booker_name; ?>
			</p>
			<br/>
		</div></div></div> <!-- end left column -->

	<!-- Beginn right column -->	
		<div class="twocolumn_wrapper right">
		 <div class="twocolumn" >
		  <div class="content detailbig content-height">
			<br/>
			<label><?= _adress; ?></label>
			<p>
				<?= $row->reservation_guest_adress; ?>
			</p>
			<label><?= _area_code; ?></label>
			<p>
				<?= $row->reservation_guest_city; ?>
			</p>
			<label><?= _email; ?></label>
			<p>
				<?= $row->reservation_guest_email; ?>
			</p>
			<label><?= _discount; ?></label>
			<p>
				<?= $row->reservation_discount; ?>
			</p>
			<label><?= _parking; ?></label>
			<p>
				<?= $row->reservation_parkticket; ?>
			</p>
			<!-- <label><?= _Tisch; ?></label>
				 <p>
					<?= $row->reservation_table; ?>
				 </p>
			-->

			<label><?= _payment; ?></label>
			<p>
				<span style="width: 250px;">
				<?
				echo _paid."<br>";
				$paid = ($row->reservation_bill_paid) ? 1 : 0;
				echo printOnOff($paid,'reservation_bill_paid')."&nbsp;&nbsp;";
				if($paid){
					humanize($row->reservation_bill_paid);
				} 
				echo "<br>"._shipped."<br>";
				$paid = ($row->reservation_billet_sent) ? 1 : 0;
				echo printOnOff($paid,'reservation_billet_sent')."&nbsp;&nbsp;";
				if($paid){
					humanize($row->reservation_billet_sent);
				} 
				?>
				</span>
			</p>
			<label><?= _paid_by; ?></label>
			<p>
				<? getPaidList($row->reservation_bill,'disabled');?>
			</p>
			<label><?= _multi_booking; ?></label>
			<p>
				<?= $row->start_date;?>
			</p>
			<p>
				<?= $row->end_date;?>
			</p>
			<br/>
			<label><?= _created; ?></label>
			<p><small>
				<?=  humanize($row->reservation_timestamp);?>
			</small></p>
			<br/>
		</div></div></div> <!-- end right column -->
</div>