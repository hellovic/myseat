<!-- Begin example table data -->
<table class="global" style="margin:0px 0px;" cellpadding="0" cellspacing="0">
	<thead>
	    <tr>
			<th style="width:2%">ID</th>
			<th style="width:28%"><?= _name; ?></th>
			<th style="width:5%"><?= _seats; ?></th>
			<th style="width:5%"><?= _tables; ?></th>
			<th style="width:15%"><?= _open_time; ?></th>
			<th style="width:8%"><?= _duration; ?></th>
			<th style="width:18%"><?= _season_start; ?></th>
			<th style="width:5%"><?= _year; ?></th>
			<th style="width:5%"><?= _cuisine_style; ?></th>
	    	<th style="width:5%"><?= _webform; ?></th>
			<th style="width:5%"><?= _delete; ?></th>
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
			<td><strong><a href='?p=101&outletID=".$row->outlet_id."'>".utf8_encode($row->outlet_name)."</a></strong></td>
			<td><strong>".$row->outlet_max_capacity."</strong></td>
			<td><strong>".$row->outlet_max_tables."</strong></td>
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