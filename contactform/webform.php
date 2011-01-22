<?
  include('part/header.php');
  
    // outlet id
    if (!$_SESSION['outletID']) {
	$_SESSION['outletID'] = ($_GET['outletID']) ? (int)$_GET['outletID'] : querySQL('standard_outlet');
    }elseif ($_GET['id']) {
        $_SESSION['outletID'] = (int)$_GET['id'];
    }elseif ($_POST['id']) {
        $_SESSION['outletID'] = (int)$_POST['id'];
    }
    // property id
    if ($_GET['prp']) {
        $_SESSION['property'] = (int)$_GET['prp'];
    }elseif ($_POST['prp']) {
        $_SESSION['property'] = (int)$_POST['prp'];
    }
    // selected date
    if ($_GET['selectedDate']) {
        $_SESSION['selectedDate'] = $_GET['selectedDate'];
    }elseif ($_POST['selectedDate']) {
        $_SESSION['selectedDate'] = $_POST['selectedDate'];
    }elseif (!$_SESSION['selectedDate']){
        //$_SESSION['selectedDate'] = date('Y-m-d');
    }
  //prepare selected Date
    list($sy,$sm,$sd) = explode("-",$_SESSION['selectedDate']);
  
  // get Pax by timeslot
    $resbyTime = reservationsByTime();
  // get availability by timeslot
    $availability = getAvailability($resbyTime,$general['timeintervall']);
  // some constants
    $bookingdate = date($general['dateformat'],strtotime($_POST['dbdate']));
    $outlet_name = querySQL('db_outlet');
?>

<!-- page container -->
  <div id="page"> 
    <!-- page title -->
    <h2 class="ribbon full">Get your table <span>Make an instant reservation</span> </h2>
    <div class="triangle-ribbon"></div>
    <br class="cl" />
    <!-- page content -->
    <div id="page-content" class="container_12">
      
      <h3><?= $outlet_name." - ".buildDate($general['dateformat'],$sd,$sm,$sy); ?></h3>
	
      <div style='font-size:1.3em; font-weight:bold;'>
	  <?
	    echo _edit." "._outlets."<br/><br/>";
	    getOutletList($_SESSION['outletID'],'enabled','reservation_outlet_id');
	  ?>
      </div>
      <br/>
      <div id="message">
      </div>
      <!-- Datepicker -->
      <label> </label><div id="bookingpicker"></div>
      <input type="hidden" name="dbdate" id="dbdate" value="<?= $_SESSION['selectedDate']; ?>"/>
      
      <form method="post" action="booking_done.php?p=10" name="new_reservation_form" id="new_reservation_form">
        <input type="hidden" name="reservation_date" value="<?= $_SESSION['selectedDate'];?>">
        <input type="hidden" name="recurring_dbdate" value="<?= $_SESSION['selectedDate']; ?>"/>
		<p>
                <label><?= _time; ?>*</label>
			<div class="option">
				<div class="text"></div>
				<? getTimeList($general['timeformat'], $general['timeintervall'],'reservation_time','',$_SESSION['selOutlet']['outlet_open_time'],$_SESSION['selOutlet']['outlet_close_time'],1);?>
			</div>
		</p>
                <br/>
                <p>
			<label><?= _title; ?>*</label>
			<div class="option">
				<div class="text"></div>
				<? getTitleList();?>
			</div>
		</p>
                <br/>
		<p>
		<label><?= _guest_name; ?>*</label>
			<input type="text" name="reservation_guest_name" id="reservation_guest_name" class="required" title=' ' minlength="3" style="width:280px;"/>
		</p>
		<p>
		<label><?= _pax; ?>*</label>
			<input type="text" name="reservation_pax" id="reservation_pax" class="required digits small" title=' ' />
		</p>
		<p>
		<label><?= _email; ?>*</label>
				<input type="text" name="reservation_guest_email" class="required email" id="reservation_guest_email" title=' '/>
				<br>
                                <label> </label>
                                <small>&nbsp;<?= _fill_out; ?></small>
                                <br>
		</p>
        <p>
        <label><?= _phone; ?>*</label>
                <input type="text" name="reservation_guest_phone" class="required" title=' ' minlength="3" id="reservation_guest_phone"/>
        </p>
        <p>
        <label><?= _note; ?></label>
                <textarea name="reservation_notes" id="reservation_notes" rows="5" cols="35" style="width:80%"></textarea>
        </p>
        <p>
          <label for="verify">1 + 3 =</label>
          <input name="verify" id="verify" class="required digits small" title=' ' type="text" />
        </p>
        <p class="tc">
          <!-- hidden input fields -->
          <input type="hidden" name="reservation_hotelguest_yn" value="PASS">
          <input type="hidden" name="reservation_outlet_id" value="<?= $_SESSION['outletID'];?>">
          <input type="hidden" name="reservation_timestamp" value="<?= date('Y-m-d H:i:s');?>">
          <input type="hidden" name="reservation_ip" value="<?= $_SERVER['REMOTE_ADDR'];?>">
          <input type="hidden" name="reservation_booker_name" value="Online-Booking">
          <input type="hidden" name="token" value="<?php echo $token; ?>" />
          <input type="hidden" name="action" value="save_book">
          <button type="submit" id="submit">Make reservation</button>
        </p>
        <div class="error"></div>
      </form>
    </div>
    <br class="cl" />
    <br class="cl" />
  </div>
  
<?
  include('part/footer.php');
?>

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
  $("#bookingpicker").datepicker('setDate', new Date ( "<?= $_SESSION['selectedDate']; ?>" ));
  $("#ui-datepicker-div").hide();
  $("#reservation_outlet_id").change(function(){
	window.location='booking.php?outletID=' + this.value;
      });
});
</script>