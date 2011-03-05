<!-- Begin example table data -->
<table class="global" style="margin:0px 0px;" cellpadding="0" cellspacing="0">
	<thead>
	    <tr>
			<th style="width:2%">ID</th>
			<th style="width:33%"><?= _name; ?></th>
			<th style="width:5%"><?= _seats; ?></th>
			<th style="width:5%"><?= _tables; ?></th>
			<th style="width:5%"><?= _open_time; ?></th>
			<th style="width:10%"><?= _close_time; ?></th>
			<th style="width:10%"><?= _season_start; ?></th>
			<th style="width:10%"><?= _season_end; ?></th>
			<th style="width:5%"><?= _year; ?></th>
	    	<th style="width:5%"><?= _webform; ?></th>
			<th style="width:10%"><?= _delete; ?></th>
	    </tr>
	</thead>
	<tbody>
		<?

		$outlets =	querySQL('db_all_outlets');
		
		if ($outlets) {
			foreach($outlets as $row) {
			echo "<tr id='outlet-".$row->outlet_id."'>";
		
			echo "<td>".$row->outlet_id."</td>
			<td><span class='bold'><a href='?p=101&outletID=".$row->outlet_id."'>".utf8_encode($row->outlet_name)."</a></strong></td>
			<td><span class='bold'>".$row->outlet_max_capacity."</strong></td>
			<td><span class='bold'>".$row->outlet_max_tables."</strong></td>
			<td>".formatTime($row->outlet_open_time,$general['timeformat'])."</td>
			<td>".formatTime($row->outlet_close_time,$general['timeformat'])."</td>
			<td>".buildDate($general['dateformat_short'],substr($row->saison_start,2,2),substr($row->saison_start,0,2))."</td>
			<td>".buildDate($general['dateformat_short'],substr($row->saison_end,2,2),substr($row->saison_end,0,2))."</td>
			<td>".$row->saison_year."</td>
			<td>".printOnOff($row->webform)."</td>
		    <td>
					<a href='#modaldelete' name='outlets' id='".$row->outlet_id."' class='deletebtn'>
					<img src='images/icons/delete_cross.png' alt='"._cancelled."' class='help' title='"._delete."'/>
					</a>
		    	</td>
			</tr>";
			}
		}
		?>
	</tbody>
</table>
<!-- End example table data -->