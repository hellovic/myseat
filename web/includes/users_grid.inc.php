<!-- Begin example table data -->
<table class="global" style="margin:0px 0px;" cellpadding="0" cellspacing="0">
	<thead>
	    <tr>
			<th style="width:5%">ID</th>
			<th style="width:40%"><?= _name; ?></th>
			<th style="width:20%"><?= _email; ?></th>
			<th style="width:10%"><?= _type; ?></th>
			<th style="width:10%">IP</th>
			<th style="width:20%"><?= _time; ?></th>
			<th style="width:5%"></th>
	    </tr>
	</thead>
	<tbody>
		<?

		$users = querySQL('db_all_users');
		
		if ($users) {
			foreach($users as $row) {
			echo "<tr id='user-".$row->userID."'>";
					
			echo"<td>".$row->userID."</td>
			<td><span class='bold'><a href='?p=6&q=2&btn=3&userID=".$row->userID."'>".$row->username."</a></strong></td>
			<td>".$row->email."</td>
			<td>".$roles[$row->role]."</td>
			<td><small>".$row->last_ip."</small></td>
			<td><small>".$row->last_login."</small></td>
		    <td>
				    <a href='#modaldelete' name='users' id='".$row->userID."' class='deletebtn'>
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