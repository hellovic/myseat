<!-- Begin reservation table data -->

<table class="global" style="margin:15px 0px 0px 0px;" cellpadding="0" cellspacing="0">
	<thead>
	    <tr <? if($waitlist){echo"style='background: #FFB4B4;'";} ?>>
	    	<th style="width:5%"><?= _time; ?></th>
			<th style="width:2%"></th>
			<th style="width:15%"><?= _guest_name; ?></th>
			<th style="width:2%"><?= _pax; ?></th>
			<th style="width:10%"><?= _phone_room; ?></th>
			<th style="width:2%"><?= _type; ?></th>
			<th style="width:35%"><?= _note; ?></th>
			<th style="width:10%" class='noprint'><?= _author; ?></th>
			<?
			if($_SESSION['wait'] == 0){
				echo "<th style='width:2%'>"._table."</th>";
			}
			?>
	    	<th style="width:2%"><?= _status; ?></th>
			<th></th>
			<th style="width:2%" class='noprint'><?= _edit; ?></th>
	    </tr>
	</thead>
	<tbody>
		<?

		$reservations =	querySQL('reservations');
		
		if ($reservations) {
			foreach($reservations as $row) {
				// reservation ID
				$id = $row->reservation_id;
				$_SESSION['reservation_guest_name'] = $row->reservation_guest_name;
				// check if reservation is tautologous
				$tautologous = querySQL('tautologous');
				
			echo "<tr id='res-".$id."'>";
			echo "<td";
			// reservation after maitre message
			if ($row->reservation_timestamp > $maitre['maitre_timestamp'] && $maitre['maitre_comment_day']!='') {
				echo " style='color:#FF0000;' title='"._sentence_13."' ";
			}
			// daylight coloring
			if ($row->reservation_time > $daylight_evening){
				echo " class='evening' ";
			}else if ($row->reservation_time > $daylight_noon){
				echo " class='afternoon' ";
			}else if ($row->reservation_time < $daylight_noon){
				echo " class='morning' ";
			}
			
			echo "><span class='bold'>".formatTime($row->reservation_time,$general['timeformat'])."</strong></td>
			<td>".printTitle($row->reservation_title)."</td>
			<td>
			<span class='bold'><a href='?p=102&resID=".$id."'"; 
			// color guest name if tautologous
			if($tautologous>1){echo" style='color: #936;' title='"._tautologous_booking."'";}
			echo ">".utf8_encode($row->reservation_guest_name)."</a></strong>";
			if ($row->repeat_id !=0)
	            {
	            //print out recurring symbol
	            echo "&nbsp;<img src='images/icons/arrow-repeat.png' alt='"._recurring.
					 "' title='"._recurring."' border='0' >";
	            }
			echo"</td>
			<td><span class='bold'>".$row->reservation_pax."</strong></td>
			<td>".$row->reservation_guest_phone."</td>
			<td>".$row->reservation_hotelguest_yn."</td>
			<td>".$row->reservation_notes."</td>
			<td class='noprint'>".$row->reservation_booker_name."</td>";
			//<td><small>".humanize($row->reservation_timestamp)."</small></td>
			if($_SESSION['wait'] == 0){
				echo "<td class='big tb_nr'><div id='reservation_table-".$id."' class='inlineedit noprint'>".$row->reservation_table."</div></td>";
			}
			echo "<td><div class='noprint'>";
				getStatusList($id, $row->reservation_status);
			echo "</div></td>";
			echo "<td class='noprint'>";
				if( (strtotime($row->reservation_timestamp) + $general['old_days']*86400) <= time() ){
					echo "<img src='images/icons/clock-ex.png' class='help' title='"._sentence_11."' style='float:right;'/>";
				}
			echo "</td>";
			echo "<td style='padding:7px 0px;' class='noprint'>";
			// DELETE BUTTON
			if ( current_user_can( 'Reservation-Delete' ) ){
		    	echo"<a href='#modalsecurity' name='".$row->repeat_id."' id='".$id."' class='delbtn'>
					<img src='images/icons/delete_cross.png' alt='"._cancelled."' class='help' title='"._delete."'/></a>";
			}
			// MOVE BUTTON
			//	echo "<a href=''><img src='images/icons/arrow.png' alt='move' class='help' title='"._move_reservation_to."'/></a>";
			
			// WAITLIST ALLOW BUTTON
			if($_SESSION['wait'] == 1){
				$leftspace = leftSpace(substr($row->reservation_time,0,5), $availability);
				if($leftspace >= $row->reservation_pax && $_SESSION['outlet_max_tables']-$tbl_availability[substr($row->reservation_time,0,5)] >= 1){	    
					echo"&nbsp;<a href='' name='".$id."' class='alwbtn'><img src='images/icons/icon_accept.png' name='".$id."' alt='"._allow."' class='help' title='"._allow."'/></a>";
				}
			}
		echo"</td></tr>";
			}
		}
		?>
	</tbody>
</table>
<!-- End reservation table data -->