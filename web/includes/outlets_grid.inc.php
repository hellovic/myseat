<!-- Begin example table data -->
<table class="global width-100" cellpadding="0" cellspacing="0">
	<thead>
	    <tr>
			<th>ID</th>
			<th><?= _name; ?></th>
			<th><?= _seats; ?></th>
			<th><?= _tables; ?></th>
			<th><?= _open_time; ?></th>
			<th><?= _duration; ?></th>
			<th><?= _season_start; ?></th>
			<th><?= _year; ?></th>
			<th><?= _cuisine_style; ?></th>
	    	<th><?= _webform; ?></th>
			<th><?= _delete; ?></th>
	    </tr>
	</thead>
	<tbody>
		<?
			if($_SESSION['button'] == 1){
				$outlets =	querySQL('db_all_outlets');
			}else if($_SESSION['button'] == 3){
				$outlets =	querySQL('db_all_outlets_old');
			}
		
		if ($outlets) {
			foreach($outlets as $row) {
			$pr_year = ($row->saison_year==0) ? '&nbsp;' : $row->saison_year;
			
			echo "<tr id='outlet-".$row->outlet_id."'>";
			echo "<td>".$row->outlet_id."</td>
			<td><span class='bold'><a href='?p=101&outletID=".$row->outlet_id."'>".utf8_encode($row->outlet_name)."</a></strong></td>
			<td><span class='bold'>".$row->outlet_max_capacity."</strong></td>
			<td><span class='bold'>".$row->outlet_max_tables."</strong></td>
			<td>".formatTime($row->outlet_open_time,$general['timeformat'])." - ".
			formatTime($row->outlet_close_time,$general['timeformat'])."</td>
			<td>".$row->avg_duration."</td>
			<td>".buildDate($general['dateformat_short'],substr($row->saison_start,2,2),substr($row->saison_start,0,2))." - ".
			buildDate($general['dateformat_short'],substr($row->saison_end,2,2),substr($row->saison_end,0,2))."</td>
			<td>".$pr_year."</td>
			<td><small>".$cuisines[($row->cuisine_style-1)]."</small></td>
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