<!-- Begin reservation table data -->
<table class="global" style="margin:15px 0px 0px 0px;" cellpadding="0" cellspacing="0">
	<thead>
	    <tr <? if($waitlist){echo"style='background: #FFB4B4;'";} ?>>
			<th style="width:10%"><?= _date; ?></th>    	
			<th style="width:5%"><?= _time; ?></th>
			<th style="width:3%"></th>
			<th style="width:25%"><?= _guest_name; ?></th>
			<th style="width:2%"><?= _pax; ?></th>
			<th style="width:10%"><?= _phone_room; ?></th>
			<th style="width:2%"><?= _type; ?></th>
			<th style="width:25%"><?= _outlets; ?></th>
			<th style="width:10%"><?= _author; ?></th>
	    </tr>
	</thead>
	<tbody>
		<?

		$reservations =	querySQL('search_reservations');
		
		if ($reservations) {
			foreach($reservations as $row) {
				// reservation ID
				$id = $row->reservation_id;
				$_SESSION['reservation_guest_name'] = $row->reservation_guest_name;
				// check if reservation is tautologous
				$tautologous = querySQL('tautologous');
				
			echo "<tr id='res-".$id."'>";
			echo"<td>".humanize($row->reservation_date)."</td>
			<td>".formatTime($row->reservation_time,$general['timeformat'])."</td>
			<td>".printTitle($row->reservation_title)."</td>
			<td>
			<strong><a href='?p=102&resID=".$id."' >".utf8_encode($row->reservation_guest_name)."</a></strong>";
			if ($row->repeat_id !=0)
	            {
	            //print out recurring symbol
	            echo "<img src='images/icons/arrow-repeat.png' alt='"._recurring.
					 "' title='"._recurring."' border='0' >";
	            }
			echo"</td>
			<td><strong>".$row->reservation_pax."</strong></td>
			<td>".$row->reservation_guest_phone."</td>
			<td>".$row->reservation_hotelguest_yn."</td>
			<td>".$row->outlet_name."</td>
			<td>".$row->reservation_booker_name."</td>
			</tr>";
			}
		}
		?>
	</tbody>
</table>
<!-- End example table data -->